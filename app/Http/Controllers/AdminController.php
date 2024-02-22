<?php

namespace App\Http\Controllers;

use App\Models\Role;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function GetAllUsers(){
        $user= Auth::user();
        $users = User::all()->except([$user->id,'password']) ;
         
       $roles = Role::all('id','name');
  
       return view('admin.users',['users'=>$users, 'user'=>$user, 'roles'=>$roles]);
    }
    public function AssignRoles(int $uid, int $rid, int $ischecked){
         $user = User::find($uid);
         $role = Role::find($rid);
         if($ischecked){
            $user->assignRole($role);
         }else{
            $user->removeRole($role);
         }
         
    }

    public function accountVerifyAction(int $id){
      
      $user = User::where('id',$id)->first();
      
      if(!$user){
         return "Error occured";
      }

      $user->verified = $user->verified==0?1:0;
      
      if($user->save()){
         return "Done";
      }else{
         return "Failed";
      }
    }
}
