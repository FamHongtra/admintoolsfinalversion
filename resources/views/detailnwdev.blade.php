<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Arsenal" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Abel|Arsenal" rel="stylesheet">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">

  <!-- Sweetalert2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.js"></script>


  <!-- icon -->
  <link rel="stylesheet" href="https://cdn.iconmonstr.com/1.2.0/css/iconmonstr-iconic-font.min.css">
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style media="screen">
  html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Abel', sans-serif;
    font-weight: 100;
    height: 100vh;
    margin: 0;
    /*
    display: flex;
    min-height: 100vh;
    flex-direction: column;*/
  }
  /*
  main {
  flex: 1 0 auto;
  }*/

  .input-field1.input-field input[type=text]:focus + label {
    color: #00acc1;
  }
  .input-field1.input-field input[type=text]:focus {
    border-bottom: 1px solid #00acc1;
    box-shadow: 0 1px 0 0 #00acc1;
  }

  .input-field1.input-field input[type=text].valid {
    border-bottom: 1px solid #0097a7;
    box-shadow: 0 1px 0 0 #0097a7;
  }

  .input-field1.input-field .prefix.active {
    color: #00acc1;
  }
  .input-field1.input-field input[type=number]:focus + label {
    color: #00acc1;
  }
  .input-field1.input-field input[type=number]:focus {
    border-bottom: 1px solid #00acc1;
    box-shadow: 0 1px 0 0 #00acc1;
  }
  .input-field1.input-field input[type=number].valid {
    border-bottom: 1px solid #0097a7;
    box-shadow: 0 1px 0 0 #0097a7;
  }

  .input-field2.input-field input[type=text]:focus + label {
    color: #00bfa5;
  }
  .input-field2.input-field input[type=text]:focus {
    border-bottom: 1px solid #00bfa5;
    box-shadow: 0 1px 0 0 #00bfa5;
  }

  .input-field2.input-field .prefix.active {
    color: #00bfa5;
  }
  .input-field2.input-field input[type=number]:focus + label {
    color: #00bfa5;
  }
  .input-field2.input-field input[type=number]:focus {
    border-bottom: 1px solid #00bfa5;
    box-shadow: 0 1px 0 0 #00bfa5;
  }
  hr.style-four {
    height: 12px;
    border: 0;
    box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);
  }
  .file-path-wrapper input[type=text].valid{
    border-bottom: 1px solid #00acc1;
    box-shadow: 0 1px 0 0 #00acc1;
  }
  .modal { width: 40% !important ; max-height: 55% !important ; overflow-y: hidden !important ;}

  .break-word {
    overflow-wrap: break-word;
  }


  .swal2-modal {
    font-family: 'Abel', sans-serif;
  }
  .circle {
    background-color: white;
    height: 50px;
    width: 50px;
    border-radius: 100%;
  }

  .card-title {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
  }

  .card-title:hover {
    overflow: auto;
    white-space: initial;
    word-wrap: break-word;
  }

  .modal-header {
    padding: 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  }

  .swal2-modal {
    font-family: 'Abel', sans-serif;
  }

  </style>
</head>


@if (Session::has('status'))
<body onload="hasmsg()">
  @else
  <body>
    @endif


    <div class="navbar-fixed">
      <ul id="dropdown1" class="dropdown-content">
        <li><a href="#!">Account Settings</a></li>
        <!-- <admin area -->
        @if (session('user_id')==1)
        <li><a href="#!" onclick="createUser()">User Creation</a></li>
        @endif
        <!-- admin area/> -->
        <li class="divider"></li>
        <li><a href="{{url('userlogout')}}"  onclick="return loading();" >Logout</a></li>
      </ul>
      <nav>
        <div class="nav-wrapper teal lighten-1 ">
          <a href="{{url('showhost')}}"  onclick="return loading();" class="brand-logo"><img src="../img/logo0.png" height="50px" style="margin: 7px"/></a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><div class="circle" height="50px" style="margin: 7px;background-color:white"><canvas width="40" height="40" style="margin: 5px" data-jdenticon-value="{{session('user_id')}}"></canvas></div></li>
            @php
            $user_name = DB::table('users')
            ->where('id', session('user_id'))
            ->value('name');
            @endphp
            <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Hello, {{$user_name}}<i class="material-icons right">arrow_drop_down</i></a></li>
          </ul>
        </div>
      </nav>
    </div>

    <div class="row">

    </div>
    <div class="row">
      <div class="col s7">
        <div class="col s4" align="left">
          <a class="waves-effect waves-light btn-large" style="width:200px" href="{{url('shownwdev')}}" onclick="return loading();"><i class="material-icons left">arrow_back</i>Back</a>
        </div>
      </div>
    </div>
    <div id="openmodal" style="display:none">
      @if($errors->any())
      {{$errors->first()}}
      @endif
    </div>
    <div class="row">

      <div class="col s12" align="center"></div>

      <div class="col s12 m12 l8">

        <div class="col s12 m12 l4" align="center">
          <div class="card cyan darken-3" style="width:250px">
            <h5 style="padding:10px;color:white">{{$obj->servername}}</h5>
          </div>
          <div class="card" style="width:250px;">
            <div class="card-image" style="padding:20px">
              <img src="../img/network_device.png">
              <span class="card-title" style="color:#263238"><b>{{$obj->host}}</b></span>
            </div>
            <div class="card-action white">
              <a class="modal-trigger waves-effect waves-light btn-large cyan darken-3" href="{{url('checkconnection/'.$controlid)}}" onclick="return loading();"><i class="material-icons left">swap_vert</i>Connection</a>
            </div>
          </div>
        </div>

        <div class="col s12 m12 l8">
          <div class="row">
            <div class="col s12">
              <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                  <span class="card-title"><h4>Cisco -
                    <?php

                    $GLOBALS['total'] = 0;
                    $user_id = session('user_id');
                    $imp_token = DB::table('users')->where('id', $user_id)->value('token');
                    SSH::into('ansible')->run(array(
                      "ansible -i /etc/ansible/users/$imp_token/nw-hosts -m raw -a 'show version' $obj->servername",
                    ), function($line){
                      if (strpos($line, 'SUCCESS') !== false) {
                        $afterserie = strpos($line,") processor");
                        $bfserie = $afterserie - 30 ;
                        $seriecon = substr($line,$bfserie);
                        $bfserie2 = strpos($seriecon,"cisco");
                        $afterserie2 = strpos($seriecon," processor");
                        $serie = substr($seriecon,$bfserie2, ($afterserie2 - $bfserie2));
                        echo $serie;
                      }else{
                        echo "Undifined" ;
                      }
                    }); ?>
                  </h4></span>
                </div>
                <div class="card-action blue-grey lighten-5">
                  <i class="im im-network" style="color:#546e7a;"><span style="font-family: 'Abel', sans-serif;margin-left:20px; color:#546e7a">Network Device Vendor</span></i>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col s6">
              <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                  <span class="card-title" >Operating System</span>
                  <div class="" align="right" style="margin-right:30px">
                    <br>
                    <?php
                    $GLOBALS['total'] = 0;
                    $user_id = session('user_id');
                    $imp_token = DB::table('users')->where('id', $user_id)->value('token');
                    SSH::into('ansible')->run(array(
                      "ansible -i /etc/ansible/users/$imp_token/nw-hosts -m raw -a 'show version' $obj->servername",
                    ), function($line){
                      if (strpos($line, 'SUCCESS') !== false) {
                        $bfos = strpos($line,">>")+3;
                        $afteros = strpos($line," Software");
                        $os = substr($line,$bfos, ($afteros - $bfos));
                        if($os == "Cisco Internetwork Operating System"){
                          echo "<h4>";
                          echo "IOS";
                          echo "</h4>";
                        }else{
                          echo $os;
                        }
                      }else{
                        echo "<h4>Undifined</h4>" ;
                      }
                    }); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col s6">
              <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                  <span class="card-title">System Image Version</span>
                  <div class="" align="right" style="margin-right:30px"><br>
                    <?php
                    $user_id = session('user_id');
                    $imp_token = DB::table('users')->where('id', $user_id)->value('token');
                    SSH::into('ansible')->run(array(
                      "ansible -i /etc/ansible/users/$imp_token/nw-hosts -m raw -a 'show version' $obj->servername",
                    ), function($line){
                      if (strpos($line, 'SUCCESS') !== false) {
                        $bfversion = strpos($line,"Version");
                        $versioncon = substr($line,$bfversion);
                        $afterversion = strpos($versioncon,",");
                        $version = substr($versioncon,0,$afterversion);
                        echo "<h4>";
                        echo $version;
                        echo "</h4>";
                      }else{
                        echo "<h4>Undifined</h4>" ;
                      }
                    }); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
            <div class="card blue-grey darken-1">
              <div class="card-content white-text">
                <div class="row">
                  <div class="col s6 m8 l9">
                    <span class="card-title">Versions of Configuration</span>
                  </div>
                  <div class="col s6 m4 l3" align="right">
                    <a class="modal-trigger waves-effect waves-light btn-large teal" onclick="backupnwdev()"><i class="material-icons left">backup</i>Backup Configuration</a>
                  </div>
                </div>
              </div>
              <?php
              use Illuminate\Support\Facades\DB as DB;
              $configs = DB::table('configs')->where('control_id', $controlid)->get();
              $configid = DB::table('configs')->where('control_id', $controlid)->value('id');
              $configname = DB::table('configs')->where('control_id', $controlid)->value('configname');
              $configpath = DB::table('configs')->where('control_id', $controlid)->value('configpath');
              $configprojid = DB::table('configs')->where('control_id', $controlid)->value('gitlab_projid');
              $configrepo = DB::table('configs')->where('control_id', $controlid)->value('repository');
              $configkeygen = DB::table('configs')->where('control_id', $controlid)->value('keygen');
              ?>
              <div class="card-action blue-grey lighten-5 blue-grey darken-text" >
                <table>
                  <thead>
                    <tr>
                      <!-- <th style="width:4%">No.</th>
                      <th style="width:36%">Configuration Name</th>
                      <th style="width:35%">Path</th>
                      <th style="width:25%">Actions</th> -->
                      <th style="width:5%">No.</th>
                      <th style="width:40%">Version Title</th>
                      <th style="width:5%"></th>
                      <th style="width:20%">Edited by</th>
                      <th style="width:20%">Edited at</th>
                      <th style="width:10%">Actions</th>
                    </tr>
                  </thead>
                  @if(is_array($configversions) || is_object($configversions))
                  @foreach($configversions as $indexKey=>$version)

                  <tbody align="right">
                    <tr id="item{{$indexKey+1}}">
                      <td>{{$indexKey+1}}</td>
                      <td id="itemtitle{{$indexKey+1}}">{{$version->title}}</td>
                      <td></td>
                      <td>{{$version->author_name}}</td>
                      <td>{{substr($version->committed_date,0,10)." ".substr($version->committed_date,11,5)}}</td>
                      <td><a class="modal-trigger waves-effect waves-light btn" href="#modal{{$indexKey+1}}">View</a></td>
                    </tr>
                  </tbody>

                  <div class="container" align="left">
                    <div id="modal{{$indexKey+1}}" class="modal modal-fixed-footer">
                      <div class="modal-header">
                        <h5>{{$version->title}}</h5>
                      </div>

                      <div class="modal-content">
                        @php
                        //impersonal token of gitlab user.

                        //$imp_token = "1xfYQD8Km8LsfWaYVP_d";
                        $user_id = session('user_id');
                        $imp_token = DB::table('users')->where('id', $user_id)->value('token');
                        $proj_id = $configprojid ;




                        SSH::into('gitlab')->run(array(

                        "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' 'http://52.221.75.98//api/v4/projects/$proj_id/repository/files/config/raw?ref=$version->id'",

                        ), function($line){
                          echo nl2br($line);

                        });
                        @endphp
                        <br><br><br><br>
                      </div>
                      <div class="modal-footer">
                        <a id="modalclose" href="#!" class="modal-action modal-close waves-effect btn grey" style="margin-right:10px">Close</a>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  @endif
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col s12 m12 l4">
        <div class="row">
          <div class="col s12"><span style="font-size: 250%; color:#607d8b">About</span><hr style="color: #607d8b">
            <a class="modal-trigger" href="#!" onclick="addDesc()" style="color:#009688"><i class="material-icons left">add</i>add description</a><br><br>
            <!-- <div class="card-panel teal"> -->

            <?php
            $descs = DB::table('descriptions')->where('host_id', $obj->id )->get();
            ?>


            <ul class="collapsible popout" data-collapsible="expandable" >

              @foreach($descs as $indexKey=>$desc)

              <li>
                <div class="collapsible-header blue-grey lighten-5 blue-grey darken-text"><i class="material-icons">dvr</i>{{$desc->descname}}<a class="modal-trigger" onclick="delDesc({{$desc->id}})"><i class="material-icons right" style="color:#009688">delete</i></a><a class="modal-trigger" onclick="editDesc({{$desc->id}})"><i class="material-icons right" style="color:#009688">edit</i></a></div>
                <div class="collapsible-body"><span class="break-word"><?php echo nl2br($desc->descdetail);?></span></div>
                <a href="#modal4" class="modal-trigger" id="clickmodal4" hidden=""></a>
              </li>

              <div id="divdescname{{$desc->id}}" style="display:none">{{$desc->descname}}</div>
              <div id="divdescdetail{{$desc->id}}" style="display:none">{{$desc->descdetail}}</div>


              <div id="delete{{$desc->id}}" class="modal modal-fixed-footer">
                <div class="modal-content">
                  <br>
                  <!-- <h5>Add Host Description</h5> -->
                  <!-- <p>You should add host by using rsa key for secure</p> -->
                  <!-- <hr class="style-four"><br> -->
                  <div class="row">
                    <div class="col s1"></div>
                    <div class="col s10">
                      <br><br><br>
                      <div id="byrsakey" class="row" style="display:block;">
                        <form action="{{url('deldesc')}}" id="deldescform{{$desc->id}}" class="col s12" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="serverid" value="" id="serverid">
                          <input type="hidden" name="descid" value="{{$desc->id}}" id="descid">
                          <div class="row">
                            <div class="col s2"></div>
                            <div class="col s8">
                              <p style="font-size:25px; text-align: center"><i class="material-icons">error_outline</i>Do you want to delete this description?</p>
                            </div>
                          </div><br>
                          <div class="row" align="center">

                            <button class="modal-trigger waves-effect waves-light btn-large teal" type="button" onClick="delDesc({{$desc->id}})" name="button"><i class="material-icons  left">done</i>Ok</button>
                            <button class="modal-action modal-close waves-effect waves-light btn-large teal lighten-2" type="button" name="button" data-dismiss="modal"><i class="material-icons  left">close</i>Cancle</button>
                          </div>
                          <div id="errormsg2" class="row" align="center" style="display:none">
                            <i class="material-icons prefix" style="color:#b71c1c">info_outline</i><span style="color:#b71c1c"> Invalid input, please check your informations.</span>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach

              <!-- <li>
              <div class="collapsible-header"><i class="material-icons">dvr</i>Second</div>
              <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
            </li>
            <li>
            <div class="collapsible-header"><i class="material-icons">dvr</i>Third</div>
            <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
          </li> -->
        </ul>
        <!-- <span class="white-text">I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks. I am similar to what is called a panel in otI am similar to what is called a panel in other frameworks.I am similar to what is called a panel in other frameworks.I am similar to what is called a panel in other frameworks.her frameworks.
      </span> -->
      <!-- </div> -->
    </div>
  </div>
</div>
</div>
<div class="row">
</div>

<div id="server" class="" style="display:none">
  {{$obj->id}}
</div>


<!--Import jQuery before materialize.js-->
<script src="https://cdn.jsdelivr.net/npm/jdenticon@1.7.2" async></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
<script type="text/javascript">
//dialogs

@if (Session::has('status'))
function hasmsg(){
  swal({
    title: "{!! Session::get('title') !!}",
    text: "{!! Session::get('text') !!}",
    type: "{!! Session::get('icon') !!}",
    confirmButtonColor: '#26a69a',
  });

}

// swal("{!! Session::get('title') !!}","{!! Session::get('text') !!}", "{!! Session::get('icon') !!}");

@endif

function loading(){
  swal({
    imageUrl: '../img/load.gif',
    imageWidth: 120,
    showCancelButton: false,
    showConfirmButton: false,
    animation: false,
    allowOutsideClick: false,
    confirmButtonColor: '#26a69a',
  });
}

$('#modalclose').modal('close');

function backupnwdev(){

  swal({
    title: 'Add Version Title',
    html:
    '<form action="{{url("backupnwdev")}}" id="backupnwdevform" class="col s12" method="post" enctype="multipart/form-data">'+
    '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
    '<input type="hidden" name="controlid" value="{{$controlid}}" id="controlid">'+
    '<input type="hidden" name="serverid" value="" id="serverid">'+
    '<br><div class="row">'+
    '<div class="col s10 m10 l10 offset-s1 offset-m1 offset-l1">'+
    '<div class="input-field input-field2">'+
    '<i class="material-icons prefix">comment</i>'+
    '<input id="icon_prefix" type="text" name="msgcommit">'+
    '<label for="icon_prefix" align="left">Commit Message</label>'+
    '</div>'+
    '</div>'+
    '</div>'+
    '</form>',
    confirmButtonColor: '#26a69a',
    confirmButtonText: 'Backup',
    showCancelButton: true,
  }).then(function () {

    $("#backupnwdevform").submit();
    swal({
      imageUrl: '../img/load.gif',
      imageWidth: 120,
      showCancelButton: false,
      showConfirmButton: false,
      animation: false,
      allowOutsideClick: false,
      confirmButtonColor: '#26a69a',
    });

  });
}

function addDesc(){

  swal({
    title: 'Add Description',
    html:
    '<form action="{{url("adddesc")}}" id="descform" class="col s12" method="post" enctype="multipart/form-data">'+
    '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
    '<input type="hidden" name="controlid" value="{{$controlid}}" id="controlid">'+
    '<br><div class="row">'+
    '<div class="col s10 m10 l10 offset-s1 offset-m1 offset-l1">'+
    '<div class="input-field input-field2">'+
    '<i class="material-icons prefix">description</i>'+
    '<input id="icon_prefix" type="text" class="validate" name="descname">'+
    '<label for="icon_prefix" align="left">Description Name</label>'+
    '</div>'+
    '<div class="input-field input-field2">'+
    '<i class="material-icons prefix">line_weight</i>'+
    '<textarea name="descdetail" id="icon_prefix2" class="materialize-textarea"></textarea>'+
    '<label for="icon_prefix2" align="left">Description Detail</label>'+
    '</div>'+
    '</div>'+
    '</div>'+
    '</form>',
    confirmButtonColor: '#26a69a',
    confirmButtonText: 'Save',
    showCancelButton: true,
  }).then(function () {

    var descname = $('#descform').find('input[name="descname"]').val();
    var descdetail = $('#descform').find('textarea[name="descdetail"]').val();

    var regex_descname = /^([a-zA-Z0-9 ]{1,})$/.test(descname);
    var regex_descdetail = /^([a-zA-Z0-9 ]{1,})$/.test(descdetail);

    if(regex_descname && regex_descdetail){
      $("#descform").submit();
      swal({
        imageUrl: '../img/load.gif',
        imageWidth: 120,
        showCancelButton: false,
        showConfirmButton: false,
        animation: false,
        allowOutsideClick: false,
        confirmButtonColor: '#26a69a',
      });
    }else{
      var invalid = "Description name field and Description detail field are requied.";

      swal({
        title: "Invalid Input!",
        text: ""+invalid,
        type: "warning",
        confirmButtonColor: '#26a69a',
      }).then(function (){
        addDesc();
      });
    }

  });
}

function editDesc(id){

  var divdescname = document.getElementById('divdescname'+id).textContent ;
  var divdescdetail = document.getElementById('divdescdetail'+id).textContent ;

  swal({
    title: 'Edit Description',
    html:
    '<form action="{{url("editdesc")}}" id="editdescform'+id+'" class="col s12" method="post" enctype="multipart/form-data">'+
    '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
    '<input type="hidden" name="controlid" value="{{$controlid}}" id="controlid">'+
    '<input type="hidden" name="descid" value="'+id+'" id="descid">'+
    '<br><div class="row">'+
    '<div class="col s10 m10 l10 offset-s1 offset-m1 offset-l1">'+
    '<div class="input-field input-field2">'+
    '<i class="material-icons prefix">description</i>'+
    '<input id="icon_prefix" type="text" name="descname" value="'+divdescname+'">'+
    '<label class="active" for="icon_prefix" align="left">Description Name</label>'+
    '</div>'+
    '<div class="input-field input-field2">'+
    '<i class="material-icons prefix">line_weight</i>'+
    '<textarea name="descdetail" id="icon_prefix2" class="materialize-textarea">'+divdescdetail+'</textarea>'+
    '<label class="active" for="icon_prefix2" align="left">Description Detail</label>'+
    '</div>'+
    '</div>'+
    '</div>'+
    '</form>',
    confirmButtonColor: '#26a69a',
    confirmButtonText: 'Update',
    showCancelButton: true,
  }).then(function () {
    $("#editdescform"+id).submit();
    swal({
      imageUrl: '../img/load.gif',
      imageWidth: 120,
      showCancelButton: false,
      showConfirmButton: false,
      animation: false,
      allowOutsideClick: false,
      confirmButtonColor: '#26a69a',
    });
  });
}

// function delDesc(id){
//   // alert("Hello"+id);
//
//   $idform=document.getElementById('deldescform'+id);
//
//   $server = document.getElementById('server').textContent ;
//   $idform.elements.namedItem('serverid').value = $server;
//
//   swal({
//     imageUrl: '../img/load.gif',
//     imageWidth: 120,
//     showCancelButton: false,
//     showConfirmButton: false,
//     animation: false,
//     allowOutsideClick: false,
//     confirmButtonColor: '#26a69a',
//   });
//   $('#delete'+id).modal().hide();
//
//   $("#deldescform"+id).submit();
//
// }

function delDesc(id) {
  swal({
    title: 'Are you sure?',
    text: "The description will be deleted.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#26a69a',
    confirmButtonText: 'Yes'
  }).then(function () {
    $("#deldescform"+id).submit();
    swal({
      imageUrl: '../img/load.gif',
      imageWidth: 120,
      showCancelButton: false,
      showConfirmButton: false,
      animation: false,
      allowOutsideClick: false,
      confirmButtonColor: '#26a69a',
    });
  });
}

function delConf(id) {
  swal({
    title: 'Are you sure?',
    text: "The configuration repository will be deleted.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#26a69a',
    confirmButtonText: 'Yes'
  }).then(function () {
    $("#delconfigform"+id).submit();
    swal({
      imageUrl: '../img/load.gif',
      imageWidth: 120,
      showCancelButton: false,
      showConfirmButton: false,
      animation: false,
      allowOutsideClick: false,
      confirmButtonColor: '#26a69a',
    });
  });
}

//modal scripts
$(document).ready(function(){
  // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
  $('.modal').modal();
});

$(document).ready(function(){
  $('.collapsible').collapsible();
});


function byPassword() {
  document.getElementById('byrsakey').style.display = "none";
  document.getElementById('bypassword').style.display = "block";
  $("#password").removeClass('teal accent-4');
  $("#password").addClass('teal darken-3');
  $("#rsakey").removeClass('cyan darken-3');
  $("#rsakey").addClass('cyan darken-1');
}
function byRSAKey() {
  document.getElementById('bypassword').style.display = "none";
  document.getElementById('byrsakey').style.display = "block";
  $("#password").removeClass('teal darken-3');
  $("#password").addClass('teal accent-4');
  $("#rsakey").removeClass('cyan darken-1');
  $("#rsakey").addClass('cyan darken-3');
}


$("#submitbtn").on('click', function(){
  $form1 = document.getElementById('byrsakey').style.display ;

  $form2 = document.getElementById('bypassword').style.display ;
  if($form1 == "block"){
    alert('Sent form RSA');
    $("#hostform").submit();
  }else if($form2 == "block"){
    alert('Sent form Pass');
    $("#hostform2").submit();
  }
});

</script>
</body>

</html>
