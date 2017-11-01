<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
  .modal { max-height: 70% !important ; overflow-y: hidden !important ;}

  .break-word {
    overflow-wrap: break-word;
  }

  .modal-header {
    padding: 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
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
  </style>
</head>


@if (Session::has('status'))
<body onload="hasmsg()">
  @else
  <body onload="showCurrent()">
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
          <a class="waves-effect waves-light btn-large" style="width:200px" href="{{url('detailhost/'.$controlid)}}" onclick="return loading();"><i class="material-icons left">arrow_back</i>Back</a>
        </div>
      </div>
    </div>
    <div id="openmodal" style="display:none">
      @if($errors->any())
      {{$errors->first()}}
      @endif
    </div>
    <div class="row">
      <div class="col s12 m12 l6">
        <div class="col s12 m12 l4" align="center">
          <div class="card cyan darken-3" style="width:250px">
            <h5 style="padding:10px;color:white">{{$obj->servername}}</h5>
          </div>
          <div class="card" style="width:250px;">
            <div class="card-image" style="padding:20px">
              <img src="../img/server_device.png">
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
                  <div class="row">
                    <div class="col s9">
                      <span class="card-title">Repository of Configurations</span>
                    </div>
                  </div>
                </div>
                <?php
                use Illuminate\Support\Facades\DB as DB;
                $configs = DB::table('configs')->where('control_id', $controlid)->get();
                // $configid = DB::table('configs')->where('id', $id)->value('id');
                $configname = DB::table('configs')->where('id', $configid)->value('configname');
                $configpath = DB::table('configs')->where('id', $configid)->value('configpath');
                $configprojid = DB::table('configs')->where('id', $configid)->value('gitlab_projid');
                $configrepo = DB::table('configs')->where('id', $configid)->value('repository');
                $configkeygen = DB::table('configs')->where('id', $configid)->value('keygen');
                ?>
                <div class="card-action blue-grey lighten-5 blue-grey darken-text" >
                  <table>
                    <thead>
                      <tr>
                        <th style="width:4%">No.</th>
                        <th style="width:66%">Configuration Name (Path)</th>
                        <!-- <th style="width:35%">Path</th> -->
                        <th style="width:30%">Actions</th>
                      </tr>
                    </thead>
                    @if(is_array($configs) || is_object($configs))
                    @foreach($configs as $indexKey=>$config)
                    <tbody align="right">
                      <tr>
                        <td>{{$indexKey+1}}</td>
                        <td>{{$config->configname}}<br>({{$config->configpath}})</td>
                        <!-- <td>{{$config->configpath}}</td> -->
                        <td><a class="waves-effect waves-light btn" href="{{url('detailrepo/'.$config->id)}}" onclick="return loading();">Show Versions</a></td>
                      </tr>
                    </tbody>
                    @endforeach
                    @endif
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col s12 m12 l6">
        <div class="row">
          <div class="col s12"><span style="font-size: 250%; color:#607d8b">Versions of Configuration</span><hr style="color: #607d8b"><br>
            <div class="card">
              <div class="card-content">
                <div class="row">
                  <div class="col s12" align="center">
                    <div class="" align="right">
                      <a class="modal-trigger waves-effect waves-light btn-flat" href="{{url('editconfig/'.$configid)}}" onclick="return loading();"><i class="material-icons left">edit</i>Edit</a>
                    </div>
                    <span class="card-title">Configurations Name: {{$configname}}<br><b>({{$configpath}})</b></span>
                  </div>
                </div>
              </div>
              <div class="card-action" >
                <table>
                  <thead>
                    <tr>
                      <th style="width:4%">No.</th>
                      <th style="width:40%">Version Title</th>
                      <th style="width:5%"></th>
                      <th style="width:14%">Edited by</th>
                      <th style="width:17%">Edited at</th>
                      <th style="width:10%">Version ID</th>
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
                      <td>{{$version->short_id}}</td>
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


                        $conf =substr($configpath, strrpos($configpath, '/') + 1);

                        $out = str_replace('.','%2E',$conf);

                        SSH::into('gitlab')->run(array(

                        "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' 'https://52.221.75.98//api/v4/projects/$proj_id/repository/files/$out/raw?ref=$version->id'",

                        ), function($line){
                          echo nl2br($line);

                        });
                        @endphp
                        <br><br><br><br>
                      </div>
                      <div class="modal-footer">
                        <a onClick="revisionSubmit({{$indexKey+1}})" class="modal-action modal-close waves-effect waves-green btn teal" style="margin-right:10px"><i class="material-icons left">rotate_left</i>Revision</a>
                      </div>
                    </div>
                  </div>


                  <form id="versform{{$indexKey+1}}" action="{{url('revision')}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="configid" value="{{ $configid }}">
                    <input type="hidden" name="configrepo" value="{{ $configrepo }}">
                    <input type="hidden" name="configkeygen" value="{{ $configkeygen }}">
                    <input type="hidden" name="revisionid" value="{{ $version->short_id }}">
                    <input type="hidden" name="serverid" value="{{$obj->id}}">
                    <input type="hidden" name="servername" value="{{$obj->servername}}">
                    <input type="hidden" name="configpath" value="{{$configpath}}">
                  </form>
                  @endforeach
                  @endif
                </table>
              </div>
            </div>

            <div id="modallastest" class="modal modal-fixed-footer">
              <div class="modal-header">
                <h5>{{$configname." (".$configpath.")"}}</h5>
              </div>

              <div class="modal-content">
                <div class="row">
                  <form class="col s12">
                    <div class="row">
                      <div class="input-field col s12">
                        <textarea id="textarea1" class="materialize-textarea">
                          @php
                          //impersonal token of gitlab user.
                          //$imp_token = "1xfYQD8Km8LsfWaYVP_d";

                          $user_id = session('user_id');
                          $imp_token = DB::table('users')->where('id', $user_id)->value('token');

                          $proj_id = $configprojid ;


                          $conf =substr($configpath, strrpos($configpath, '/') + 1);

                          $out = str_replace('.','%2E',$conf);

                          SSH::into('gitlab')->run(array(

                          "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' 'https://52.221.75.98//api/v4/projects/$proj_id/repository/files/$out/raw?ref=master'",

                          ), function($line){
                            echo $line;

                          });
                          @endphp</textarea>
                          <label for="textarea1"></label>
                        </div>
                      </div>
                    </form>
                  </div>
                  <br><br><br><br>
                </div>
                <div class="modal-footer">
                  <a onClick="revisionSubmit({{$indexKey+1}})" class="modal-action modal-close waves-effect waves-green btn teal" style="margin-right:10px"><i class="material-icons left">rotate_left</i>Revision</a><a href="#!" class="modal-action modal-close waves-effect waves-green btn teal lighten-2" style="margin-right:10px">Close</a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="row">
      </div>

      <div id="server" class="" style="display:none">
        {{$obj->id}}
      </div>
      <div class="container" align="left">
        <!-- Page Content goes here -->


        <!-- Modal Structure -->

        <!-- add config path -->




        <div id="status"  style="display:none">

          <?php
          use Collective\Remote\RemoteFacade as SSH ;
          $user_id = session('user_id');
          $imp_token = DB::table('users')->where('id', $user_id)->value('token');

          SSH::into('ansible')->run(array(
            "ansible -i /etc/ansible/users/$imp_token/hosts -m ping $obj->servername",
          ), function($line){
            // if (strpos($line, 'pong') !== false) {
            //   echo "<span>connected</span>" ;
            // }
            echo $line;
          });
          ?>
        </div>
      </div>



      <!-- <script src="js/progressbar.js"></script> -->

      <!--Import jQuery before materialize.js-->
      <script src="https://cdn.jsdelivr.net/npm/jdenticon@1.7.2" async></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>


      <script type="text/javascript">
      //dialogs
      @if (Session::has('status'))
      function hasmsg(){
        if("{!! Session::get('status') !!}" == "connection"){
          swal({
            title: "{!! Session::get('title') !!}",
            text: "{!! Session::get('text') !!}",
            type: "{!! Session::get('icon') !!}",
            confirmButtonColor: '#26a69a',
          });
        }else if("{!! Session::get('status') !!}" == "success"){

          swal({
            title: "{!! Session::get('title') !!}",
            text: "{!! Session::get('text') !!}",
            type: "{!! Session::get('icon') !!}",
            confirmButtonColor: '#26a69a',
          });

        }else{
          swal({
            title: "{!! Session::get('title') !!}",
            text: "{!! Session::get('text') !!}",
            type: "{!! Session::get('icon') !!}",
            showCancelButton: true,
            confirmButtonColor: '#26a69a',
            confirmButtonText: 'See more details'
          }).then(function () {
            swal({
              text: "{!! Session::get('failuremsg') !!}",
              confirmButtonColor: '#26a69a',
            });
          });
        }

        // swal({

        //   showCancelButton: true,

        //   confirmButtonText: 'see more details',
        //   closeOnConfirm: false,
        //   closeOnCancel: false
        // }).then(function() {
        // swal({
        //   title: "Error Message"
        //   text: "{!! Session::get('failuremsg') !!}",
        //   confirmButtonColor: '#26a69a',
        // });
        // });

        document.getElementById('itemtitle1').innerHTML = document.getElementById('itemtitle1').textContent+"<br>(Current Version)";
        // swal("{!! Session::get('title') !!}","{!! Session::get('text') !!}", "{!! Session::get('icon') !!}");

      }
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

      function addDesc(){

        $idform=document.getElementById('descform');

        $server = document.getElementById('server').textContent ;
        $idform.elements.namedItem('serverid').value = $server;


        $formdescname = $idform.elements.namedItem("descname").value;

        $descnamepatt = new RegExp("^[a-zA-Z0-9-@]{1,32}$");
        $resvaliddescname = $descnamepatt.test($formdescname);

        $formdescdetail = $idform.elements.namedItem("descdetail").value;

        if( ($formdescname != "") && ($formdescdetail != "")){
          if($resvaliddescname){
            document.getElementById('errormsg2').style.display = "none" ;
            $("#descform").submit();
          }else{
            document.getElementById('errormsg2').style.display = "block" ;
          }
        }else{
          document.getElementById('errormsg2').style.display = "block" ;
        }

      }

      function editDesc(id){
        // alert("Hello"+id);

        $idform=document.getElementById('editdescform'+id);

        $server = document.getElementById('server').textContent ;
        $idform.elements.namedItem('serverid').value = $server;


        $formdescname = $idform.elements.namedItem("descname").value;

        $descnamepatt = new RegExp("^[a-zA-Z0-9-@]{1,32}$");
        $resvaliddescname = $descnamepatt.test($formdescname);

        $formdescdetail = $idform.elements.namedItem("descdetail").value;

        if( ($formdescname != "") && ($formdescdetail != "")){
          if($resvaliddescname){
            document.getElementById('errormsg2').style.display = "none" ;
            $("#editdescform"+id).submit();
          }else{
            document.getElementById('errormsg2').style.display = "block" ;
          }
        }else{
          document.getElementById('errormsg2').style.display = "block" ;
        }

      }


      function revisionSubmit(id){

        swal({
          imageUrl: '../img/load.gif',
          imageWidth: 120,
          showCancelButton: false,
          showConfirmButton: false,
          animation: false,
          allowOutsideClick: false,
          confirmButtonColor: '#26a69a',
        });
        $("#versform"+id).submit();


      }

      function delDesc(id){
        // alert("Hello"+id);

        $idform=document.getElementById('deldescform'+id);

        $server = document.getElementById('server').textContent ;
        $idform.elements.namedItem('serverid').value = $server;

        $("#deldescform"+id).submit();

      }

      function chkconfigname(){


        $idform=document.getElementById('hostform');
        $formpathname = $idform.elements.namedItem("pathname").value;
        $server = document.getElementById('server').textContent ;
        $idform.elements.namedItem('serverid').value = $server;

        $pathnamepatt = new RegExp("^[a-zA-Z0-9-@]{1,32}$");
        $resvalidpathname = $pathnamepatt.test($formpathname);

        $formpathconf = $idform.elements.namedItem("pathconf").value;
        if( ($formpathname != "") && ($formpathconf != "")){
          if($resvalidpathname){
            document.getElementById('errormsg1').style.display = "none" ;
            $("#hostform").submit();
          }else{
            document.getElementById('errormsg1').style.display = "block" ;
          }
        }else{
          document.getElementById('errormsg1').style.display = "block" ;
        }

      }

      function showCurrent(){

        document.getElementById('itemtitle1').innerHTML = document.getElementById('itemtitle1').textContent+"<br>(Current Version)";

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
