<?php

namespace App\Http\Controllers;

use App\Models\BankUser;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    //
    public function AllBanks(){
        $banks = User::whereHas('roles', function($q) {
            $q->where('name', 'bank')->where('verified',1);
        })->get();

        
        $html = ' <select class="form-select" id="bank" aria-label="State"   name="bank"><option value="">Select Bank</option>';

        if (count($banks) > 0) {
            foreach ($banks as $bank) {
                $html .= '<option value="' . $bank->id . '">' . $bank->name . '</option>';
            }
        }

        $html .= '</select><label for="floatingSelect">Bank</label>';
        return $html;
        
     
        
    }
    public function AllBankTransactions(){
        $bank = Auth::user();
        $transactions =  $bank->BankTransactions();
 
        return view('bank.bank_transations',['user'=>$bank,'transactions'=>$transactions]);
    }

    public function VerifyTransaction(int $tid){
       
        $transaction = Transaction::where('id', $tid)->first();

       
        if(!$transaction){
            $html = '<div class="alert  alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Failed !</strong> Transaction Not found! 
    
        </div>';
        return $html;
        }

        if($transaction->verified){
            $transaction->verified=0;
            $msg= "Has set to Not verified!";
        }else{
            $transaction->verified=1;
            $msg= "Has set to verified!";
        }
        
        $transaction->save();
        

        if(($transaction)&&$transaction->save()){
            $html = '<div class="alert  alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Success !</strong> Transaction get '.$msg.' 
    
        </div>';
        }else{
            $html = '<div class="alert  alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Failed !</strong> Transaction get '.$msg.' 
    
        </div>';
        }
        return $html;
    }

    public function BankAllUsers(){
         $bank = Auth::user();

          
         $users = $bank->users;
        
     
         return view('bank.users_request',['user'=>$bank,'users'=>$users]);
    }
    public function VerifyUser(int $bid){
        $bankuser = BankUser::where('id',$bid)->first();

        if(!$bankuser){
            return "Error occured";
        }
        $bankuser->verified = $bankuser->verified==0?1:0;
        if($bankuser->save()){
            return "Done";
        }else{
            return "Failed";
        }
    }
}
