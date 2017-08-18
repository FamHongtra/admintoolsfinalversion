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
    $GLOBALS['test'] = 0;
    $serverid = $request->input('serverid');
    $GLOBALS['serverid'] = $serverid;
    $pathname = $request->input('pathname');
    $GLOBALS['pathname'] = $pathname;
    $pathconf = $request->input('pathconf');
    $GLOBALS['pathconf'] = $pathconf;
    $host = DB::table('hosts')->where('id', $GLOBALS['serverid'])->first();
    $servername = $host->servername ;
    $hostusr = $host->username;
    //Separate
    $nameconf =substr($pathconf, strrpos($pathconf, '/') + 1);
    $namepath =substr( $pathconf, 0, strrpos( $pathconf, '/' ) + 1);

    if(strpos($nameconf,'.conf') !== false || strpos($nameconf,'.cfg') !== false ){

      SSH::into('ansible')->run(array(
        "ansible -m shell -a 'find $namepath -type f -name $nameconf' $servername"
      ), function($line){
        if (strpos($line, $GLOBALS['pathconf']) !== false) {
          $GLOBALS['test'] = 1 ;
          $obj = new Config();
          $obj->configname = $GLOBALS['pathname'];
          $obj->configpath = $GLOBALS['pathconf'];
          $obj->host_id = $GLOBALS['serverid'];
          $obj->save();
        }
      });

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

        SSH::into('ansible')->run(array(
          // "ansible -m shell -a '$mkdirfirst' $servername",
          // "ansible -m shell -a '$cpfilefirst' $servername",
          // "ansible -m shell -a '$gitaddfirst' $servername",
          // "ansible -m shell -a '$gitcommitfirst' $servername",
          // "ansible -m shell -a '$gitpushfirst' $servername",
//To Adding
          "ansible-playbook /etc/ansible/Nanoadform.yml -i /etc/ansible/hosts -e 'host=$servername'",
        ));

        $dollar = '$filepath' ;
        $dollar = preg_quote($dollar, '/');
        $pleasewait = '\"Please wait...\"' ;


        $GLOBALS['configs'] = DB::table('configs')->where('host_id', $GLOBALS['serverid'])->get();
        $GLOBALS['configscount'] = DB::table('configs')->where('host_id', $GLOBALS['serverid'])->count();
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
          $mkdir = 'mkdir -p ~/nanoad/tmp_repo'.$path;
          $cpfile = 'cp '.$config->configpath.' ~/nanoad/tmp_repo'.$path;
          //เด๋วลองทำต่อ
          // if($hostusr == "root"){
          // }

          $gitadd = 'git --git-dir=/home/'.$hostusr.'/nanoad/tmp_repo/.git --work-tree=/home/'.$hostusr.'/nanoad/tmp_repo add . &> /dev/null';
          $edited = $config->configname.' was edited by '.$hostusr.' at ';
          $datemsg = '%%Y-%%m-%%d';
          $timemsg = '%%H:%%M:%%S';
          $gitcommit = 'git --git-dir=/home/'.$hostusr.'/nanoad/tmp_repo/.git --work-tree=/home/'.$hostusr.'/nanoad/tmp_repo commit -m \"'.$edited.'\$(date +'.$datemsg.'\" \"'.$timemsg.')\" &> /dev/null';
          $gitpush = 'git --git-dir=/home/'.$hostusr.'/nanoad/tmp_repo/.git --work-tree=/home/'.$hostusr.'/nanoad/tmp_repo push -u backupversion master &> /dev/null';
          $done = 'echo \"Done! Your Configuration file was saved.\"';
          if($key!=$GLOBALS['configscount']){
            $inloop = $inloop.'if [[ '.$dollar.' == '.$cfp.' ]]\\nthen\\n\\tclear\\n\\techo '.$pleasewait.'\\n\\t'.$mkdir.'\\n\\t'.$cpfile.'\\n\\t'.$gitadd.'\\n\\t'.$gitcommit.'\\n\\t'.$gitpush.'\\n\\tclear\\n\\t'.$done.'\\nel';
          }else{
            $inloop = $inloop.'if [[ '.$dollar.' == '.$cfp.' ]]\\nthen\\n\\tclear\\n\\techo '.$pleasewait.'\\n\\t'.$mkdir.'\\n\\t'.$cpfile.'\\n\\t'.$gitadd.'\\n\\t'.$gitcommit.'\\n\\t'.$gitpush.'\\n\\tclear\\n\\t'.$done.'\\nfi';
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
