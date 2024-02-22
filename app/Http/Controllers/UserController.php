<?php

namespace App\Http\Controllers;

use App\Models\Address;
 
use App\Models\BankUser;
use App\Models\country;
use App\Models\Role;
use App\Models\User;
use App\Models\state;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 

class UserController extends Controller
{
    //
    public function Home(Request $req)
    {
        $user = Auth::user();
        $limit_page = 5;
        $current_page = (isset($req->page)) ? $req->page : 1;
        $offset_till = ($current_page - 1) * $limit_page;
        // $sort_column =  
        $total_users = User::all()->count();
        $sort_column = (isset($req->sort_column)) ? $req->sort_column : 'created_at';
        // return $sort_column;
        if (isset($req->sort_ord) && $req->sort_ord == 'desc') {
            $users = User::all()->sortByDesc($sort_column)->skip($offset_till)->take($limit_page);
        } else {
            $users = User::all()->sortBy($sort_column)->skip($offset_till)->take($limit_page);
        }

        // // we can use this too 
        // // $users = User::paginate(5);
        // $users = User::simplePaginate(5);
        // return $users;

        return view('home', ['user' => $user, 'users' => $users, 'total_users' => $total_users, 'limit_page' => $limit_page, 'current_page' => $current_page]);
    }

    public function Show()
    {
        $user = DB::table('users')->get();
        return $user;
    }
    public function SingleUser()
    {
        $user = Auth::user();
       
       
        
        $transactions = Transaction::where('sender_id',$user->id)->orWhere('receiver_id',$user->id)->with('sender','receiver')->get();
       

         $netBalance = 0;
      
        foreach ($transactions as $t) {
            $tamount = $t->sender_id==$user->id? $t->amount: -$t->amount;

            $netBalance = $netBalance + $tamount;
        }
        $addresses = [];
        $address_details=[];
        if(!$user->hasRole('admin')){

        
             $addresses=User::findOrFail($user->id)->addresses;
        foreach ($addresses as $address) {
             
            $city = $address->city; //b7 accessing belongsto relaton
            $state = $city->state;
            $country = $state->country;
            $address_details[] = [$city->name, $state->name, $country->name,];
        }
    }
        return view('user.profile', ['user' => $user, 'addresses' => $address_details, 'transactions' =>  $transactions, 'netBalance' => $netBalance]);
    }

    public function AddUserView()
    {
        $countries = country::all();
        return view('adduser', ['countries' => $countries]);
    }
    public function AddUser(Request $req)
    {
        $user = User::where('email', $req->email)->first();
        if ($user) {
            return redirect('/')->with(['msg' => "User With this email already exist", 'isError' => true]);
        }
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,

        ]);
        $address = new Address;
        $address->city_id = $req->city;
        $address->state_id = $req->state;
        $address->country_id = $req->country;
        $address->user_id = $user->id;
        $address->save();

        if ($user) {
            $isError = false;
            $msg = "User Inserted!";
        } else {
            $isError = true;
            $msg = "User Insertion failed!";
        }

        return redirect('/')->with(['msg' => $msg, 'isError' => $isError]);
    }
    public function DeleteUser(Request $req)
    {
        $user = User::find($req->id);

        if (!$user) {
            $isError = true;
            $msg = "User not found!";
        } else {
            $user->delete();
            $isError = false;
            $msg = "User Deleted!";
        }
        return redirect('/')->with(['msg' => $msg, 'isError' => $isError]);
    }
    public function UpdateUser(Request $req)
    {
        $user = User::find($req->id);

        if (!$user) {
            $isError = true;
            $msg = "User not found!";
        } else {
            $validate = $req->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email,' . $user->id,
            ]);

            $user->update($validate);
            $isError = false;
            $msg = "User Updated!";
        }

        return redirect("/profile/?to=edit")->with(['msg' => $msg, 'isError' => $isError]);
    }
    public function  GetAddresses(int $id)
    {
        $addresses  = User::findOrFail($id)->addresses;

        foreach ($addresses as $address) {
            // $city = City::find($add->city_id);
            // $country = country::find($add->country_id);
            // $state = state::find($add->state_id);
            // $address = ;
            $city = $address->city;
            $state = $city->state;
            $country = $state->country;
            $address_details[] = [$city->name, $state->name, $country->name,];
        }
        return $address_details;
    }
    public function GetStates(int $cid)
    {
        $states = Country::findOrFail($cid)->states;
        $html = ' <select class="form-select" id="floatingSelect" name="state" aria-label="State" onchange="showCities(this.value)"> <option value="">Select State</option>';

        if (count($states) > 0) {

            foreach ($states as $state) {
                $html .= '<option value="' . $state->id . '">' . $state->name . '</option>';
            }
        }
        $html .= '</select><label for="floatingSelect">State</label>';
        return $html;
    }


    public function GetCity(int $sid)
    {
        $cities = state::findOrFail($sid)->cities;
        $html = ' <select class="form-select" id="floatingSelect" aria-label="State"   name="city"><option value="">Select City</option>';

        if (count($cities) > 0) {
            foreach ($cities as $city) {
                $html .= '<option value="' . $city->id . '">' . $city->name . '</option>';
            }
        }

        $html .= '</select><label for="floatingSelect">City</label>';
        return $html;
    }

    public function GetRoles(int $uid)
    {

        $user = User::find($uid);
        $roles = $user->roles;
        foreach ($roles as $r) {
            $t[] = $r->pivot->created_at;
        }
        return response()->json([$roles, $t]);
    }

    public function GetDashboard()
    {
        
        $user = Auth::user();
        
     
        $users = User::all()->except($user->id);
        // $senders_transactions = User::find($user->id)->transactions_send();
        // $receivec_transactions = User::find($user->id)->transactions_receive();
        // return [$senders_transactions, $receivec_transactions];
        // $transactions = Transaction::where('sender_id',$user->id)->orWhere('receiver_id',$user->id)->get()->flatMap(function($value){
        //       if(!(in_array($transactions($value->sender_id)))){
        //         return $value->sender_id;
        //       }
        // });

        $users = Transaction::where('sender_id', $user->id)
        ->orWhere('receiver_id', $user->id)
        ->with('sender', 'receiver')
        ->get()
        ->flatMap(function ($value) use ($user) {
            return [ $value->sender->id != $user->id ? $value->sender : $value->receiver ];
        })
        ->unique();
    
 
    

        return view('user.dashboard', ['user' => $user, 'users'=>$users]);
    }
    public function AskBankRequest(){
        $banks = User::whereHas('roles', function($q) {
            $q->where('name', 'bank')->where('verified',1);
        })->get();
        $user=Auth::user();

        return view('user.request_bank',['user'=>$user,'banks'=>$banks]);
    }
    public function AddRequestBank(Request $req){
        $user = Auth::user();
        
        $bankuser = BankUser::firstOrNew([
            'user_id'=>$user->id,
            'bank_id'=>$req->bank,
            
        ]);
        $bankuser->save();
        
        return redirect('/askbankrequest')
        ->with('isError', 0)
        ->with('msg', 'Request Sent');
    
    }

    //admin parts

  

    // public function
}
