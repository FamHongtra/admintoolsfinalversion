<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {

  return view('welcome');
});

Route::get('/createtmpuser', function () {

  //Create User for Test
  $name = "AdminFam";
  $email = "adminfam@example.com";
  $username = "adminfam";
  $password = "adminfameiei";
  $token = "44Tz1jUhEsmeVudseix_";
  $gitlab_userid = 29;

  $obj = new App\User();
  $obj->name = $name;
  $obj->email = $email;
  $obj->username = $username;
  $obj->password = $password;
  $obj->token = $token;
  $obj->gitlab_userid = $gitlab_userid;
  $obj->save();

  //
  // return view('welcome');
});

Route::get('/createtmphost', function () {

  //Create Host for Test
  $obj = new App\Host();
  $obj->servername = "Server01";
  $obj->host = "192.168.1.2";
  $obj->port = 22;
  $obj->save();

  $host = DB::table('hosts')->orderBy('id', 'desc')->first();

  $obj2 = new App\Control();
  $obj2->username_ssh = "root";
  $obj2->password_ssh = "password";
  $obj2->passtype_id = 1;
  $obj2->user_id = 1;
  $obj2->host_id = $host->id ;
  $obj2->save();

  //
  // return view('welcome');
});

Route::get('/showhost', function () {

  $user_id = 1 ;

  $objs = DB::table('hosts')
  ->join('controls', 'hosts.id', '=', 'controls.host_id')
  ->where('controls.user_id', $user_id)
  ->get();

  $data['objs'] = $objs;
  $data['user_id'] = $user_id;

  return view('showhost',$data);
});

// Route::get('/searchhost', function () {
//   echo 5555;
// });


Route::post('/loading', 'HostController@loading');
Route::post('/addhost', 'HostController@store');
// Route::post('/addhost', 'HostController@store');
Route::get('/detailhost/{hostid}', 'HostController@show');
Route::post('/searchhost', 'HostController@search');
Route::get('/hostall/{id}', 'HostController@showhost');
Route::post('/checkpath', 'ConfigController@check');
Route::post('/delconfig', 'ConfigController@deleteConfig');
Route::post('/adddesc', 'DescriptionController@addDescription');
Route::post('/editdesc', 'DescriptionController@editDescription');
Route::post('/deldesc', 'DescriptionController@deleteDescription');
Route::get('/detailrepo/{configid}', 'ConfigController@show');
Route::get('/editconfig/{configid}', 'ConfigController@editconfig');
Route::get('/detailversion/{versionid}', 'ConfigController@showcontent');
Route::get('search/autocomplete', 'SearchController@autocomplete');
Route::post('/revision', 'ConfigController@revisionconfig');
Route::post('/savecommit', 'ConfigController@savecommit');
Route::post('/savefile', 'ConfigController@editconfig');


//About Gitlab API

// Route::get('/search', function () {
//   return view('autocomplete');
// });

SSH::into('gitlab')->run(array(

  // Private Token of root: 4sST2ksaug4EnxHMHd-T
  // Create User
  // "sudo curl --silent --header 'PRIVATE-TOKEN: 4sST2ksaug4EnxHMHd-T' -X POST 'http://13.228.10.174/api/v4/users/?email=email8@example.com&username=test8&name=test&password=testeieiei'",

  //Create Impersonal Token
  //"sudo curl --silent --request POST --header 'PRIVATE-TOKEN: 4sST2ksaug4EnxHMHd-T' --data 'name=mytoken' --data 'expires_at=2017-04-04' --data 'scopes[]=api' http://13.228.10.174/api/v4/users/:user_id/impersonation_tokens",
  //Get Impersonal Token and Insert it to Database

  //Using Impersonal Token instead of Private Token (Impersonal Token: Yy7H679yiYqysDCaLTmB)
  //"sudo curl --silent --header 'PRIVATE-TOKEN: Yy7H679yiYqysDCaLTmB' -X GET 'http://13.228.10.174/api/v4/projects'",

  // "sudo curl --silent --header 'PRIVATE-TOKEN: 4sST2ksaug4EnxHMHd-T' -X POST 'http://13.228.10.174/api/v4/projects/user/19?name=MyProject3&visibility=public'",
), function($line){

  // Return JSON Syntax
  //echo $line;

  // Decode JSON Syntax to Array
  // $jsonArray = json_decode($line);

  // Access the property's value by specific property's name
  // print_r($jsonArray[0]->id." ".$jsonArray[0]->http_url_to_repo);

  //
  // echo $jsonArray[1]->name;
  // $value = array_get($jsonArray, 'username');
  // echo $line;
  // return dd($jsonArray);
  // echo $value;
});

Route::get('/testapicreateuser', function () {

  //Create User and get user_id property
  //PRIVATE-TOKEN = Account -> PRIVATE-TOKEN

  SSH::into('gitlab')->run(array(
    //OLD Gitlab Server
    // "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: 4sST2ksaug4EnxHMHd-T' --data 'username=adminfam' --data 'password=adminfameiei' --data 'name=AdminFam' --data 'email=adminfam@example.com' http://13.228.10.174/api/v4/users",

    //NEW Gitlab Server
    "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: maFg6FdYbeheyfdpztx_' --data 'username=ubuntu' --data 'password=ubuntueiei' --data 'name=ubuntu' --data 'email=ubuntu@example.com' --data 'skip_confirmation=true' http://52.221.75.98/api/v4/users",

  ), function($line){

    $jsonArray = json_decode($line);

    print_r("User ID: ".$jsonArray->id);

  });

});

Route::get('/testapicreatetoken', function () {

  //Create Impersonal Token and get token

  $user_id = 4;

  SSH::into('gitlab')->run(array(

    "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: maFg6FdYbeheyfdpztx_' --data 'name=mytoken1' --data 'expires_at=2018-01-01' --data 'scopes[]=api' http://52.221.75.98/api/v4/users/$user_id/impersonation_tokens",

  ), function($line){


    $jsonArray = json_decode($line);

    print_r("Impersonal Token: ".$jsonArray->token);

  });
});

Route::get('/testapicreaterepo', function () {

  //Create Repository by Using Impersonal Token

  $user_id = 29;
  $imp_token = "9zxm6Uvgy4m_xbP-qvH7";
  $proj_name = str_random(20);

  SSH::into('gitlab')->run(array(

    "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: $imp_token' --data 'name=$proj_name' http://13.228.10.174/api/v4/projects",

  ), function($line){

    $jsonArray = json_decode($line);

    print_r("Project ID: ".$jsonArray->id.", Project Name(keygen): ".$jsonArray->name.", Project Path(.git): ".$jsonArray->path);

  });
});

Route::get('/testapilistrepo', function () {

  //List Repositories by Using Impersonal Token

  $user_id = 29;
  $imp_token = "UmM88DPkcbo6hRVC_TBo";

  SSH::into('gitlab')->run(array(

    "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' http://13.228.10.174/api/v4/projects",

  ), function($line){
    // echo $line;

    $jsonArray = json_decode($line);
    //

    // return dd($jsonArray);

    foreach ($jsonArray as $item) {
      # code...
      print_r("Project ID: ".$item->id.", Project Name(keygen): ".$item->name.", Project Path(.git): ".$item->path); echo '<br/>';

    }
    //
    // print_r("Project ID: ".$jsonArray[0]->id.", Project Name(keygen): ".$jsonArray[0]->name.", Project Path(.git): ".$jsonArray[0]->path);

  });
});

Route::get('/testapilistrepocommits', function () {

  //List Repository Commits by Using Impersonal Token

  $user_id = 29;
  $proj_id = 57;
  $imp_token = "y8sjNrH5eoPoL2HEsAtk";

  SSH::into('gitlab')->run(array(

    "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' http://13.228.10.174/api/v4/projects/$proj_id/repository/commits",

  ), function($line){
    // echo $line;

    $jsonArray = json_decode($line);

    // return dd($jsonArray);

    foreach ($jsonArray as $item) {
      # code...
      print_r("Revision short ID: ".$item->short_id.", Commits Title: ".$item->title); echo '<br/>';

    }

  });
});

Route::get('/testdecode', function () {

  $imp_token = "eWQofD635bPE5auXVNAE";
  $proj_id = 69 ;

  $file = "eiei.conf";
  $out = str_replace('.','%2E',$file);
  // echo $out;

  SSH::into('gitlab')->run(array(

    "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' 'http://13.228.10.174/api/v4/projects/$proj_id/repository/files/$out/raw?ref=master'",

  ), function($line){
    echo nl2br($line);
    // $jsonArray = json_decode($line);
    //
    // echo $jsonArray;
    //
    // // return dd($jsonArray);

  });

});

Route::get('/writefile', function () {

  $imp_token = "eWQofD635bPE5auXVNAE";
  $proj_id = 107 ;

  $file = "test.conf";
  $out = str_replace('.','%2E',$file);
  // echo $out;

  SSH::into('gitlab')->run(array(

    "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' 'http://13.228.10.174/api/v4/projects/$proj_id/repository/files/$out/raw?ref=master'",

  ), function($line){

    echo nl2br($line);
    File::put('css/file.conf',  $line);
    // $jsonArray = json_decode($line);
    //
    // echo $jsonArray;
    //
    // // return dd($jsonArray);

  });

});

Route::get('/testform', function () {

  return view('testform');

});

Route::get('/testace', function () {

  return view('testace');

});

Route::get('/testeditor', function () {

  return view('editconfig');

});













Route::get('/testssh', function () {
  return SSH::into('ansible')->run(array(
    'ansible -m ping ubuntu',
  ), function($line){
    echo $line;
  });
});

Route::get('/testload', function () {
  return view('loadingpage');
});

Route::get('/testping', function () {
  $GLOBALS['total'] = 0;
  SSH::into('ansible')->run(array(
    "ansible -m shell -a 'dmidecode -t 17 | grep Size' client --become",
  ), function($line){
    if (strpos($line, 'SUCCESS') !== false) {
      $bfsize_pos = strpos($line,"Size:");
      $bfmem = substr($line,$bfsize_pos);
      $atmem_pos = strpos($bfmem,"Size: No Module Installed");
      $atmem_all = substr($bfmem,0,$atmem_pos-1);//get Size: xxxx MB ALL
      while(substr_count($atmem_all, 'Size:')!=false){
        $bfint = strpos($atmem_all,'Size:');
        $integ = substr($atmem_all,$bfint+6);
        $atint = strpos($integ,'MB');
        $integ = substr($integ,0,$atint-1);
        $GLOBALS['total']+=$integ;
        $bf = strpos($atmem_all,"MB");
        $atmem_all = substr($atmem_all,$bf+3);
      }
    }});
    $togb = round($GLOBALS['total']/1024)." Gb";
    return $togb;
  });




  Route::get('/remoteansible', function () {
    return SSH::into('ansible')->run(array(
      // 'echo "[laravel2]" | sudo tee --a /etc/ansible/hosts',
      // 'echo "13.228.11.182 ansible_ssh_user=ubuntu ansible_ssh_private_key_file=/etc/ansible/keyfiles/clienttest.pem" | sudo tee --a /etc/ansible/hosts',
      // 'ansible -m ping laravel',
      // 'ansible -m shell -a "mkdir /laravelcome2!" laravel --become'
      'ansible -m shell -a "cat /etc/*-release" TestClient --become',
    ), function($line){
      $bfname_pos = strpos($line,"PRETTY_NAME=")+13;
      $bfname = substr($line,$bfname_pos);
      $afname_pos = strpos($bfname,"\"");
      echo substr($bfname,0,$afname_pos);
    });
  });
