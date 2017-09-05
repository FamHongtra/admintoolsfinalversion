<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    $bywhat = $request->input('bywhat');
    $servername = $request->input('servername');
    $host = $request->input('host');
    $port = $request->input('port');
    $usrname = $request->input('usrname');

    if($bywhat == "rsakey"){

      $file = $request->file('password');
      $original_name = $file->getClientOriginalName();
      $file->move('../resources/keyfiles', $original_name);
      $data['original_name'] = $original_name;
    }else if($bywhat == "password"){

      $password = $request->input('password');
      $data['password'] = $password ;
    }




    $data['bywhat'] = $bywhat ;
    $data['servername'] = $servername ;
    $data['host'] = $host ;
    $data['port'] = $port ;
    $data['usrname'] = $usrname ;
    $data['bywhat'] = $bywhat ;

    return view('loadingpage',$data);
  }

  public function store(Request $request)
  {

    //  suppose user
    $user_id = 1 ;
    $user_name = "admina" ;
    $user_pass = "adminaeiei" ;

    $bywhat = $request->input('bywhat');
    $servername = $request->input('servername');
    $host = $request->input('host');
    $port = $request->input('port');
    $usrname = $request->input('usrname');
    $password = $request->input('password');

    // $filepath = $request->input('filepath');

    $repository = "http://".$user_name."@13.228.10.174/".$user_name."/".$servername.".git" ;
    //remote to ansible for keeping RSA key
    if($bywhat == "rsakey"){

      $original_name = $request->input('original_name');
      $local_path = '../resources/keyfiles/'.$original_name;
      $remote_dir =  "/etc/ansible/keyfiles/".$user_name."/".$servername;
      $remote_path = $remote_dir."/".$original_name;


      SSH::into('ansible')->run(array(
        "echo [$servername] | sudo tee --a /etc/ansible/hosts",
        "echo $host ansible_ssh_user=$usrname ansible_ssh_private_key_file=$remote_path ansible_ssh_port=$port | sudo tee --a /etc/ansible/hosts",
        "mkdir -p $remote_dir",
        // "sudo chmod -R 600 /etc/ansible/keyfiles",
        // "ansible -m shell -a 'mkdir /testpassnaja' $servername --become",
      ));
      SSH::into('ansible')->put($local_path, $remote_path);
      SSH::into('ansible')->run(array(
        "chmod 600 $remote_path",
        // "ansible -m ping $servername",
        // "ansible -m shell -a 'mkdir /testpassnaja' $servername --become",
      ));
      //Testing
      $GLOBALS['ping'] = 0;

      SSH::into('ansible')->run(array(
        "ansible -m ping $servername",
      ), function($line){
        if (strpos($line, 'SUCCESS') !== false) {
          $GLOBALS['ping'] = 1;
          echo $GLOBALS['ping'];
        }
      });


      if($GLOBALS['ping'] == 1){

        // $usrfortest = "admina" ;
        // $emailfortest = "admina@example.com" ;
        // $repofortest = "http://admina:adminaeiei@13.228.10.174/admina/server001.git" ;


        SSH::into('ansible')->run(array(
          "ansible-playbook /etc/ansible/Nanoinstall.yml -i /etc/ansible/hosts -e 'host=$servername' -e 'whoami=$usrname'",
          "ansible-playbook /etc/ansible/Gitinstall.yml -i /etc/ansible/hosts -e 'host=$servername'",
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
      $obj2->password_ssh = $password;
      $obj2->passtype_id = 1;
      $obj2->user_id = $user_id;
      $obj2->host_id = $host->id ;
      $obj2->save();

      return redirect('showhost');
      // return "Add host by RSA Key";

      //remote to ansible for keeping Password
    }else if($bywhat == "password"){

      SSH::into('ansible')->run(array(
        "echo [$servername] | sudo tee --a /etc/ansible/hosts",
        "echo $host ansible_ssh_user=$usrname ansible_ssh_pass=$password ansible_sudo_pass=$password ansible_ssh_port=$port | sudo tee --a /etc/ansible/hosts",
        // "ansible -m shell -a 'mkdir /testpassnaja' $servername --become",
      ));

      //Testing
      $GLOBALS['ping'] = 0;

      SSH::into('ansible')->run(array(
        "ansible -m ping $servername",
      ), function($line){
        if (strpos($line, 'SUCCESS') !== false) {
          $GLOBALS['ping'] = 1;
          echo $GLOBALS['ping'];
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
          "ansible-playbook /etc/ansible/Viminstall.yml -i /etc/ansible/hosts -e 'host=$servername' -e 'whoami=$usrname'",

          "ansible-playbook /etc/ansible/Gitinstall.yml -i /etc/ansible/hosts -e 'host=$servername'",
          // "ansible-playbook /etc/ansible/Gitinstall.yml -i /etc/ansible/hosts -e 'host=$servername' -e 'gitusr=$usrfortest' -e 'gitemail=$emailfortest' -e 'gitrepo=$repofortest' -e 'whoami=$usrname'",
        ));

      }
      //Testing

      //
      $obj = new Host();
      $obj->servername = $servername;
      $obj->host = $host;
      $obj->port = $port;
      $obj->save();

      $host = DB::table('hosts')->orderBy('id', 'desc')->first();

      $obj2 = new Control();
      $obj2->username_ssh = $usrname;
      $obj2->password_ssh = $password;
      $obj2->passtype_id = 2;
      $obj2->user_id = $user_id;
      $obj2->host_id = $host->id ;
      $obj2->save();

      return redirect('showhost');

      // return "Add host by password";
    }

    //  return "by ".$bywhat."servername: ".$servername." host: ".$host." port: ".$port." username: ".$usrname." password: ".$password." filepath: ".$filepath;
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $host_id = DB::table('controls')->where('id', $id)->value('host_id');

    $obj = Host::find($host_id);
    $data['obj'] = $obj;
    $data['controlid'] = $id;

    return view('detailhost',$data) ;
  }

  public function search(Request $request)
  {
    $searchkey = $request->input('searchkey');
    $user_id = $request->input('user_id');
    if($searchkey!=null){
      $objs = DB::table('hosts')
      ->join('controls', 'hosts.id', '=', 'controls.host_id')
      ->where('controls.user_id', $user_id)
      ->where('hosts.servername','like','%'.$searchkey.'%')
      ->orWhere('hosts.host','like', '%'.$searchkey.'%')
      ->get();
    }else{
      $objs = DB::table('hosts')
      ->join('controls', 'hosts.id', '=', 'controls.host_id')
      ->where('controls.user_id', $user_id)
      ->get();
    }

    $data['objs'] = $objs;
    $data['user_id'] = $user_id;

    return view('showhost',$data);
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
