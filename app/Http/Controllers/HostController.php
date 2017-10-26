<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use SSH;
use App\Host;
use App\Control;
use Redirect;
use Hash;
use DB;

class HostController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //

  }


  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */

  public function loading(Request $request)
  {
    $bywhat = $request->input('bywhat'); // server or network-device
    $servername = $request->input('servername');
    $host = $request->input('host');
    $port = $request->input('port');
    $usrname = $request->input('usrname');
    $password = $request->input('password');
    $user_id = session('user_id');


    $duplicateservername  = DB::table('hosts')
    ->join('controls', 'hosts.id', '=', 'controls.host_id')
    ->where('controls.user_id', $user_id)
    ->where('hosts.servername', $servername)
    ->where('controls.control_type', $bywhat)
    ->get();

    $duplicatehost  = DB::table('hosts')
    ->join('controls', 'hosts.id', '=', 'controls.host_id')
    ->where('controls.user_id', $user_id)
    ->where('hosts.host', $host)
    ->where('controls.control_type', $bywhat)
    ->get();

    //servername and host not duplicate.
    if(count($duplicatehost)==0 && count($duplicateservername)==0){
      // echo "servername and host can be use.";

      $data['bywhat'] = $bywhat ;
      $data['servername'] = $servername ;
      $data['host'] = $host ;
      $data['port'] = $port ;
      $data['usrname'] = $usrname ;
      $data['password'] = $password ;
      $data['bywhat'] = $bywhat ;

      return view('loadingpage',$data);

    }else{

      if(count($duplicatehost)>0 && count($duplicateservername)>0){
        // echo "servername and host can't be use.";

        $request->session()->flash('status', 'servername and host duplicate');
        $request->session()->flash('title', 'Add Host Failed!');
        $request->session()->flash('text', 'Servername and Host aready exists, please use another.');
        $request->session()->flash('icon', 'error');

        return redirect('showhost');
      }else{
        if(count($duplicatehost)>0){
          // echo "only host can't be use.";
          $request->session()->flash('status', ' host duplicate');
          $request->session()->flash('title', 'Add Host Failed!');
          $request->session()->flash('text', 'Host aready exists, please use another.');
          $request->session()->flash('icon', 'error');

          return redirect('showhost');
        }else if(count($duplicateservername)>0){
          // echo "only servername can't be use.";

          $request->session()->flash('status', 'servername duplicate');
          $request->session()->flash('title', 'Add Host Failed!');
          $request->session()->flash('text', 'Servername aready exists, please use another.');
          $request->session()->flash('icon', 'error');

          return redirect('showhost');
        }
      }
    }
  }

  public function store(Request $request)
  {

    //  suppose user
    $user_id = session('user_id') ;
    $user_name = "admina" ;
    $user_pass = "adminaeiei" ;

    $bywhat = $request->input('bywhat');// server or network-device
    $servername = $request->input('servername');
    $host = $request->input('host');
    $port = $request->input('port');
    $usrname = $request->input('usrname');
    $password = $request->input('password');

    // $filepath = $request->input('filepath');
    $imp_token = DB::table('users')->where('id', $user_id)->value('token');

    $repository = "http://".$user_name."@13.228.10.174/".$user_name."/".$servername.".git" ;
    //remote to ansible for keeping RSA key
    if($bywhat == "server"){

      SSH::into('ansible')->run(array(
        "echo [$servername] | sudo tee --a /etc/ansible/users/$imp_token/hosts",
        "echo $host ansible_ssh_user=$usrname ansible_ssh_pass=$password ansible_sudo_pass=$password ansible_ssh_port=$port | sudo tee --a /etc/ansible/users/$imp_token/hosts",
        // "ansible -m shell -a 'mkdir /testpassnaja' $servername --become",
      ));

      //Testing
      $GLOBALS['ping'] = 0;

      SSH::into('ansible')->run(array(
        "ansible -i /etc/ansible/users/$imp_token/hosts -m ping $servername",
      ), function($line){
        if (strpos($line, 'SUCCESS') !== false) {
          $GLOBALS['ping'] = 1;
          // echo $GLOBALS['ping'];
        }
      });


      if($GLOBALS['ping'] == 1){
        // $usrfortest = "admina" ;
        // $emailfortest = "admina@example.com" ;
        // $repofortest = "http://admina:adminaeiei@13.228.10.174/admina/server001.git" ;


        SSH::into('ansible')->run(array(
          //install nanoad
          // "ansible-playbook /etc/ansible/Nanoinstall.yml -i /etc/ansible/hosts -e 'host=$servername' -e 'whoami=$usrname'",

          //install vimad
          "ansible-playbook /etc/ansible/Viminstall.yml -i /etc/ansible/users/$imp_token/hosts -e 'host=$servername' -e 'whoami=$usrname'",

          "ansible-playbook /etc/ansible/Gitinstall.yml -i /etc/ansible/users/$imp_token/hosts -e 'host=$servername'",
          // "ansible-playbook /etc/ansible/Gitinstall.yml -i /etc/ansible/hosts -e 'host=$servername' -e 'gitusr=$usrfortest' -e 'gitemail=$emailfortest' -e 'gitrepo=$repofortest' -e 'whoami=$usrname'",
        ));

      }
      //Testing

      $obj = new Host();
      $obj->servername = $servername;
      $obj->host = $host;
      $obj->port = $port;
      $obj->save();

      $host = DB::table('hosts')->orderBy('id', 'desc')->first();

      $obj2 = new Control();
      $obj2->username_ssh = $usrname;
      $password_encrypted = Crypt::encryptString($password);
      $obj2->password_ssh = $password_encrypted;
      $obj2->control_type = "server";
      $obj2->user_id = $user_id;
      $obj2->host_id = $host->id ;
      $obj2->group_id = 0 ;
      $obj2->save();

      return redirect('showhost');


      //remote to ansible for keeping Password
    }else if($bywhat == "network-device"){

      SSH::into('ansible')->run(array(
        "echo [$servername] | sudo tee --a /etc/ansible/users/$imp_token/nw-hosts",
        "echo $host ansible_ssh_user=$usrname ansible_ssh_pass=$password ansible_sudo_pass=$password ansible_ssh_port=$port | sudo tee --a /etc/ansible/users/$imp_token/nw-hosts",
        // "ansible -m shell -a 'mkdir /testpassnaja' $servername --become",
      ));

      //Testing

      $obj = new Host();
      $obj->servername = $servername;
      $obj->host = $host;
      $obj->port = $port;
      $obj->save();

      $host = DB::table('hosts')->orderBy('id', 'desc')->first();

      $obj2 = new Control();
      $obj2->username_ssh = $usrname;
      $password_encrypted = Crypt::encryptString($password);
      $obj2->password_ssh = $password_encrypted;
      $obj2->control_type = "network-device";
      $obj2->user_id = $user_id;
      $obj2->host_id = $host->id ;
      $obj2->group_id = 0 ;
      $obj2->save();

      return redirect('shownwdev');

    }
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    if(session('user_id')==null){
      return redirect('login');
    }else{
      $host_id = DB::table('controls')->where('id', $id)->value('host_id');

      $obj = Host::find($host_id);
      $data['obj'] = $obj;
      $data['controlid'] = $id;

      return view('detailhost',$data) ;
    }
  }

  public function checkConnection(Request $request, $id)
  {
    if(session('user_id')==null){
      return redirect('login');
    }else{

      $host_id = DB::table('controls')->where('id', $id)->value('host_id');

      $obj = Host::find($host_id);
      $servername = $obj->servername ;

      $GLOBALS['ping'] = 0;

      $user_id = session('user_id');
      $imp_token = DB::table('users')->where('id', $user_id)->value('token');

      SSH::into('ansible')->run(array(
        "ansible -i /etc/ansible/users/$imp_token/hosts -m ping $servername",
      ), function($line){
        if (strpos($line, 'SUCCESS') !== false) {
          $GLOBALS['ping'] = 1;
        }
      });

      if($GLOBALS['ping'] == 1){
        $request->session()->flash('status', 'connection');
        $request->session()->flash('title', 'Connected!');
        $request->session()->flash('text', 'The host is already connected.');
        $request->session()->flash('icon', 'success');
      }else{
        $request->session()->flash('status', 'connection');
        $request->session()->flash('title', 'Disconnected!');
        $request->session()->flash('text', 'The host is not connected.');
        $request->session()->flash('icon', 'error');
      }

      $data['obj'] = $obj;
      $data['controlid'] = $id;

      return Redirect::back();
    }
    // return view('detailhost',$data) ;
  }

  public function search(Request $request)
  {

    $searchby = $request->input('search_by');
    $searchkey = $request->input('searchkey');
    $user_id = $request->input('user_id');

    if($searchby == "autocomplete"){
      if($searchkey!=null){
        $objs = DB::table('hosts')
        ->join('controls', 'hosts.id', '=', 'controls.host_id')
        ->where('controls.user_id', $user_id)
        ->where('hosts.servername','like','%'.$searchkey.'%')
        ->orWhere('hosts.host','like', '%'.$searchkey.'%')
        ->get();

        $all_group = [];
        //
        // if($objs->count()==0){
        //   $request->session()->flash('status', 'not found');
        //   $request->session()->flash('title', 'Not Found!');
        //   $request->session()->flash('text', 'The host you are looking for does not exist.');
        //   $request->session()->flash('icon', 'warning');
        //
        //   $objs = DB::table('hosts')
        //   ->join('controls', 'hosts.id', '=', 'controls.host_id')
        //   ->where('controls.user_id', $user_id)
        //   ->where('controls.group_id', 0)
        //   ->get();
        //
        //   $all_group = DB::table('groups')
        //   ->where('user_id', $user_id)
        //   ->get();
        // }

      }else{
        $objs = DB::table('hosts')
        ->join('controls', 'hosts.id', '=', 'controls.host_id')
        ->where('controls.user_id', $user_id)
        ->where('controls.group_id', 0)
        ->get();

        $all_group = DB::table('groups')
        ->where('user_id', $user_id)
        ->get();

      }
    }else{
      if($searchkey!=null){
        $objs = [];

        $all_group = DB::table('groups')
        ->where('user_id', $user_id)
        ->where('groupname',$searchkey)
        ->get();

        // if($all_group->count()==0){
        //   $request->session()->flash('status', 'not found');
        //   $request->session()->flash('title', 'Not Found!');
        //   $request->session()->flash('text', 'The group you are looking for does not exist.');
        //   $request->session()->flash('icon', 'warning');
        //
        //   $objs = DB::table('hosts')
        //   ->join('controls', 'hosts.id', '=', 'controls.host_id')
        //   ->where('controls.user_id', $user_id)
        //   ->where('controls.group_id', 0)
        //   ->get();
        //
        //   $all_group = DB::table('groups')
        //   ->where('user_id', $user_id)
        //   ->get();
        // }

      }else{
        $objs = DB::table('hosts')
        ->join('controls', 'hosts.id', '=', 'controls.host_id')
        ->where('controls.user_id', $user_id)
        ->where('controls.group_id', 0)
        ->get();

        $all_group = DB::table('groups')
        ->where('user_id', $user_id)
        ->get();

      }
    }


    $data['objs'] = $objs;
    $data['all_group'] = $all_group;
    $data['user_id'] = $user_id;

    return view('showhost',$data);

  }

  public function sshLogin(Request $request)
  {
    //
    $user_id = $request->input("user_id");
    $host_id = $request->input("host_id");

    //username and password from input form
    $login_username = $request->input("login_username");
    $login_password = $request->input("login_password");

    $control = DB::table('controls')
    ->where('user_id',$user_id)
    ->where('host_id',$host_id)
    ->get();

    //username and password from database
    $control_username = $control[0]->username_ssh;
    $control_password = $control[0]->password_ssh;

    $password_decrypted =  Crypt::decryptString($control_password);

    if($login_username == $control_username){
      if($login_password ==  $password_decrypted){
        // echo "username and password are correct!";

        return redirect()->route('detailhost',$control[0]->id);
      }else{
        // echo "password wrong!";

        $request->session()->flash('status', 'ssh login fail');
        $request->session()->flash('title', 'Failed!');
        $request->session()->flash('text', 'Cannot connect to the host.');
        $request->session()->flash('icon', 'error');

        return redirect('showhost');
      }
    }else{
      // echo "username and password wrong!";

      $request->session()->flash('status', 'ssh login fail');
      $request->session()->flash('title', 'Failed!');
      $request->session()->flash('text', 'Cannot connect to the host.');
      $request->session()->flash('icon', 'error');

      return redirect('showhost');
    }


  }


  public function delHost(Request $request)
  {
    //
    $user_id = $request->input("user_id");
    $host_id = $request->input("host_id");

    //username and password from input form
    $login_username = $request->input("login_username");
    $login_password = $request->input("login_password");


    $control = DB::table('controls')
    ->where('user_id',$user_id)
    ->where('host_id',$host_id)
    ->get();

    //username and password from database
    $control_username = $control[0]->username_ssh;
    $control_password = $control[0]->password_ssh;

    $password_decrypted =  Crypt::decryptString($control_password);


    if($login_username == $control_username){
      if($login_password == $password_decrypted){
        // echo "username and password are correct!";

        $request->session()->flash('status', 'delete host success');
        $request->session()->flash('title', 'Successful!');
        $request->session()->flash('text', 'the host was deleted from the system.');
        $request->session()->flash('icon', 'success');

        DB::table('controls')->where('id', '=', $control[0]->id)->delete();
        DB::table('hosts')->where('id', '=', $host_id)->delete();

        return redirect('showhost');
      }else{
        // echo "password wrong!";

        $request->session()->flash('status', 'delete host fail');
        $request->session()->flash('title', 'Failed!');
        $request->session()->flash('text', 'Cannot delete the host from the system.');
        $request->session()->flash('icon', 'error');

        return redirect('showhost');
      }
    }else{
      // echo "username and password wrong!";

      $request->session()->flash('status', 'delete host fail');
      $request->session()->flash('title', 'Failed!');
      $request->session()->flash('text', 'Cannot delete the host from the system.');
      $request->session()->flash('icon', 'error');

      return redirect('showhost');
    }
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //
  }



  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }
}
