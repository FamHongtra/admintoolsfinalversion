<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use SSH;
use Redirect;
use App\User;

class UserController extends Controller
{
  //
  public function login(Request $request)
  {
    //
    $username = $request->input('userlogin_username');
    $password = $request->input('userlogin_password');

    // $password_encrypted = Crypt::encryptString($password);
    // $password_decrypted = Crypt::decryptString($password_encrypted);

    $user = DB::table('users')
    ->where('username',$username)
    ->get();



    if(count($user)!=0){
      $password_decrypted =  Crypt::decryptString($user[0]->password);
      if($password == $password_decrypted){

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
      $request->session()->flash('title', 'Login Failed!');
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

  public function create(Request $request)
  {
    //
    $user_name = $request->input('newuser_name');
    $user_username = $request->input('newuser_username');
    $user_email = $request->input('newuser_email');

    $user_password = str_random(8);

    $password_encrypted = Crypt::encryptString($user_password);
    $password_decrypted = Crypt::decryptString($password_encrypted);

    $token_name = $user_name.'token';

    $user_hasusername = DB::table('users')
    ->where('username',$user_username)
    ->get();


    if(count($user_hasusername)==0){

      //Gitlab API Create User
      SSH::into('gitlab')->run(array(
        "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: jbVyzyHKVahx8WHz2d59' --data 'username=$user_username' --data 'password=$user_password' --data 'name=$user_name' --data 'email=$user_email' --data 'skip_confirmation=true' http://52.221.75.98/api/v4/users",
      ), function($line){
        $jsonArray = json_decode($line);
        $GLOBALS['gitlab_userid'] = $jsonArray->id;
        // print_r("User ID: ".$jsonArray->id);
      });

      $gitlab_userid = $GLOBALS['gitlab_userid'];

      SSH::into('gitlab')->run(array(
        "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: jbVyzyHKVahx8WHz2d59' --data 'name=$token_name' --data 'expires_at=2018-01-01' --data 'scopes[]=api' http://52.221.75.98/api/v4/users/$gitlab_userid/impersonation_tokens",
      ), function($line){
        $jsonArray = json_decode($line);
        $GLOBALS['gitab_token'] = $jsonArray->token;
        // print_r("Impersonal Token: ".$jsonArray->token);
      });

      $gitlab_token = $GLOBALS['gitab_token'];

      $obj = new User();
      $obj->name = $user_name;
      $obj->username = $user_username;
      $obj->password = $password_encrypted;
      $obj->email = $user_email;
      $obj->gitlab_userid = $gitlab_userid;
      $obj->token = $gitlab_token;
      $obj->save();

      $request->session()->flash('status', 'username duplicate');
      $request->session()->flash('title', 'Create User Successful!');
      $request->session()->flash('text', 'Username: '.$user_username.", Password: ".$user_password);
      $request->session()->flash('icon', 'success');

      return redirect('showhost');
    }else{
      $request->session()->flash('status', 'username duplicate');
      $request->session()->flash('title', 'Create User Failed!');
      $request->session()->flash('text', 'Username aready exists, please use another.');
      $request->session()->flash('icon', 'error');

      return redirect('showhost');
    }
  }



}
