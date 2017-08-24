<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSH;
use Redirect;
use App\Config;
use DB;

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


  public function check(Request $request)
  {
    //
    $GLOBALS['jsonArray'] = "";
    $GLOBALS['test'] = 0;
    $serverid = $request->input('serverid');
    $GLOBALS['serverid'] = $serverid;
    $controlid = $request->input('controlid');
    $GLOBALS['controlid'] = $controlid;
    $pathname = $request->input('pathname');
    $GLOBALS['pathname'] = $pathname;
    $pathconf = $request->input('pathconf');
    $GLOBALS['pathconf'] = $pathconf;
    $host = DB::table('hosts')->where('id', $GLOBALS['serverid'])->first();
    $servername = $host->servername ;

    $control = DB::table('controls')->where('id', $GLOBALS['controlid'])->first();

    $hostusr = $control->username_ssh;

    $user_id = $control->user_id;
    $GLOBALS['user'] = DB::table('users')->where('id', $user_id)->first();

    //Separate
    $nameconf =substr($pathconf, strrpos($pathconf, '/') + 1);
    $namepath =substr( $pathconf, 0, strrpos( $pathconf, '/' ) + 1);

    if(strpos($nameconf,'.conf') !== false || strpos($nameconf,'.cfg') !== false ){

      SSH::into('ansible')->run(array(
        "ansible -m shell -a 'find $namepath -type f -name $nameconf' $servername"
      ), function($line){
        if (strpos($line, $GLOBALS['pathconf']) !== false) {
          $GLOBALS['test'] = 1 ;


          //Using Gitlab API

          $user_id = 29;
          $imp_token = "eWQofD635bPE5auXVNAE";
          $proj_name = str_random(20);

          SSH::into('gitlab')->run(array(

            "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: $imp_token' --data 'name=$proj_name' http://13.228.10.174/api/v4/projects",

          ), function($line){

            $GLOBALS['jsonArray'] = json_decode($line);
            //
            // print_r("Project ID: ".$jsonArray->id.", Project Name(keygen): ".$jsonArray->name.", Project Path(.git): ".$jsonArray->path);

          });



          $obj = new Config();
          $obj->configname = $GLOBALS['pathname'];
          $obj->configpath = $GLOBALS['pathconf'];
          $obj->repository = "http://".$GLOBALS['user']->username.":".$GLOBALS['user']->password."@13.228.10.174/".$GLOBALS['user']->username."/".$GLOBALS['jsonArray']->path.".git";
          $obj->keygen = $GLOBALS['jsonArray']->name;
          $obj->gitlab_projid = $GLOBALS['jsonArray']->id;
          $obj->control_id = $GLOBALS['controlid'];
          $obj->save();

        }
      });


      //Waiting...

      if($GLOBALS['test'] == 1){
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

        $username = $GLOBALS['user']->username;
        $useremail = $GLOBALS['user']->email;

        SSH::into('ansible')->run(array(
          // "ansible -m shell -a '$mkdirfirst' $servername",
          // "ansible -m shell -a '$cpfilefirst' $servername",
          // "ansible -m shell -a '$gitaddfirst' $servername",
          // "ansible -m shell -a '$gitcommitfirst' $servername",
          // "ansible -m shell -a '$gitpushfirst' $servername",
          //To Adding
          "ansible-playbook /etc/ansible/Nanoadform.yml -i /etc/ansible/hosts -e 'host=$servername'",
          "ansible $servername -m shell -a 'mkdir -p ~/nanoad/tmp_repo/$configkeygen'",
          "ansible $servername -m shell -a 'git init ~/nanoad/tmp_repo/$configkeygen'",
          "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/nanoad/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/nanoad/tmp_repo/$configkeygen/ config user.name \"$username\"'",
          "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/nanoad/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/nanoad/tmp_repo/$configkeygen/ config user.email \"$useremail\"'",
          "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/nanoad/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/nanoad/tmp_repo/$configkeygen/ remote add backupversion \"$configrepo\"'",
        ));

        $dollar = '$filepath' ;
        $dollar = preg_quote($dollar, '/');
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
          // $mkdir = 'mkdir -p ~/nanoad/tmp_repo/'.$config->keygen;

          $cpfile = 'cp '.$config->configpath.' ~/nanoad/tmp_repo/'.$config->keygen;
          //เด๋วลองทำต่อ
          // if($hostusr == "root"){
          // }

          $gitadd = 'git --git-dir=/home/'.$hostusr.'/nanoad/tmp_repo/'.$config->keygen.'/.git --work-tree=/home/'.$hostusr.'/nanoad/tmp_repo/'.$config->keygen.' add . &> /dev/null';
          $edited = $config->configname.' was edited by '.$hostusr.' at ';
          $datemsg = '%%Y-%%m-%%d';
          $timemsg = '%%H:%%M:%%S';
          $gitcommit = 'git --git-dir=/home/'.$hostusr.'/nanoad/tmp_repo/'.$config->keygen.'/.git --work-tree=/home/'.$hostusr.'/nanoad/tmp_repo/'.$config->keygen.' commit -m \"'.$edited.'\$(date +'.$datemsg.'\" \"'.$timemsg.')\" &> /dev/null';
          $gitpush = 'git --git-dir=/home/'.$hostusr.'/nanoad/tmp_repo/'.$config->keygen.'/.git --work-tree=/home/'.$hostusr.'/nanoad/tmp_repo/'.$config->keygen.' push -u backupversion master &> /dev/null';
          $done = 'echo \"Done! Your Configuration file was saved.\"';
          if($key!=$GLOBALS['configscount']){
            $inloop = $inloop.'if [[ '.$dollar.' == '.$cfp.' ]]\\nthen\\n\\tclear\\n\\techo '.$pleasewait.'\\n\\t'.$cpfile.'\\n\\t'.$gitadd.'\\n\\t'.$gitcommit.'\\n\\t'.$gitpush.'\\n\\tclear\\n\\t'.$done.'\\nel';
          }else{
            $inloop = $inloop.'if [[ '.$dollar.' == '.$cfp.' ]]\\nthen\\n\\tclear\\n\\techo '.$pleasewait.'\\n\\t'.$cpfile.'\\n\\t'.$gitadd.'\\n\\t'.$gitcommit.'\\n\\t'.$gitpush.'\\n\\tclear\\n\\t'.$done.'\\nfi';
          }

          //  $inloop = $inloop.'\\n\\nif [[ '.$dollar.' == '.$cfp.' ]]\\nthen\\n\\tclear\\n\\techo '.$pleasewait.'\\n\\t'.$mkdir.'\\n\\t'.$cpfile.'\\n\\t'.$gitadd.'\\n\\t'.$gitcommit.'\\n\\t'.$gitpush.'\\n\\tclear\\n\\t'.$done.'\\nfi';
        }
        SSH::into('ansible')->run(array(
          // "ansible $servername -m shell -a 'printf \"\\nHello\\nWorld\\n$config->configname\" >> /etc/nanoad/scripts/nanoad.sh' --become",
          "ansible $servername -m shell -a 'printf \"$inloop\" >> ~/nanoad/scripts/nanoad.sh'",
        ));
      }
    }

    return Redirect::back()->withErrors([$GLOBALS['test']]);
    // return Redirect::back();
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
