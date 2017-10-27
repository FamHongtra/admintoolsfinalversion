<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use SSH;
use Redirect;
use App\Config;
use App\Host;
use DB;
use File;
use Alert;

class ConfigController extends Controller
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
  public function store(Request $request)
  {
    //
  }

  public function backupnwdev(Request $request){

    $control_id = $request->input('controlid');
    $msgcommit = $request->input('msgcommit');

    if ($msgcommit == "") {
      $msgcommit = 'Untitled.';
    }


    $user = DB::table('users')->where('id', session('user_id'))->first();
    $config = DB::table('configs')->where('control_id', $control_id)->first();

    $host_id = DB::table('controls')->where('id', $control_id)->value('host_id');
    $host = DB::table('hosts')->where('id', $host_id)->first();

    $imp_token = DB::table('users')->where('id', session('user_id'))->value('token');
    $mknwdir = $config->keygen;
    $GLOBALS['mknwdir'] = $mknwdir;
    $servername = $host->servername;


    //Cisco Command
    SSH::into('ansible')->run(array(
      "ansible -i /etc/ansible/users/$imp_token/nw-hosts $servername -m raw -a 'show startup-config'",
    ), function($line){

      $GLOBALS['line'] = $line ;

    });

    $lineoutput = $GLOBALS['line'];

    // echo $lineoutput;

    SSH::into('ansible')->run(array(
      "rm -f /etc/ansible/users/$imp_token/nw-configs/$mknwdir/config*",
      "echo '$lineoutput' > /etc/ansible/users/$imp_token/nw-configs/$mknwdir/config",
      "sed -i '1d' /etc/ansible/users/$imp_token/nw-configs/$mknwdir/config",
      "sed -i '1d' /etc/ansible/users/$imp_token/nw-configs/$mknwdir/config",
      "sed -ie '\$d' /etc/ansible/users/$imp_token/nw-configs/$mknwdir/config",
      "sed -ie '\$d' /etc/ansible/users/$imp_token/nw-configs/$mknwdir/config",
      "sed -ie '\$d' /etc/ansible/users/$imp_token/nw-configs/$mknwdir/config",
      "sed -ie '\$d' /etc/ansible/users/$imp_token/nw-configs/$mknwdir/config",
    ));


    SSH::into('ansible')->run(array(
      "git --git-dir=/etc/ansible/users/$imp_token/nw-configs/$mknwdir/.git --work-tree=/etc/ansible/users/$imp_token/nw-configs/$mknwdir/ add ./config &> /dev/null",//Add this.
      "git --git-dir=/etc/ansible/users/$imp_token/nw-configs/$mknwdir/.git --work-tree=/etc/ansible/users/$imp_token/nw-configs/$mknwdir/ commit -m \"$msgcommit\" &> /dev/null", //Add this.
      "git --git-dir=/etc/ansible/users/$imp_token/nw-configs/$mknwdir/.git --work-tree=/etc/ansible/users/$imp_token/nw-configs/$mknwdir/ push -u backupversion master",//Add this.
    ), function($line){

      $GLOBALS['change'] = $line ;

    });

    if(!empty($GLOBALS['change'])){
      $request->session()->flash('status', 'true');
      $request->session()->flash('title', 'Successful!');
      $request->session()->flash('text', 'Backup the configuration file to the system successful.');
      $request->session()->flash('icon', 'success');

      return Redirect::back();

    }else{
      $request->session()->flash('status', 'true');
      $request->session()->flash('title', 'Failed!');
      $request->session()->flash('text', 'The configuration file everything up to date, It is latest version.');
      $request->session()->flash('icon', 'error');

      return Redirect::back();

    }
  }


  public function check(Request $request)
  {
    //
    $GLOBALS['jsonArray'] = "";
    $GLOBALS['test'] = 0;
    $GLOBALS['test2'] = 0;

    $request->session()->flash('status', 'true');
    $request->session()->flash('title', 'Failed!');
    $request->session()->flash('text', 'The configuration file not found.');
    $request->session()->flash('icon', 'error');
    //
    // $serverid = $request->input('serverid');
    // $GLOBALS['serverid'] = $control->serverid;
    $controlid = $request->input('controlid');
    $GLOBALS['controlid'] = $controlid;
    $pathname = $request->input('pathname');
    $GLOBALS['pathname'] = $pathname;
    $pathconf = $request->input('pathconf');
    $GLOBALS['pathconf'] = $pathconf;


    $control = DB::table('controls')->where('id', $GLOBALS['controlid'])->first();

    $GLOBALS['serverid'] = $control->host_id;

    $host = DB::table('hosts')->where('id', $GLOBALS['serverid'])->first();
    $servername = $host->servername ;


    $hostusr = $control->username_ssh;

    $user_id = $control->user_id;
    $GLOBALS['user'] = DB::table('users')->where('id', $user_id)->first();

    //Separate
    $nameconf =substr($pathconf, strrpos($pathconf, '/') + 1);
    $namepath =substr( $pathconf, 0, strrpos( $pathconf, '/' ) + 1);

    // echo $pathconf;

    $user_id = session('user_id');
    $imp_token = DB::table('users')->where('id', $user_id)->value('token');

    if(strpos($nameconf,'.conf') !== false || strpos($nameconf,'.cfg') !== false ){

      SSH::into('ansible')->run(array(
        // "ansible -m shell -a 'find $pathname -type f -name $nameconf' $servername"
        "ansible -i /etc/ansible/users/$imp_token/hosts -m shell -a 'find $pathconf' $servername"
      ), function($line){
        // echo $line;
        //If file found
        // if (strpos($line, $GLOBALS['pathconf']) !== false) {
        if (strpos($line, 'SUCCESS') !== false) {

          $GLOBALS['test'] = 1 ;
          // echo "file found";
          //Using Gitlab API

        }
      });

      if($GLOBALS['test'] == 1){

        SSH::into('ansible')->run(array(
          //find file
          // "ansible -m shell -a 'find /home/testuser/zcretfile.conf -type f -name zcretfile.conf' ubuntu-server",
          //Try to append text to the last line of file for checking file's permission
          "ansible -i /etc/ansible/users/$imp_token/hosts -m shell -a 'echo \"#checking permission\" >> $pathconf' $servername",
          // 'ansible -m shell -a "echo "#checking permission" >> $GLOBALS[pathconf]\' $servername',
          // 'ansible -m shell -a \'echo "#checking permission" >> /home/testuser/zcretfile.conf\' ubuntu-server',
        ), function($line){

          if (strpos($line, 'SUCCESS') !== false){
            //Have permission
            // echo $line;

            $GLOBALS['test2'] = 1;
            // $user_id = 29;
            // $imp_token = "1xfYQD8Km8LsfWaYVP_d";
            $user_id = session('user_id');
            $imp_token = DB::table('users')->where('id', $user_id)->value('token');


            $proj_name = str_random(20);

            SSH::into('gitlab')->run(array(

              "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: $imp_token' --data 'name=$proj_name' http://52.221.75.98/api/v4/projects",

            ), function($line){

              $GLOBALS['jsonArray'] = json_decode($line);
              //
              // print_r("Project ID: ".$jsonArray->id.", Project Name(keygen): ".$jsonArray->name.", Project Path(.git): ".$jsonArray->path);

            });

            $obj = new Config();
            $password_decrypted = Crypt::decryptString($GLOBALS['user']->password);
            $obj->configname = $GLOBALS['pathname'];
            $obj->configpath = $GLOBALS['pathconf'];
            $obj->repository = "http://".$GLOBALS['user']->username.":".$password_decrypted."@52.221.75.98/".$GLOBALS['user']->username."/".$GLOBALS['jsonArray']->path.".git";
            $obj->keygen = $GLOBALS['jsonArray']->name;
            $obj->gitlab_projid = $GLOBALS['jsonArray']->id;
            $obj->control_id = $GLOBALS['controlid'];
            $obj->save();


          }else{
            //Permission denied
            // echo "Permission denied.";
          }
        });
      }else{

        return Redirect::back();
        // echo "file not found.";
      }
      //Waiting...

      if($GLOBALS['test2'] == 1){

        SSH::into('ansible')->run(array(
          //Remove text last line.
          "ansible -i /etc/ansible/users/$imp_token/hosts -m shell -a 'sed -i \"$ d\" $pathconf' $servername",
        ), function($line2){
          // echo $line2;
        });

        //Adding
        // $curpath = substr( $pathconf, 0, strrpos( $pathconf, '/' ) + 1);// for make dir firsttime
        // $mkdirfirst = 'mkdir -p ~/nanoad/tmp_repo'.$curpath;
        // $cpfilefirst = 'cp '.$pathconf.' ~/nanoad/tmp_repo'.$curpath;
        // $gitaddfirst = 'git --git-dir=/home/'.$hostusr.'/nanoad/tmp_repo/.git --work-tree=/home/'.$hostusr.'/nanoad/tmp_repo add . &> /dev/null';
        // $editedf = $pathname.' was initialized at ';
        // $datemsgf = '%%Y-%%m-%%d';
        // $timemsgf = '%%H:%%M:%%S';
        // $gitcommitfirst = 'git --git-dir=/home/'.$hostusr.'/nanoad/tmp_repo/.git --work-tree=/home/'.$hostusr.'/nanoad/tmp_repo commit -m \"'.$editedf.'\".date+'.$datemsgf.'\" \"'.$timemsgf.')\" &> /dev/null';
        // $gitpushfirst = 'git --git-dir=/home/'.$hostusr.'/nanoad/tmp_repo/.git --work-tree=/home/'.$hostusr.'/nanoad/tmp_repo push -u backupversion master &> /dev/null';

        $configlatest = DB::table('configs')->orderBy('id','desc')->first();
        $configkeygen = $configlatest->keygen ;
        $configrepo = $configlatest->repository ;
        $configpath = $configlatest->configpath ; //Add this.
        $configname = $configlatest->configname ; //Add this.

        $username = $GLOBALS['user']->username;
        $useremail = $GLOBALS['user']->email;

        //for nanoad editor
        // SSH::into('ansible')->run(array(
        //   //To Adding
        //   "ansible-playbook /etc/ansible/Nanoadform.yml -i /etc/ansible/hosts -e 'host=$servername'",
        //   "ansible $servername -m shell -a 'mkdir -p ~/nanoad/tmp_repo/$configkeygen'",
        //   "ansible $servername -m shell -a 'git init ~/nanoad/tmp_repo/$configkeygen'",
        //   "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/nanoad/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/nanoad/tmp_repo/$configkeygen/ config user.name \"$username\"'",
        //   "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/nanoad/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/nanoad/tmp_repo/$configkeygen/ config user.email \"$useremail\"'",
        //   "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/nanoad/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/nanoad/tmp_repo/$configkeygen/ remote add backupversion \"$configrepo\"'",
        //   "ansible $servername -m shell -a 'cp $configpath ~/nanoad/tmp_repo/$configkeygen'",//Add this.
        //   "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/nanoad/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/nanoad/tmp_repo/$configkeygen/ add . &> /dev/null'",//Add this.
        //   "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/nanoad/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/nanoad/tmp_repo/$configkeygen/ commit -m \"$configname was initialized.\" &> /dev/null'", //Add this.
        //   "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/nanoad/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/nanoad/tmp_repo/$configkeygen/ push -u backupversion master &> /dev/null'",//Add this.
        // ));

        //for vimad editor
        SSH::into('ansible')->run(array(
          //To Adding
          "ansible-playbook /etc/ansible/Vimadform.yml -i /etc/ansible/users/$imp_token/hosts -e 'host=$servername'",
          "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'mkdir -p ~/vim/tmp_repo/$configkeygen'",
          "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git init ~/vim/tmp_repo/$configkeygen'",
          "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ config user.name \"$username\"'",
          "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ config user.email \"$useremail\"'",
          "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ remote add backupversion \"$configrepo\"'",
          "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'cp $configpath ~/vim/tmp_repo/$configkeygen'",//Add this.
          "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ add . &> /dev/null'",//Add this.
          "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ commit -m \"$configname was initialized.\" &> /dev/null'", //Add this.
          "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ push -u backupversion master &> /dev/null'",//Add this.
        ));

        $dollar = '$filepath' ;
        $dollar = preg_quote($dollar, '/');

        $choice = '$choice' ;
        $choice = preg_quote($choice, '/');

        $yourmsg = '$msg';
        $yourmsg = preg_quote($yourmsg, '/');

        $pleasewait = '\"Please wait...\"' ;


        $GLOBALS['configs'] = DB::table('configs')->where('control_id', $GLOBALS['controlid'])->get();
        $GLOBALS['configscount'] = DB::table('configs')->where('control_id', $GLOBALS['controlid'])->count();
        // foreach ($GLOBALS['configs'] as $key => $config) {
        //   $cfp = '\"'.$config->configpath.'\"';
        //   SSH::into('ansible')->run(array(
        //     // "ansible $servername -m shell -a 'printf \"\\nHello\\nWorld\\n$config->configname\" >> /etc/nanoad/scripts/nanoad.sh' --become",
        //     "ansible $servername -m shell -a 'printf \"\\n\\nif[[ $dollar == $cfp ]]\\nthen\\n\tclear\\n\techo $pleasewait\" >> /etc/nanoad/scripts/nanoad.sh' --become",
        //   ));
        // }
        $inloop = "";

        foreach ($GLOBALS['configs'] as $key => $config) {
          $key = $key+1;
          $cfp = '\"'.$config->configpath.'\"';
          $conf =substr($config->configpath, strrpos($config->configpath, '/') + 1);
          $path =substr( $config->configpath, 0, strrpos( $config->configpath, '/' ) + 1);

          $cpfile = 'cp '.$config->configpath.' ~/vim/tmp_repo/'.$config->keygen;

          $gitadd = 'git --git-dir=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.'/.git --work-tree=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.' add . &> /dev/null';
          $edited = $config->configname.' was edited by '.$hostusr.' at ';
          $datemsg = '%%Y-%%m-%%d';
          $timemsg = '%%H:%%M:%%S';

          $first_prompt = 'read -p \"Do you want to enter commit message for your change? (y/n): \" choice';
          $second_prompt = 'read -p \"Enter the commit message: \" msg';

          $gitcommitmsg = 'git --git-dir=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.'/.git --work-tree=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.' commit -m '.$yourmsg.' &> /dev/null';
          // $gitcommit = 'git --git-dir=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.'/.git --work-tree=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.' commit -m \"'.$edited.'\$(date +'.$datemsg.'\" \"'.$timemsg.')\" &> /dev/null';
          $gitcommit = 'git --git-dir=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.'/.git --work-tree=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.' commit -m \"Untitled.\" &> /dev/null';
          $gitpush = 'git --git-dir=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.'/.git --work-tree=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.' push -u backupversion master &> /dev/null';
          $done = 'echo \"Done! Your Configuration file was saved.\"';
          if($key!=$GLOBALS['configscount']){
            $inloop = $inloop.'if [[ '.$dollar.' == '.$cfp.' ]]\\nthen\\n\\t'.$cpfile.'\\n\\t'.$gitadd.'\\n\\t'.$first_prompt.'\\n\\t'.'if [[ '.$choice.' == \"y\" || '.$choice.' == \"n\" ]];\\n\\tthen\\n\\t\\tif [[ '.$choice.' == \"y\" ]];\\n\\t\\tthen\\n\\t\\t\\t'.$second_prompt.'\\n\\t\\t\\twhile [[ -z '.$yourmsg.' ]];\\n\\t\\t\\tdo\\n\\t\\t\\t\\t'.$second_prompt.'\\n\\t\\t\\tdone\\n\\t\\t\\t'.$gitcommitmsg.'\\n\\t\\t\\techo '.$pleasewait.'\\n\\t\\t\\t'.$gitpush.'\\n\\t\\telse\\n\\t\\t\\t'.$gitcommit.'\\n\\t\\t\\techo '.$pleasewait.'\\n\\t\\t\\t'.$gitpush.'\\n\\t\\tfi\\n\\telse\\n\\t\\twhile [[ '.$choice.' != \"y\" || '.$choice.' != \"n\" ]];\\n\\t\\tdo\\n\\t\\t\\t'.$first_prompt.'\\n\\t\\t\\tif [[ '.$choice.' == \"y\" || '.$choice.' == \"n\" ]];\\n\\t\\t\\tthen\\n\\t\\t\\t\\tif [[ '.$choice.' == \"y\" ]];\\n\\t\\t\\t\\tthen\\n\\t\\t\\t\\t\\t'.$second_prompt.'\\n\\t\\t\\t\\t\\twhile [[ -z '.$yourmsg.' ]];\\n\\t\\t\\t\\t\\tdo\\n\\t\\t\\t\\t\\t\\t'.$second_prompt.'\\n\\t\\t\\t\\t\\tdone\\n\\t\\t\\t\\t\\t'.$gitcommitmsg.'\\n\\t\\t\\t\\t\\techo '.$pleasewait.'\\n\\t\\t\\t\\t\\t'.$gitpush.'\\n\\t\\t\\t\\telse\\n\\t\\t\\t\\t\\t'.$gitcommit.'\\n\\t\\t\\t\\t\\techo '.$pleasewait.'\\n\\t\\t\\t\\t\\t'.$gitpush.'\\n\\t\\t\\t\\tfi\\n\\t\\t\\t\\tbreak\\n\\t\\t\\tfi\\n\\t\\tdone\\n\\tfi\\n\\t'.$done.'\\nel';
          }else{
            $inloop = $inloop.'if [[ '.$dollar.' == '.$cfp.' ]]\\nthen\\n\\t'.$cpfile.'\\n\\t'.$gitadd.'\\n\\t'.$first_prompt.'\\n\\t'.'if [[ '.$choice.' == \"y\" || '.$choice.' == \"n\" ]];\\n\\tthen\\n\\t\\tif [[ '.$choice.' == \"y\" ]];\\n\\t\\tthen\\n\\t\\t\\t'.$second_prompt.'\\n\\t\\t\\twhile [[ -z '.$yourmsg.' ]];\\n\\t\\t\\tdo\\n\\t\\t\\t\\t'.$second_prompt.'\\n\\t\\t\\tdone\\n\\t\\t\\t'.$gitcommitmsg.'\\n\\t\\t\\techo '.$pleasewait.'\\n\\t\\t\\t'.$gitpush.'\\n\\t\\telse\\n\\t\\t\\t'.$gitcommit.'\\n\\t\\t\\techo '.$pleasewait.'\\n\\t\\t\\t'.$gitpush.'\\n\\t\\tfi\\n\\telse\\n\\t\\twhile [[ '.$choice.' != \"y\" || '.$choice.' != \"n\" ]];\\n\\t\\tdo\\n\\t\\t\\t'.$first_prompt.'\\n\\t\\t\\tif [[ '.$choice.' == \"y\" || '.$choice.' == \"n\" ]];\\n\\t\\t\\tthen\\n\\t\\t\\t\\tif [[ '.$choice.' == \"y\" ]];\\n\\t\\t\\t\\tthen\\n\\t\\t\\t\\t\\t'.$second_prompt.'\\n\\t\\t\\t\\t\\twhile [[ -z '.$yourmsg.' ]];\\n\\t\\t\\t\\t\\tdo\\n\\t\\t\\t\\t\\t\\t'.$second_prompt.'\\n\\t\\t\\t\\t\\tdone\\n\\t\\t\\t\\t\\t'.$gitcommitmsg.'\\n\\t\\t\\t\\t\\techo '.$pleasewait.'\\n\\t\\t\\t\\t\\t'.$gitpush.'\\n\\t\\t\\t\\telse\\n\\t\\t\\t\\t\\t'.$gitcommit.'\\n\\t\\t\\t\\t\\techo '.$pleasewait.'\\n\\t\\t\\t\\t\\t'.$gitpush.'\\n\\t\\t\\t\\tfi\\n\\t\\t\\t\\tbreak\\n\\t\\t\\tfi\\n\\t\\tdone\\n\\tfi\\n\\t'.$done.'\\nfi';
          }
        }
        SSH::into('ansible')->run(array(
          // "ansible $servername -m shell -a 'printf \"\\nHello\\nWorld\\n$config->configname\" >> /etc/nanoad/scripts/nanoad.sh' --become",


          //append checkpath to nanoad.sh
          // "ansible $servername -m shell -a 'printf \"$inloop\" >> ~/nanoad/scripts/nanoad.sh'",
          "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'printf \"$inloop\" >> ~/vim/scripts/vimad.sh'",
        ));

        $request->session()->flash('status', 'true');
        $request->session()->flash('title', 'Successful!');
        $request->session()->flash('text', 'The configuration file was saved to the system.');
        $request->session()->flash('icon', 'success');


        return Redirect::back();

      }else{
        $request->session()->flash('status', 'true');
        $request->session()->flash('title', 'Failed!');
        $request->session()->flash('text', 'You don\'t have permission to access this file.');
        $request->session()->flash('icon', 'error');


        return Redirect::back();

      }
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
    //
    if(session('user_id')==null){
      return redirect('login');
    }else{

      $control_id = DB::table('configs')->where('id', $id)->value('control_id');
      $host_id = DB::table('controls')->where('id', $control_id)->value('host_id');
      $proj_id = DB::table('configs')->where('id', $id)->value('gitlab_projid');

      $obj = Host::find($host_id);

      $user_id = session('user_id');
      $imp_token = DB::table('users')->where('id', $user_id)->value('token');


      $GLOBALS['jsonArray'] = "";

      SSH::into('gitlab')->run(array(

        "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' http://52.221.75.98/api/v4/projects/$proj_id/repository/commits",

      ), function($line){
        // echo $line;

        $GLOBALS['jsonArray'] = json_decode($line);
        $collection = collect($GLOBALS['jsonArray']);
        $sorted = $collection->sortBy('committed_date');

        //
        // return dd($sorted);

        // foreach ($jsonArray as $item) {
        //   # code...
        //   print_r("Revision short ID: ".$item->short_id.", Commits Title: ".$item->title); echo '<br/>';
        //
        // }
      });

      $data['obj'] = $obj;

      $data['controlid'] = $control_id;
      $data['configid'] = $id ;
      // $collection = collect($GLOBALS['jsonArray']);
      // $sorted = $collection->sortBy('committed_date');
      // $data['configversions'] = $sorted;
      $data['configversions'] = $GLOBALS['jsonArray'];
      $GLOBALS['test'] = 5;

      return view('detailrepo',$data)->withErrors($GLOBALS['test']) ;
    }

  }

  public function deleteConfig(Request $request)
  {
    //
    $serverid = $request->input('serverid');
    $configid = $request->input('configid');

    DB::table('configs')->where('id', $configid)->delete();

    $serverobj = Host::find($serverid);
    $GLOBALS['test'] = 6 ;

    $request->session()->flash('status', 'true');
    $request->session()->flash('title', 'Successful!');
    $request->session()->flash('text', 'The config was deleted.');
    $request->session()->flash('icon', 'success');

    return Redirect::back()->with('obj',$serverobj)->withErrors($GLOBALS['test']);
  }

  public function revisionconfig(Request $request)
  {
    //
    $configid = $request->input('configid');

    $control_id = DB::table('configs')->where('id', $configid)->value('control_id');

    $hostusr = DB::table('controls')->where('id', $control_id)->value('username_ssh');

    $configrepo = $request->input('configrepo');
    $configkeygen = $request->input('configkeygen');
    $revisionid = $request->input('revisionid');
    $serverid = $request->input('serverid');
    $servername = $request->input('servername');
    $configfullpath = $request->input('configpath');
    $configpath =substr( $configfullpath, 0, strrpos( $configfullpath, '/' ) + 1);
    $configname =substr($configfullpath, strrpos($configfullpath, '/') + 1);

    $services = array("nginx", "httpd", "mysql");
    $serviceconfig = "";
    $GLOBALS['servicerestart'] = "success";

    foreach ( $services as $service ){
      if ( strpos( $configfullpath, $service ) !== FALSE ){
        $serviceconfig = $service;
      }
    }

    $user_id = session('user_id');
    $imp_token = DB::table('users')->where('id', $user_id)->value('token');



    if ($serviceconfig == "") {

      SSH::into('ansible')->run(array(
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git clone $configrepo /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen reset --hard $revisionid'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'cp /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/$configname /home/$hostusr/vim/tmp_repo/$configkeygen/'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'cat /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/$configname > $configfullpath'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'rm -rf /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/'",

        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ add . &> /dev/null'",//Add this.
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ commit -m \"$configname was revisioned to version id $revisionid.\" &> /dev/null'", //Add this.
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ push -u backupversion master &> /dev/null'",//Add this.

      ), function($line){
        // echo $line;
      });

    }else{

      SSH::into('ansible')->run(array(
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git clone $configrepo /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen reset --hard $revisionid'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'cp /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/$configname /home/$hostusr/vim/tmp_repo/$configkeygen/'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'cat /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/$configname > $configfullpath'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'rm -rf /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/'",

        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ add . &> /dev/null'",//Add this.
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ commit -m \"$configname was revisioned to version id $revisionid.\" &> /dev/null'", //Add this.
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ push -u backupversion master &> /dev/null'",//Add this.
      ), function($line){
        // echo $line;
      });

      SSH::into('ansible')->run(array(
        "ansible-playbook /etc/ansible/Reservice.yml -i /etc/ansible/users/$imp_token/hosts -e 'host=$servername' -e 'servicename=$serviceconfig'",
      ), function($line){
        if (strpos($line, 'msg') !== false) {
          $GLOBALS['servicerestart'] = "failure";
          $cutfront = substr($line,strpos($line, 'msg')+7);
          $newcut = substr($cutfront,0,strpos($cutfront, '}')-1);
          $GLOBALS['failuremsg'] = $newcut;
        }
      });

    }

    if( $GLOBALS['servicerestart'] == "success"){

      $request->session()->flash('status', 'success');
      $request->session()->flash('title', 'Successful!');
      $request->session()->flash('text', 'Revision Configuration successful.');
      $request->session()->flash('icon', 'success');

    }else{

      $request->session()->flash('status', 'failure');
      $request->session()->flash('title', 'Failed!');
      $request->session()->flash('text', 'Revision Configuration failed.');
      $request->session()->flash('icon', 'error');
      $request->session()->flash('failuremsg', $GLOBALS['failuremsg']);
    }

    //
    return redirect()->action('ConfigController@show', ['id' => $configid]);

  }

  public function editconfig($id)
  {
    //

    if(session('user_id')==null){
      return redirect('login');
    }else{

      $control_id = DB::table('configs')->where('id', $id)->value('control_id');
      $host_id = DB::table('controls')->where('id', $control_id)->value('host_id');
      $proj_id = DB::table('configs')->where('id', $id)->value('gitlab_projid');

      $obj = Host::find($host_id);

      $data['obj'] = $obj;

      $data['controlid'] = $control_id;
      $data['configid'] = $id ;

      $GLOBALS['test'] = 5;

      return view('editconfig',$data)->withErrors($GLOBALS['test']) ;
    }
    //
    // $data = $request->input('data');
    //
    // File::put('configs/test.conf', $data);
    // echo nl2br($data);
  }

  public function savecommit(Request $request)
  {
    $user_id = session('user_id');
    $imp_token = DB::table('users')->where('id', $user_id)->value('token');
    // $imp_token = "1xfYQD8Km8LsfWaYVP_d";

    $edittext = $request->input('edittext');


    //  curl --request PUT --header 'PRIVATE-TOKEN: 9zxm6Uvgy4m_xbP-qvH7' 'http://52.221.75.98//api/v4/projects/6/repository/files/default%2Econf?branch=master&content=some%20other%20content&commit_message=update%20file'
    $edittext = urlencode($edittext);

    $commitmsg = $request->input('commitmsg');

    if ($commitmsg == "") {
      $commitmsg = 'Untitled.';
    }

    $commitmsg = urlencode($commitmsg);

    $configid = $request->input('configid');

    $configpath = DB::table('configs')->where('id', $configid)->value('configpath');

    $configname = substr($configpath, strrpos($configpath, '/') + 1);

    $configname = urlencode($configname);

    $configpath = strtolower($configpath);

    $services = array("nginx", "httpd", "mysql");

    $serviceconfig = "";
    $GLOBALS['servicerestart'] = "success";

    foreach ( $services as $service ){
      if ( strpos( $configpath, $service ) !== FALSE ){
        $serviceconfig = $service;
      }
    }


    $configkeygen = DB::table('configs')->where('id', $configid)->value('keygen');
    $configrepo = DB::table('configs')->where('id', $configid)->value('repository');
    $proj_id = DB::table('configs')->where('id', $configid)->value('gitlab_projid');
    $control_id = DB::table('configs')->where('id', $configid)->value('control_id');
    $hostusr = DB::table('controls')->where('id', $control_id)->value('username_ssh');
    $host_id =  DB::table('controls')->where('id', $control_id)->value('host_id');
    $servername = DB::table('hosts')->where('id', $host_id)->value('servername');
    SSH::into('gitlab')->run(array(
      "curl --request PUT --header 'PRIVATE-TOKEN: $imp_token' 'http://52.221.75.98//api/v4/projects/$proj_id/repository/files/$configname?branch=master&content=$edittext&commit_message=$commitmsg'",
    ), function($line){
      // echo $line;
    });

    if ($serviceconfig == "") {

      SSH::into('ansible')->run(array(
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ pull backupversion master &> /dev/null'",//Add this.
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git clone $configrepo /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen'",
        // "ansible $servername -m shell -a 'cp /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/$configname /home/$hostusr/vim/tmp_repo/$configkeygen/'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'cat /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/$configname > $configpath'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'rm -rf /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ pull &> /dev/null'",
      ), function($line){

      });

    }else{

      SSH::into('ansible')->run(array(
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ pull backupversion master &> /dev/null'",//Add this.
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'git clone $configrepo /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen'",
        // "ansible $servername -m shell -a 'cp /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/$configname /home/$hostusr/vim/tmp_repo/$configkeygen/'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'cat /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/$configname > $configpath'",
        "ansible -i /etc/ansible/users/$imp_token/hosts $servername -m shell -a 'rm -rf /home/$hostusr/vim/tmp_repo/$configkeygen/$configkeygen/'",
        // "ansible-playbook /etc/ansible/Reservice.yml -i /etc/ansible/hosts -e 'host=$servername' -e 'servicename=$serviceconfig'",
      ), function($line){
      });

      SSH::into('ansible')->run(array(
        "ansible-playbook /etc/ansible/Reservice.yml -i /etc/ansible/users/$imp_token/hosts -e 'host=$servername' -e 'servicename=$serviceconfig'",
      ), function($line){
        if (strpos($line, 'msg') !== false) {
          $GLOBALS['servicerestart'] = "failure";
          $cutfront = substr($line,strpos($line, 'msg')+7);
          $newcut = substr($cutfront,0,strpos($cutfront, '}')-1);
          $GLOBALS['failuremsg'] = $newcut;
        }
      });
    }

    if( $GLOBALS['servicerestart'] == "success"){

      $request->session()->flash('status', 'success');
      $request->session()->flash('title', 'Successful!');
      $request->session()->flash('text', 'Edit Configuration successful.');
      $request->session()->flash('icon', 'success');

    }else{

      $request->session()->flash('status', 'failure');
      $request->session()->flash('title', 'Failed!');
      $request->session()->flash('text', 'Edit Configuration failed.');
      $request->session()->flash('icon', 'error');
      $request->session()->flash('failuremsg', $GLOBALS['failuremsg']);
    }

    return redirect()->action('ConfigController@show', ['id' => $configid]);

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
