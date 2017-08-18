<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Loading</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="js/typed.custom.js" type="text/javascript"></script>
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
  <script>
  $(function(){

    $("#typed").typed({
      // strings: ["Typed.js is a JavaScript library.", "It tyops out", "It types out sentences.", "And then deletes them.", "Loading, please wait..."],
      strings: ["We are installing service to your host.", "It take around 1-2", "It takes around 1-2 minutes.", "Please do not close this page.", "Loading, please wait..."],
      typeSpeed: 50,
      callback: function(){
        shift();
      }
    });

  });
  function shift(){
    $(".head-wrap").addClass("shift-text");
    terminalHeight();
  }

  function terminalHeight(){
    var termHeight = $(".terminal-height");
    var value = termHeight.text();
    value = parseInt(value);
    setTimeout(function(){
      if (value > 10){
        value = value-1;
        this.txtValue = value.toString();
        termHeight.text(this.txtValue);
        self.terminalHeight();
        document.getElementById('loading').style.display = "block" ;
      }
      else{
        clearTimeout();
      }
    }, 10);
  }
  </script>
  <link href="css/terminal.css" rel="stylesheet" />
</head>
<body onload="passingdata()">

  <div class="header">

    <div class="head-wrap">
      <!-- <img src="img/admin.png" alt="" style="width:150px">
      <h1 class="h1">Typed.js</h1> -->
      <br><br>
      <div class="text-editor-wrap">
        <div class="title-bar"><span class="title">Admin Assistant Tools &mdash; bash &mdash; 80x<span class="terminal-height">25</span></span></div>
        <div class="text-body">
          $ <span id="typed"></span>
        </div>
      </div>
    </div>
  </div>

  <div id="loading" class="wrap" style="display:none">

    <div class="sk-circle">
      <div class="sk-circle1 sk-child"></div>
      <div class="sk-circle2 sk-child"></div>
      <div class="sk-circle3 sk-child"></div>
      <div class="sk-circle4 sk-child"></div>
      <div class="sk-circle5 sk-child"></div>
      <div class="sk-circle6 sk-child"></div>
      <div class="sk-circle7 sk-child"></div>
      <div class="sk-circle8 sk-child"></div>
      <div class="sk-circle9 sk-child"></div>
      <div class="sk-circle10 sk-child"></div>
      <div class="sk-circle11 sk-child"></div>
      <div class="sk-circle12 sk-child"></div>
    </div>
  </div>
  <form action="{{url('addhost')}}" id="myform" class="col s12" method="post" enctype="multipart/form-data" style="display:none">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input id = "bywhat" type="hidden" name="bywhat">
    <div id="bywhatdiv" style="display:none" >{{$bywhat}}</div>
    <input id="servername" type="text" class="validate" name="servername">
    <div id="servernamediv" style="display:none">{{$servername}}</div>
    <input id="host" type="text" class="validate" name="host">
    <div id="hostdiv" style="display:none">{{$host}}</div>
    <input id="port" type="number" class="validate" name="port">
    <div id="portdiv" style="display:none">{{$port}}</div>
    <input id="usrname" type="text" class="validate" name="usrname">
    <div id="usrnamediv" style="display:none">{{$usrname}}</div>
    @if($bywhat == "rsakey")
    <input id="password" type="text" class="validate" name="original_name">
    <div id="passworddiv" style="display:block">{{$original_name}}</div>
    @elseif($bywhat == "password")
    <input id="password" type="password" class="validate" name="password">
    <div id="passworddiv" style="display:block">{{$password}}</div>
    @endif
    <input type="submit" name="" value="submit">
  </form>
</body>
<script type="text/javascript">
function passingdata(){
  document.getElementById('bywhat').value = document.getElementById('bywhatdiv').innerHTML;
  document.getElementById('servername').value = document.getElementById('servernamediv').innerHTML;
  document.getElementById('host').value = document.getElementById('hostdiv').innerHTML;
  document.getElementById('port').value = document.getElementById('portdiv').innerHTML;
  document.getElementById('usrname').value = document.getElementById('usrnamediv').innerHTML;
  document.getElementById('password').value = document.getElementById('passworddiv').innerHTML;
  $("#myform").submit();
}
</script>
</html>
