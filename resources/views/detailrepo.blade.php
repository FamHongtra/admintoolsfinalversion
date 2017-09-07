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

  <!-- Compiled and minified JavaScript -->

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

  </style>
</head>

<body onload="checkStatus()">

  <nav>
    <div class="nav-wrapper teal lighten-1">
      <a href="{{url('showhost')}}" class="brand-logo">Logo</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="sass.html">Sass</a></li>
        <li><a href="badges.html">Components</a></li>
        <li><a href="collapsible.html">JavaScript</a></li>
      </ul>
    </div>
  </nav>
  <div class="row">

  </div>
  <div class="row">
    <div class="col s7">
      <div class="col s4" align="left">
        <a class="waves-effect waves-light btn-large" style="width:200px" href="{{url('detailhost/'.$controlid)}}"><i class="material-icons left">arrow_back</i>Back</a>
      </div>
    </div>
  </div>
  <div id="openmodal" style="display:none">
    @if($errors->any())
    {{$errors->first()}}
    @endif
  </div>
  <div class="row">
    <div class="col s7">
      <div class="col s4" align="center">
        <div class="card cyan darken-3" style="width:250px">
          <h5 style="padding:10px;color:white">{{$obj->servername}}<a href=""><i class="material-icons right" style="color:white">settings</i></a></h5>
        </div>
        <div class="card" style="width:250px;">
          <div class="card-image" style="padding:20px">
            <img src="../img/server.png">
            <span class="card-title" style="color:#263238"><b>{{$obj->host}}</b></span>
          </div>
          <div class="card-action white">
            <a class="modal-trigger waves-effect waves-light btn-large cyan darken-3" onclick="window.location.reload()"><i class="material-icons left">swap_vert</i>Connection</a>
          </div>
        </div>
      </div>

      <div class="col s8">
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
              $configid = DB::table('configs')->where('id', $configid)->value('id');
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
                      <th style="width:31%">Configuration Name</th>
                      <th style="width:35%">Path</th>
                      <th style="width:30%">Actions</th>
                    </tr>
                  </thead>
                  @foreach($configs as $indexKey=>$config)
                  <tbody align="right">
                    <tr>
                      <td>{{$indexKey+1}}</td>
                      <td>{{$config->configname}}</td>
                      <td>{{$config->configpath}}</td>
                      <td><a class="waves-effect waves-light btn" href="{{url('detailrepo/'.$config->id)}}">Show Versions</a></td>
                    </tr>
                  </tbody>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col s5">
      <div class="row">
        <div class="col s12"><span style="font-size: 250%; color:#607d8b">Versions of Configuration</span><hr style="color: #607d8b"><br>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12" align="center"><br>
                  <span class="card-title">Configurations Name: {{$configname}}<br>({{$configpath}})</span>
                </div>
              </div>
            </div>
            <div class="card-action" >
              <table>
                <thead>
                  <tr>
                    <th style="width:4%">No.</th>
                    <th style="width:60%">Version Title</th>
                    <th style="width:5%"></th>
                    <th style="width:15%">Version ID</th>
                    <th style="width:26%">Actions</th>
                  </tr>
                </thead>

                @foreach($configversions as $indexKey=>$version)

                <tbody align="right">
                  <tr id="item{{$indexKey+1}}">
                    <td>{{$indexKey+1}}</td>
                    <td id="itemtitle{{$indexKey+1}}">{{$version->title}}</td>
                    <td></td>
                    <td>{{$version->short_id}}</td>
                    <td><a class="modal-trigger waves-effect waves-light btn" href="#modal{{$indexKey+1}}">View</a></td>
                  </tr>
                </tbody>


                <div id="modal{{$indexKey+1}}" class="modal modal-fixed-footer">
                  <div class="modal-header">
                    <h5>{{$version->title}}</h5>
                  </div>

                  <div class="modal-content">
                    @php
                    $imp_token = "eWQofD635bPE5auXVNAE";
                    $proj_id = $configprojid ;


                    $conf =substr($configpath, strrpos($configpath, '/') + 1);

                    $out = str_replace('.','%2E',$conf);

                    SSH::into('gitlab')->run(array(

                    "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' 'http://13.228.10.174/api/v4/projects/$proj_id/repository/files/$out/raw?ref=$version->id'",

                    ), function($line){
                      echo nl2br($line);

                    });
                    @endphp
                    <br><br><br><br>
                  </div>
                  <div class="modal-footer">
                    <a onClick="revisionSubmit({{$indexKey+1}})" class="modal-action modal-close waves-effect waves-green btn teal" style="margin-right:10px"><i class="material-icons left">rotate_left</i>Revision</a><a href="#!" class="modal-action modal-close waves-effect waves-green btn teal lighten-2" style="margin-right:10px">Close</a>
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
              </table>
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
      SSH::into('ansible')->run(array(
        "ansible -m ping $obj->servername",
      ), function($line){
        // if (strpos($line, 'pong') !== false) {
        //   echo "<span>connected</span>" ;
        // }
        echo $line;
      });
      ?>
    </div>
  </div>
  <script src="js/progressbar.js"></script>

  <!--Import jQuery before materialize.js-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
  <script type="text/javascript">
  //dialogs



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
    // alert("Hello"+id);


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

  function checkStatus(){


    $addpathcomeback = document.getElementById('openmodal').textContent ;
    // check path && description message toast

    if(($addpathcomeback.indexOf("0") >= 0)||($addpathcomeback.indexOf("1") >= 0)||($addpathcomeback.indexOf("2") >= 0)||($addpathcomeback.indexOf("3") >= 0)||($addpathcomeback.indexOf("4") >= 0)||($addpathcomeback.indexOf("5") >= 0)){
      if(($addpathcomeback.indexOf("0") >= 0)){
        $msg = "<span>Sorry, the configuration file not found.</span>"
        Materialize.toast($msg, 5000,'pink accent-1 rounded');
      }else if(($addpathcomeback.indexOf("1") >= 0)){
        $msg = "<span>The configuration file was saved to the system.</span>"
        Materialize.toast($msg, 5000,'teal accent-3 rounded');
      }else if(($addpathcomeback.indexOf("2") >= 0)){
        $msg = "<span>The host description was added.</span>"
        Materialize.toast($msg, 5000,'teal accent-3 rounded');
      }else if(($addpathcomeback.indexOf("3") >= 0)){
        $msg = "<span>The host description was edited.</span>"
        Materialize.toast($msg, 5000,'teal accent-3 rounded');
      }else if(($addpathcomeback.indexOf("4") >= 0)){
        $msg = "<span>The host description was deleted.</span>"
        Materialize.toast($msg, 5000,'teal accent-3 rounded');
      }else if(($addpathcomeback.indexOf("5") >= 0)){

      }
    }else{
      $status= document.getElementById('status').textContent;
      if(($status.indexOf("SUCCESS") >= 0)){
        $msg = "<span>connected</span>"
        Materialize.toast($msg, 5000,'teal accent-3 rounded');
      }else{
        $msg= "<span>disconnect</span>";
        Materialize.toast($msg, 5000,'pink accent-1 rounded');
      }
    }

    document.getElementById('itemtitle1').innerHTML = document.getElementById('itemtitle1').textContent+"<br>(Current Version)";

    $server = document.getElementById('server').textContent ;
    document.getElementById('serverid').value = $server;
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
