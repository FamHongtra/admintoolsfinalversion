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
        <li class="divider"></li>
        <li><a href="{{url('userlogout')}}"  onclick="return loading();" >Logout</a></li>
      </ul>
      <nav>
        <div class="nav-wrapper teal lighten-1 ">
          <a href="{{url('showhost')}}"  onclick="return loading();" class="brand-logo"><img src="../img/logo0.png" height="50px" style="margin: 7px"/></a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><div class="circle" height="50px" style="margin: 7px;background-color:white"><canvas width="40" height="40" style="margin: 5px" data-jdenticon-value="{{session('user_id')}}"></canvas></div></li>
            <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Hello, Folder<i class="material-icons right">arrow_drop_down</i></a></li>
          </ul>
        </div>
      </nav>
    </div>

    <div class="row">

    </div>
    <div class="row">
      <div class="col s7">
        <div class="col s4" align="left">
          <a class="waves-effect waves-light btn-large" style="width:200px" href="{{url('showhost')}}" onclick="return loading();"><i class="material-icons left">arrow_back</i>Back</a>
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
            <h5 style="padding:10px;color:white">{{$obj->servername}}<a href=""><i class="material-icons right" style="color:white">settings</i></a></h5>
          </div>
          <div class="card" style="width:250px;">
            <div class="card-image" style="padding:20px">
              <img src="../img/server.png">
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
                  <span class="card-title"><h4>
                    <?php SSH::into('ansible')->run(array(
                      "ansible -m shell -a 'cat /etc/*-release' $obj->servername --become",
                    ), function($line){
                      if (strpos($line, 'SUCCESS') !== false) {
                        $bfname_pos = strpos($line,"PRETTY_NAME=")+13;
                        $bfname = substr($line,$bfname_pos);
                        $afname_pos = strpos($bfname,"\"");
                        $osversion = substr($bfname,0,$afname_pos);
                        echo $osversion;
                      }else{
                        echo "Undifined" ;
                      }
                    }); ?></h4></span>
                  </div>
                  <div class="card-action blue-grey lighten-5">
                    <i class="im im-linux-os" style="color:#546e7a;"><span style="font-family: 'Abel', sans-serif;margin-left:20px; color:#546e7a">Linux OS Version</span></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s6">
                <div class="card blue-grey darken-1">
                  <div class="card-content white-text">
                    <span class="card-title">Processor</span>
                    <?php SSH::into('ansible')->run(array(
                      "ansible -m shell -a 'cat /proc/cpuinfo | grep \"model name\" | uniq' $obj->servername --become",
                    ), function($line){
                      if (strpos($line, 'SUCCESS') !== false) {
                        $bfcpu_pos = strpos($line,":")+1;
                        $bfcpu = substr($line,$bfcpu_pos);
                        $atcpu_pos = strpos($bfcpu,"@");
                        $atcpu = substr($bfcpu,0,$atcpu_pos-1);

                        $cpuspeed = substr($bfcpu,$atcpu_pos+1);
                        echo $atcpu;
                        echo "<div align=\"right\" style=\"margin-right:30px\"><h4>$cpuspeed</h4></div>";
                      }else{
                        echo "<br>";
                        echo "<div align=\"right\" style=\"margin-right:30px\"><h4>Undifined</h4></div>" ;
                      }
                    }); ?>
                  </div>
                </div>
              </div>

              <div class="col s6">
                <div class="card blue-grey darken-1">
                  <div class="card-content white-text">
                    <span class="card-title" >Installed memory</span>
                    <div class="" align="right" style="margin-right:30px">
                      <br>
                      <?php
                      $GLOBALS['total'] = 0;
                      SSH::into('ansible')->run(array(
                        "ansible -m shell -a 'dmidecode -t 17 | grep Size' $obj->servername --become",
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
                          echo "<h4>";
                          echo round($GLOBALS['total']/1024)." Gb";
                          echo "</h4>";
                        }else{
                          echo "<h4>Undifined</h4>";
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
                      <span class="card-title">Repository of Configurations</span>
                    </div>
                    <div class="col s6 m4 l3" align="right">
                      <a class="modal-trigger waves-effect waves-light btn-large teal" onclick="chkconfigname()"><i class="material-icons left">add</i>Add Config</a>
                    </div>
                  </div>
                </div>
                <?php
                use Illuminate\Support\Facades\DB as DB;
                $configs = DB::table('configs')->where('control_id', $controlid)->get();
                ?>
                <div class="card-action blue-grey lighten-5 blue-grey darken-text" >
                  <table>
                    <thead>
                      <tr>
                        <th style="width:4%">No.</th>
                        <th style="width:36%">Configuration Name</th>
                        <th style="width:35%">Path</th>
                        <th style="width:25%">Actions</th>
                      </tr>
                    </thead>
                    @foreach($configs as $indexKey=>$config)
                    <tbody align="right">
                      <tr>
                        <td>{{$indexKey+1}}</td>
                        <td>{{$config->configname}}</td>
                        <td>{{$config->configpath}}</td>
                        <td><a class="waves-effect waves-light btn" href="{{url('detailrepo/'.$config->id)}}" onclick="return loading();" style="width:120px">View</a> <a class="modal-trigger waves-effect waves-light btn" onclick="delConf({{$config->id}})" style="width:120px">Delete</a></td>
                      </tr>
                    </tbody>
                    <div id="delconfig{{$config->id}}" class="modal modal-fixed-footer">
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
                              <form action="{{url('delconfig')}}" id="delconfigform{{$config->id}}" class="col s12" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="serverid" value="" id="serverid">
                                <input type="hidden" name="configid" value="{{$config->id}}" id="configid">
                                <div class="row">
                                  <div class="col s2"></div>
                                  <div class="col s8">
                                    <p style="font-size:25px; text-align: center"><i class="material-icons">error_outline</i>Do you want to delete this config?</p>
                                  </div>
                                </div><br>
                                <div class="row" align="center">

                                  <button class="modal-trigger waves-effect waves-light btn-large teal" type="button" onClick="delConf({{$config->id}})" name="button"><i class="material-icons  left">done</i>Ok</button>
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
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col s12 m12 l4">
          <div class="row">
            <div class="col s12"><span style="font-size: 250%; color:#607d8b">About Host</span><hr style="color: #607d8b">
              <a class="modal-trigger" href="#!" onclick="addDesc()" style="color:#009688"><i class="material-icons left">add</i>add host description</a><br><br>
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

function chkconfigname(){

  swal({
    title: 'Add Configuration',
    html:
    '<form action="{{url("checkpath")}}" id="hostform" class="col s12" method="post" enctype="multipart/form-data">'+
    '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
    '<input type="hidden" name="controlid" value="{{$controlid}}" id="controlid">'+
    '<input type="hidden" name="serverid" value="" id="serverid">'+
    '<br><div class="row">'+
    '<div class="col s10 m10 l10 offset-s1 offset-m1 offset-l1">'+
    '<div class="input-field input-field2">'+
    '<i class="material-icons prefix">description</i>'+
    '<input id="icon_prefix" type="text" name="pathname">'+
    '<label for="icon_prefix" align="left">Configuration Name</label>'+
    '</div>'+
    '<div class="input-field input-field2">'+
    '<i class="material-icons prefix">label</i>'+
    '<input id="icon_prefix" type="text" name="pathconf">'+
    '<label for="icon_prefix" align="left">Configuration Path</label>'+
    '</div>'+
    '</div>'+
    '</div>'+
    '</form>',
    confirmButtonColor: '#26a69a',
    confirmButtonText: 'Save',
    showCancelButton: true,
  }).then(function () {
    var pathname = $('#hostform').find('input[name="pathname"]').val();
    var pathconf = $('#hostform').find('input[name="pathconf"]').val();

    var regex_pathname = /^([a-zA-Z0-9]{1,})$/.test(pathname);
    var regex_pathconf = /^([a-zA-Z0-9]{1,})$/.test(pathconf);

    if(regex_pathname && regex_pathconf){

      $("#hostform").submit();
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
      var invalid = "Configuration name field and Configuration path field are requied.";

      swal({
        title: "Invalid Input!",
        text: ""+invalid,
        type: "warning",
        confirmButtonColor: '#26a69a',
      }).then(function (){
        chkconfigname();
      });
    }

  });
}

function addDesc(){

  swal({
    title: 'Add Host Description',
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

    var regex_descname = /^([a-zA-Z0-9]{1,})$/.test(descname);
    var regex_descdetail = /^([a-zA-Z0-9]{1,})$/.test(descdetail);

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
    title: 'Edit Host Description',
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
    text: "The host description will be deleted.",
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
