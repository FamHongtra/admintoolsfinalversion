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

Route::get('/showhost', function () {

  $objs = App\Host::where('user_id',1)->get();

  $data['objs'] = $objs;
  // foreach ($objs as $obj) {
  //   echo $obj->servername;
  // }

  //
  return view('showhost',$data);
});

Route::post('/loading', 'HostController@loading');
Route::post('/addhost', 'HostController@store');
// Route::post('/addhost', 'HostController@store');
Route::get('/detailhost/{hostid}', 'HostController@show');
Route::get('/hostall/{id}', 'HostController@showhost');
Route::post('/checkpath', 'ConfigController@check');
Route::post('/adddesc', 'DescriptionController@addDescription');
Route::post('/editdesc', 'DescriptionController@editDescription');
Route::post('/deldesc', 'DescriptionController@deleteDescription');

//About Gitlab API

Route::get('/testapi', function () {

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
});

Route::get('/testapicreateuser', function () {

  //Create User and get user_id property

  SSH::into('gitlab')->run(array(

    "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: 4sST2ksaug4EnxHMHd-T' --data 'username=usertest' --data 'password=testeieiei' --data 'name=user' --data 'email=usertest@example.com' http://13.228.10.174/api/v4/users",

  ), function($line){

    $jsonArray = json_decode($line);

    print_r("User ID: ".$jsonArray->id);

  });

});

Route::get('/testapicreatetoken', function () {

  //Create Impersonal Token and get token

  $user_id = 28;

  SSH::into('gitlab')->run(array(

    "sudo curl --silent --request POST --header 'PRIVATE-TOKEN: 4sST2ksaug4EnxHMHd-T' --data 'name=mytoken' --data 'expires_at=2018-01-01' --data 'scopes[]=api' http://13.228.10.174/api/v4/users/$user_id/impersonation_tokens",

  ), function($line){


    $jsonArray = json_decode($line);

    print_r("Impersonal Token: ".$jsonArray->token);

  });
});

Route::get('/testapicreaterepo', function () {

  //Create Repository by Using Impersonal Token

  $user_id = 28;
  $imp_token = "y8sjNrH5eoPoL2HEsAtk";
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

  $user_id = 28;
  $imp_token = "y8sjNrH5eoPoL2HEsAtk";

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

  $user_id = 28;
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









Route::get('/testssh', function () {
  return SSH::into('gitlab2')->run(array(
    'echo "Hello3" | sudo tee --a /file',
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
