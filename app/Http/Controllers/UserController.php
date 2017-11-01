<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use SSH;
use Redirect;
use App\User;
use Mail;

class UserController extends Controller
{
  //***Gitlab API PRIVATE-TOKEN(root): jbVyzyHKVahx8WHz2d59


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

        if($user[0]->set_password == "no"){

          $request->session()->flash('status', 'change password');
          $request->session()->flash('username', $username);
          $request->session()->flash('password', $password);
          // $request->session()->flash('title', 'Login Failed!');
          // $request->session()->flash('text', 'Unable to login, please try again.');
          // $request->session()->flash('icon', 'error');

          return redirect('login');

        }else{

          $user_id = $user[0]->id;

          $objs = DB::table('hosts')
          ->join('controls', 'hosts.id', '=', 'controls.host_id')
          ->where('controls.user_id', $user_id)
          ->where('controls.group_id', 0)
          ->where('controls.control_type', "server")
          ->get();

          $all_group = DB::table('groups')
          ->where('user_id', $user_id)
          ->where('group_type', "server")
          ->get();

          $data['objs'] = $objs;
          $data['all_group'] = $all_group;
          $data['user_id'] = $user_id;

          session(['user_id' => $user_id]);

          return view('showhost',$data);
        }
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

    $generated_by = DB::table('users')
    ->where('id',session('user_id'))
    ->value('username');

    $user_hasusername = DB::table('users')
    ->where('username',$user_username)
    ->get();

    $user_hasemail = DB::table('users')
    ->where('email',$user_email)
    ->get();

    if(count($user_hasusername)==0 && count($user_hasemail)==0){


      $obj = new User();
      $obj->name = $user_name;
      $obj->username = $user_username;
      $obj->password = $password_encrypted;
      $obj->set_password = "no" ;
      $obj->email = $user_email;
      $obj->gitlab_userid = "999999";
      $obj->token = "null";
      // $obj->gitlab_userid = $gitlab_userid;
      // $obj->token = $gitlab_token;
      $obj->save();

      $data['email'] = $user_email ;
      $data['generated_by'] = $generated_by ;
      $data['username'] = $user_username ;
      $data['password'] = $user_password ;

      $aat_email = 'aat.seniorproject@gmail.com';
      $email_name = 'no-reply@admintools.info';
      $email_subject = 'Password generated by Admintools';

      $GLOBALS['aat_email'] = $aat_email;
      $GLOBALS['email_name'] = $email_name;
      $GLOBALS['email_subject'] = $email_subject;

      $GLOBALS['email'] = $user_email;

      Mail::send('emails.mailme', $data, function($message)
      {
        $message->from($GLOBALS['aat_email'], $GLOBALS['email_name']);
        $message->to($GLOBALS['email']);
        $message->subject($GLOBALS['email_subject']);
      });

      $request->session()->flash('status', 'username not duplicate');
      $request->session()->flash('title', 'Create User Successful!');
      // $request->session()->flash('text', 'Username: '.$user_username.", Password: ".$user_password);
      $request->session()->flash('text', 'We have sent a random password generated to this email: '.$user_email);
      $request->session()->flash('icon', 'success');

      if(session('user_id')!=null){
        return redirect('showhost');

      }else{

        return redirect('login');
      }

    }else{

      if(count($user_hasusername) != 0 && count($user_hasemail) != 0){
        $request->session()->flash('status', 'username duplicate');
        $request->session()->flash('title', 'Create User Failed!');
        $request->session()->flash('text', 'Username and E-mail aready exists, please use another.');
        $request->session()->flash('icon', 'error');

        return redirect('showhost');

      }else if(count($user_hasusername) != 0){
        $request->session()->flash('status', 'username duplicate');
        $request->session()->flash('title', 'Create User Failed!');
        $request->session()->flash('text', 'Username aready exists, please use another.');
        $request->session()->flash('icon', 'error');

        return redirect('showhost');

      }else{
        $request->session()->flash('status', 'username duplicate');
        $request->session()->flash('title', 'Create User Failed!');
        $request->session()->flash('text', 'E-mail aready exists, please use another.');
        $request->session()->flash('icon', 'error');

        return redirect('showhost');

      }


    }
  }

  function changePassword(Request $request){
    $username = $request->input('username');
    $password = $request->input('password');
    $curr_password = $request->input('current_password');
    $new_password = $request->input('new_password');
    $confirm_password = $request->input('confirm_new_password');



    if($password == $curr_password && $new_password == $confirm_password){

      $newpassword_encrypted = Crypt::encryptString($new_password);
      $token_name = $username.'token';

      $user = DB::table('users')
      ->where('username',$username)
      ->get();

      $email = $user[0]->email;

      //Gitlab API Create User
      SSH::into('gitlab')->run(array(
        "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: jbVyzyHKVahx8WHz2d59' --data 'username=$username' --data 'password=$new_password' --data 'name=$username' --data 'email=$email' --data 'skip_confirmation=true' https://52.221.75.98/api/v4/users",
      ), function($line){
        $jsonArray = json_decode($line);
        $GLOBALS['gitlab_userid'] = $jsonArray->id;
        // print_r("User ID: ".$jsonArray->id);
      });

      $gitlab_userid = $GLOBALS['gitlab_userid'];

      SSH::into('gitlab')->run(array(
        "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: jbVyzyHKVahx8WHz2d59' --data 'name=$token_name' --data 'expires_at=2018-01-01' --data 'scopes[]=api' https://52.221.75.98/api/v4/users/$gitlab_userid/impersonation_tokens",
      ), function($line){
        $jsonArray = json_decode($line);
        $GLOBALS['gitab_token'] = $jsonArray->token;
        // print_r("Impersonal Token: ".$jsonArray->token);
      });

      $gitlab_token = $GLOBALS['gitab_token'];

      DB::table('users')
      ->where('username', $username)
      ->update(['password' => $newpassword_encrypted, 'set_password' => "yes", 'gitlab_userid' => $gitlab_userid, 'token' => $gitlab_token]);

      SSH::into('ansible')->run(array(
        "mkdir -p /etc/ansible/users/$gitlab_token",
        "mkdir -p /etc/ansible/users/$gitlab_token/nw-configs",
        "touch /etc/ansible/users/$gitlab_token/hosts",
        "touch /etc/ansible/users/$gitlab_token/nw-hosts"
      ));

      $request->session()->flash('status', 'change password success');
      $request->session()->flash('title', 'Change Password Successful!');
      $request->session()->flash('text', 'Your password has been changed');
      $request->session()->flash('icon', 'success');

      return redirect('login');

    }else{
      $request->session()->flash('status', 'change password fail');
      $request->session()->flash('title', 'Change Password Failed!');
      $request->session()->flash('text', 'Unable to change password, please try again.');
      $request->session()->flash('icon', 'error');

      return redirect('login');
    }
  }
}
