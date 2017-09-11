<!DOCTYPE html>
<html lang="en">
<head>
  <title>ACE in Action</title>
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
  <style type="text/css" media="screen">
  #editor {
    border: 1px solid lightgray;
    margin: auto;
    height: 200px;
    width: 60%;
  }
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
  </style>
</head>
<body>
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
        <a class="waves-effect waves-light btn-large" style="width:200px" href="{{url('detailhost/41')}}"><i class="material-icons left">arrow_back</i>Back</a>
      </div>
    </div>
  </div>
  <div id="openmodal" style="display:none">
    @if($errors->any())
    {{$errors->first()}}
    @endif
  </div>

  <div id="editor">@php
    //impersonal token of gitlab user.


    $imp_token = "9zxm6Uvgy4m_xbP-qvH7";
    $proj_id = 2 ;
    $configpath = "/home/ubuntu/test.conf";


    $conf =substr($configpath, strrpos($configpath, '/') + 1);

    $out = str_replace('.','%2E',$conf);

    SSH::into('gitlab')->run(array(

    "sudo curl --silent --request GET --header 'PRIVATE-TOKEN: $imp_token' 'http://52.221.75.98//api/v4/projects/$proj_id/repository/files/$out/raw?ref=master'",

    ), function($line){
      echo $line;

    });
    @endphp</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
    <script src="ace-builds/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">

    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/github");
    editor.getSession().setMode("ace/mode/text");
    editor.setAutoScrollEditorIntoView(true);
    editor.setOption("maxLines", 50);
    editor.setOption("minLines", 50);
    editor.commands.addCommand({
      name: 'myCommand',
      bindKey: {win: 'Ctrl-M',  mac: 'Command-M'},
      exec: function(editor) {
        alert('Hello');
      },
      readOnly: true // false if this command should not apply in readOnly mode
    });
    </script>
  </body>
  </html>
