<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\User;
 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //


    public function GetAddTransaction(Request $req)
    {
        $selected_receiver='none';
        $user= Auth::user();
        if($req->has('user')){
            $selected_receiver = User::where('id',$req->input('user'))->get('id')->first();
            if(!$selected_receiver){
                return redirect('/dashboard')->with(['msg' => "User not found!", 'isError' => true]);

            }
            if( $selected_receiver->id==$user->id){
                return redirect('/dashboard')->with(['msg' => "You can't pay youselve's!", 'isError' => true]);
            }
        }
 
        $users = $user->allExceptAdmins();
        // return $users;
        $users = $users->filter(function ($u) use ($user) {
            return $u->id !== $user->id;
        });
        return view('user.addtransaction', ['users' => $users,'user'=>$user, 'selected_receiver'=>$selected_receiver]);
    }
    public function AddTransaction(Request $req)
    {
        
        $user = Auth::user();
        if($req->type=='taken'){
            $sender_user=(int)$req->whom;
            $receiver_user = $user->id;
        }else if($req->type=='given'){
            $receiver_user=(int)$req->whom;
            $sender_user = $user->id;
        }
        // return [$receiver_user, $sender_user];
        $transaction = new Transaction;
        $amount = $req->amount;
        $transaction->amount = $amount;
        $transaction->receiver_id = $receiver_user;
        $transaction->sender_id = $sender_user;
        if($req->mode=="online"){
            $transaction->bank_id=$req->bank;
            $transaction->verified = 0;
        }else{
            $transaction->verified = 1;
        }
        $transaction->mode= $req->mode;

        if ($transaction->save() || isset($req->bank) && $req->bank=="")  {

            return redirect('/dashboard' )->with(['msg' => 'Transaction added successfully', 'isError' => false]);
        } else {

            return redirect('/dashboard')->with(['msg' => 'Transaction addition failed', 'isError' => true]);
        }
    }

    public function GetNetBalance(int $userId)
    {
        $user = User::find($userId);
        $latest = User::find($userId)->latestTransaction;
        $oldest = User::find($userId)->oldestTransaction;
        $maxTransaction = User::find($userId)->highestAmountGiven;
        $minT = $user->lowestAmount;
        $sum = $user->getNetBalance;
        return dump($latest, $oldest, $maxTransaction, $minT, $sum);
    }

    public function GetUserTransactions(int $uid){
        $user_transaction = User::find($uid) ;
        if(!$user_transaction){
            return redirect('/dashboard')->with(['msg' => 'No user found', 'isError' => true]);
        }
        $user = Auth::user();  
        if($uid==$user->id){
            return redirect('/dashboard')->with(['msg' => 'You can`t see youselves transactions', 'isError' => true]);

        }
        // $transactions = Transaction::where(function ($query) use($user,$user))->where('sender_id',$user_transaction->id).orWhere('receiver_id',$user->id)
      
              $transactions = $user->trasactionsWith($user_transaction);
      
              foreach ($user_transaction->addresses as $address) {
             
                $city = $address->city; //b7 accessing belongsto relaton
                $state = $city->state;
                $country = $state->country;
                $address_details[] = [$city->name, $state->name, $country->name,];
            }
        // return $transactions;
        return view('user.per_user_transaction',['user'=>$user,'user_transaction'=>$user_transaction, 'transactions'=>$transactions,  'addresses'=>$address_details]);
    }
    

}
