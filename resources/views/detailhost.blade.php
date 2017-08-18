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
  <br><br>
  <div id="openmodal" style="display:none">
    @if($errors->any())
    {{$errors->first()}}
    @endif
  </div>
  <div class="row">

    <div class="col s12" align="center"></div>

    <div class="col s8">

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
                  <span class="card-title" >Installed memory (RAM)</span>
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
                  <div class="col s9">
                    <span class="card-title">Repository of Configuration</span>
                  </div>
                  <div class="col s3" align="right">
                    <a class="modal-trigger waves-effect waves-light btn-large teal" href="#modal1"><i class="material-icons left">add</i>Add Config</a>
                  </div>
                </div>
              </div>
              <?php
              use Illuminate\Support\Facades\DB as DB;
              $configs = DB::table('configs')->where('host_id', $obj->id )->get();
              ?>
              <div class="card-action blue-grey lighten-5 blue-grey darken-text" >
                <table>
                  <thead>
                    <tr>
                      <th style="width:4%">No.</th>
                      <th style="width:31%">Configuration Name</th>
                      <th style="width:35%">Path</th>
                      <th style="width:30%">Action</th>
                    </tr>
                  </thead>
                  @foreach($configs as $indexKey=>$config)
                  <tbody align="right">
                    <tr>
                      <td>{{$indexKey+1}}</td>
                      <td>{{$config->configname}}</td>
                      <td>{{$config->configpath}}</td>
                      <td><a class="waves-effect waves-light btn">View</a> <a class="waves-effect waves-light btn">Edit</a> <a class="waves-effect waves-light btn">Delete</a></td>
                    </tr>
                  </tbody>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="row">
          <div class="col s12"><span style="font-size: 250%; color:#607d8b">About Host</span><hr style="color: #607d8b">
            <a class="modal-trigger" href="#modal2" style="color:#009688"><i class="material-icons left">add</i>add host description</a><br><br>
            <!-- <div class="card-panel teal"> -->

            <?php
            $descs = DB::table('descriptions')->where('host_id', $obj->id )->get();
            ?>


            <ul class="collapsible popout" data-collapsible="expandable">

              @foreach($descs as $indexKey=>$desc)

              <li>
                <div class="collapsible-header"><i class="material-icons">dvr</i>{{$desc->descname}}<a class="modal-trigger" href="#delete{{$desc->id}}"><i class="material-icons right" style="color:#009688">delete</i></a><a class="modal-trigger" href="#edit{{$desc->id}}"><i class="material-icons right" style="color:#009688">edit</i></a></div>
                <div class="collapsible-body"><span class="break-word"><?php echo nl2br($desc->descdetail);?></span></div>
                <a href="#modal4" class="modal-trigger" id="clickmodal4" hidden=""></a>
              </li>

              <div id="edit{{$desc->id}}" class="modal modal-fixed-footer">
                <div class="modal-content">
                  <br>
                  <!-- <h5>Add Host Description</h5> -->
                  <!-- <p>You should add host by using rsa key for secure</p> -->
                  <!-- <hr class="style-four"><br> -->
                  <div class="row">
                    <div class="col s1"></div>
                    <div class="col s10">
                      <br>
                      <div id="byrsakey" class="row" style="display:block;">
                        <form action="{{url('editdesc')}}" id="editdescform{{$desc->id}}" class="col s12" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="serverid" value="" id="serverid">
                          <input type="hidden" name="descid" value="{{$desc->id}}" id="descid">
                          <div class="row">
                            <div class="input-field col s2"></div>
                            <div class="input-field  col s8">
                              <i class="material-icons prefix">description</i>
                              <input id="icon_prefix" type="text" class="validate" name="descname" value="{{$desc->descname}}" pattern="^[a-zA-Z0-9-@]{1,32}$" title="Config's name should be 1 to 32 characters, required.">
                              <label for="icon_prefix">Description Name</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s2"></div>
                            <div class="input-field col s8">
                              <i class="material-icons prefix">mode_edit</i>
                              <textarea name="descdetail" id="icon_prefix2" class="materialize-textarea">{{$desc->descdetail}}</textarea>
                              <label for="icon_prefix2">Description Detail</label>
                            </div>
                          </div>
                          <div class="row" align="center">
                            <button class="modal-trigger waves-effect waves-light btn-large teal" type="button" onClick="editDesc({{$desc->id}})" name="button"><i class="material-icons  left">done</i>Save Changes</button>
                            <button class="modal-action modal-close waves-effect waves-light btn-large teal lighten-2" type="button" name="button" data-dismiss="modal" ><i class="material-icons  left">close</i>Cancle</button>
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

                          <div class="row">
                            <div class="input-field col s2"></div>
                            <div class="input-field  col s8" align="center">
                              <span><p style="font-size:25px"> <i class="material-icons">error_outline</i> Do you want to delete this description?</p></span>
                            </div><
                          </div><br>
                          <div class="row" align="center">
                            <button class="modal-trigger waves-effect waves-light btn-large teal" type="button" onclick="location.href='{{ url('deldesc/'.$desc->id) }}'" name="button"><i class="material-icons  left">done</i>Ok</button>
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
<div class="container" align="left">
  <!-- Page Content goes here -->


  <!-- Modal Structure -->

  <!-- add config path -->
  <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
      <br>
      <!-- <h5>Add Host</h5> -->
      <!-- <p>You should add host by using rsa key for secure</p> -->
      <!-- <hr class="style-four"><br> -->
      <div class="row">
        <div class="col s1"></div>
        <div class="col s10">
          <br>
          <div id="byrsakey" class="row" style="display:block;">
            <form action="{{url('checkpath')}}" id="hostform" class="col s12" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="serverid" value="" id="serverid">
              <div class="row">
                <div class="input-field col s2"></div>
                <div class="input-field  col s8">
                  <i class="material-icons prefix">description</i>
                  <input id="icon_prefix" type="text" class="validate" name="pathname" pattern="^[a-zA-Z0-9-@]{1,32}$" title="Config's name should be 1 to 32 characters, required.">
                  <label for="icon_prefix">Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s2"></div>
                <div class="input-field col s8">
                  <i class="material-icons prefix">label</i>
                  <input id="icon_prefix" type="text" class="validate" name="pathconf" title="This field is required.">
                  <label for="icon_prefix">Path</label>
                </div>
              </div>
              <div class="row">
                <div class="row" align="center">
                  <button class="modal-trigger waves-effect waves-light btn-large teal" type="button" onClick="chkconfigname()" name="button"><i class="material-icons  left">done</i>Save Path</button>
                </div>
              </div>
              <div id="errormsg1" class="row" align="center" style="display:none">
                <i class="material-icons prefix" style="color:#b71c1c">info_outline</i><span style="color:#b71c1c"> Invalid input, please check your informations.</span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- add description -->
  <div id="modal2" class="modal modal-fixed-footer">
    <div class="modal-content">
      <br>
      <!-- <h5>Add Host Description</h5> -->
      <!-- <p>You should add host by using rsa key for secure</p> -->
      <!-- <hr class="style-four"><br> -->
      <div class="row">
        <div class="col s1"></div>
        <div class="col s10">
          <br>
          <div id="byrsakey" class="row" style="display:block;">
            <form action="{{url('adddesc')}}" id="descform" class="col s12" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="serverid" value="" id="serverid">
              <div class="row">
                <div class="input-field col s2"></div>
                <div class="input-field  col s8">
                  <i class="material-icons prefix">description</i>
                  <input id="icon_prefix" type="text" class="validate" name="descname" pattern="^[a-zA-Z0-9-@]{1,32}$" title="Config's name should be 1 to 32 characters, required.">
                  <label for="icon_prefix">Description Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s2"></div>
                <div class="input-field col s8">
                  <i class="material-icons prefix">line_weight</i>
                  <textarea name="descdetail" id="icon_prefix2" class="materialize-textarea"></textarea>
                  <label for="icon_prefix2">Description Detail</label>
                </div>
              </div>
              <div class="row" align="center">
                <button class="modal-trigger waves-effect waves-light btn-large teal" type="button" onClick="addDesc()" name="button"><i class="material-icons  left">done</i>Save Description</button>
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

function chkconfigname(){


  $idform=document.getElementById('hostform');
  $formpathname = $idform.elements.namedItem("pathname").value;

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
  if(($addpathcomeback.indexOf("0") >= 0)||($addpathcomeback.indexOf("1") >= 0)){
    if(($addpathcomeback.indexOf("1") >= 0)){
      $msg = "<span>The configuration file was saved to the system.</span>"
      Materialize.toast($msg, 5000,'teal accent-3 rounded');
    }else if(($addpathcomeback.indexOf("0") >= 0)){
      $msg = "<span>Sorry, the configuration file not found.</span>"
      Materialize.toast($msg, 5000,'pink accent-1 rounded');
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


  // if($addpathcomeback=="0" || $addpathcomeback=="1"){
  // alert($addpathcomeback);
  //
  // }
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
