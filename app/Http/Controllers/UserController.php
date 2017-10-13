<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;

class UserController extends Controller
{
  //
  public function login(Request $request)
  {
    //
    $username = $request->input('userlogin_username');
    $password = $request->input('userlogin_password');

    $password_encrypted = Crypt::encryptString($password);
    $password_decrypted = Crypt::decryptString($password_encrypted);

    $user = DB::table('users')
    ->where('username',$username)
    ->get();

    if(count($user)!=0){
      if($password == $user[0]->password){

        $user_id = $user[0]->id;

        $objs = DB::table('hosts')
        ->join('controls', 'hosts.id', '=', 'controls.host_id')
        ->where('controls.user_id', $user_id)
        ->where('controls.group_id', 0)
        ->get();

        $all_group = DB::table('groups')
        ->where('user_id', $user_id)
        ->get();

        $data['objs'] = $objs;
        $data['all_group'] = $all_group;
        $data['user_id'] = $user_id;

        session(['user_id' => $user_id]);

        return view('showhost',$data);
      }else{
        $request->session()->flash('status', 'user login fail');
        $request->session()->flash('title', 'Login Failed!');
        $request->session()->flash('text', 'Unable to login, please try again.');
        $request->session()->flash('icon', 'error');

        return redirect('login');
      }
    }else{
      $request->session()->flash('status', 'user login fail');
      $request->session()->flash('title', 'login Failed!');
      $request->session()->flash('text', 'Unable to login, please try again.');
      $request->session()->flash('icon', 'error');

      return redirect('login');
    }
  }

  public function logout()
  {
    session()->forget('user_id');
    return redirect('login');
  }

}
