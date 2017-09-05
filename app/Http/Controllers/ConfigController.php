<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSH;
use Redirect;
use App\Config;
use App\Host;
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
          "ansible-playbook /etc/ansible/Vimadform.yml -i /etc/ansible/hosts -e 'host=$servername'",
          "ansible $servername -m shell -a 'mkdir -p ~/vim/tmp_repo/$configkeygen'",
          "ansible $servername -m shell -a 'git init ~/vim/tmp_repo/$configkeygen'",
          "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ config user.name \"$username\"'",
          "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ config user.email \"$useremail\"'",
          "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ remote add backupversion \"$configrepo\"'",
          "ansible $servername -m shell -a 'cp $configpath ~/vim/tmp_repo/$configkeygen'",//Add this.
          "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ add . &> /dev/null'",//Add this.
          "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ commit -m \"$configname was initialized.\" &> /dev/null'", //Add this.
          "ansible $servername -m shell -a 'git --git-dir=/home/$hostusr/vim/tmp_repo/$configkeygen/.git --work-tree=/home/$hostusr/vim/tmp_repo/$configkeygen/ push -u backupversion master &> /dev/null'",//Add this.
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
          $gitcommit = 'git --git-dir=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.'/.git --work-tree=/home/'.$hostusr.'/vim/tmp_repo/'.$config->keygen.' commit -m \"'.$edited.'\$(date +'.$datemsg.'\" \"'.$timemsg.')\" &> /dev/null';
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
          "ansible $servername -m shell -a 'printf \"$inloop\" >> ~/vim/scripts/vimad.sh'",
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
    $control_id = DB::table('configs')->where('id', $id)->value('control_id');
    $host_id = DB::table('controls')->where('id', $control_id)->value('host_id');
    $proj_id = DB::table('configs')->where('id', $id)->value('gitlab_projid');

    $obj = Host::find($host_id);

    $user_id = 29;
    $imp_token = "eWQofD635bPE5auXVNAE";
    $GLOBALS['jsonArray'] = "";

    SSH::into('gitlab')->run(array(

      "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' http://13.228.10.174/api/v4/projects/$proj_id/repository/commits",

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

  public function deleteConfig(Request $request)
  {
    //
    $serverid = $request->input('serverid');
    $configid = $request->input('configid');

    DB::table('configs')->where('id', $configid)->delete();

    $serverobj = Host::find($serverid);
    $GLOBALS['test'] = 6 ;
    return Redirect::back()->with('obj',$serverobj)->withErrors($GLOBALS['test']);
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
