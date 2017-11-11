<!DOCTYPE html>
<html>
<head>
  <title>Admintools</title>
  <link rel="shortcut icon" href="../img/adminicon.png" />
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Arsenal" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Abel|Arsenal" rel="stylesheet">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
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

  .modal-header {
    padding: 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  }

  #editor {
    border: 1px solid lightgray;
    margin: auto;
    height: 200px;
    width: 100%;
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

<body>
  <?php
  use Illuminate\Support\Facades\DB as DB;
  $configs = DB::table('configs')->where('control_id', $controlid)->get();
  $configid = DB::table('configs')->where('id', $configid)->value('id');
  $configname = DB::table('configs')->where('id', $configid)->value('configname');
  $configpath = DB::table('configs')->where('id', $configid)->value('configpath');
  $configprojid = DB::table('configs')->where('id', $configid)->value('gitlab_projid');
  $configrepo = DB::table('configs')->where('id', $configid)->value('repository');
  $configkeygen = DB::table('configs')->where('id', $configid)->value('keygen');
  ?>

  <div class="navbar-fixed">
    <ul id="dropdown1" class="dropdown-content">
      <!-- <li><a href="#!">Account Settings</a></li> -->
      <!-- <admin area -->
      <!-- @if (session('user_id')==1)
      <li><a href="#!" onclick="createUser()">User Creation</a></li>
      @endif -->
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
        <a class="waves-effect waves-light btn-large" style="width:200px" href="{{url('detailrepo/'.$configid)}}"  onclick="return loading();"><i class="material-icons left">arrow_back</i>Back</a>
      </div>
    </div>
  </div>
  <div id="openmodal" style="display:none">
    @if($errors->any())
    {{$errors->first()}}
    @endif
  </div>
  <div class="row" align="center">
    <h5>Edit file: {{$configname}}<br><b>({{$configpath}})</b></h5>
  </div>
  <div class="row">
    <div class="col s2">
    </div>
    <div class="col s8">
      <div id="editor">@php
        //impersonal token of gitlab user.

        $user_id = session('user_id');
        $imp_token = DB::table('users')->where('id', $user_id)->value('token');


        $conf =substr($configpath, strrpos($configpath, '/') + 1);

        $out = str_replace('.','%2E',$conf);

        SSH::into('gitlab')->run(array(

        "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' 'https://52.221.75.98//api/v4/projects/$configprojid/repository/files/$out/raw?ref=master'",

        ), function($line){
          echo $line;

        });
        @endphp</div>
      </div>
      <div class="col s2">
      </div>
    </div><br>
    <div class="row">
      <div class="col s1">
      </div>
      <div class="col s10">
        <form action="{{url('savecommit')}}" id="commitform" class="col s12" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" id="configid" name="configid" value="{{$configid}}">
          <input type="hidden" id="edittext" name="edittext" value="">
          <div class="row">
            <div class="input-field col s2"></div>
            <div class="input-field input-field2 col s8">
              <i class="material-icons prefix">comment</i>
              <input id="icon_prefix" type="text" class="validate" name="commitmsg" pattern="^[a-zA-Z0-9-@\s]{1,50}$">
              <label for="icon_prefix">Commit message</label>
            </div>
          </div>
        </form>
      </div>
      <div class="s1">
      </div>
    </div>
    <div class="row">
      <div class="col s2">
      </div>
      <div class="col s8">
        <div class="row" align="right">
          <a class="waves-effect waves-light btn-large" onclick="saveCommit()"><i class="material-icons left">save</i>Commit changes</a>
        </div>
      </div>
    </div>

    <div id="errormsg" class="row" align="center" style="display:none">
      <i class="material-icons prefix" style="color:#b71c1c">info_outline</i><span style="color:#b71c1c"> Invalid input, please check your informations.</span>
    </div>




    <div class="row">
    </div>

    <div class="" id="testnaja">

    </div>

    <div id="server" class="" style="display:none">
      {{$obj->id}}
    </div>
    <div class="container" align="left">

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

    <!--Import jQuery before materialize.js-->
    <script src="https://cdn.jsdelivr.net/npm/jdenticon@1.7.2" async></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
    <script src="../ace-builds/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    //dialogs
    function saveCommit(){
      // alert("Hello"+id);
      swal({
        imageUrl: '../img/load.gif',
        imageWidth: 120,
        showCancelButton: false,
        showConfirmButton: false,
        animation: false,
        allowOutsideClick: false,
        confirmButtonColor: '#26a69a',
      });
      document.getElementById('edittext').value = editor.getValue();
      $("#commitform").submit();

    }

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


    //Using Ace Editor
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/github");
    editor.getSession().setMode("ace/mode/text");
    editor.setAutoScrollEditorIntoView(true);
    editor.setOption("maxLines", 30);
    editor.setOption("minLines", 30);
    // editor.commands.addCommand({
    //   name: 'myCommand',
    //   bindKey: {win: 'Ctrl-M',  mac: 'Command-M'},
    //   exec: function(editor) {
    //     alert(editor.getValue());
    //   },
    //   readOnly: true // false if this command should not apply in readOnly mode
    // });
    document.getElementById('editor').style.fontSize='12px';


    </script>
  </body>

  </html>
