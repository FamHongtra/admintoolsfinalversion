<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSH;
use App\Host;
use App\Control;
use Redirect;
use Hash;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class SearchController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function autocomplete(){
    $user_id = session('user_id') ;

    $term = Input::get('term');

    $results = array();

    // $first = DB::table('hosts')
    // ->join('controls', 'hosts.id', '=', 'controls.host_id')
    // ->where('controls.user_id', $user_id)
    // ->where('controls.control_type', "server")
    // ->where('hosts.host','like', '%'.$term.'%')
    // ->get();

    $queries = DB::table('hosts')
    ->join('controls', 'hosts.id', '=', 'controls.host_id')
    ->where('controls.user_id', $user_id)
    ->where('controls.control_type', "server")
    ->where('hosts.servername','like','%'.$term.'%')
    ->get();
    // ->take(5)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'value' => $query->servername ];
      $results[] = [ 'value' => $query->host ];
    }
    return Response::json($results);
  }


  public function autocompleteGroup(){
    $user_id = session('user_id') ;

    $term = Input::get('term');

    $results = array();


    $queries = DB::table('groups')
    ->where('user_id', $user_id)
    ->where('group_type', "server")
    ->where('groupname','like','%'.$term.'%')
    ->get();
    // ->take(5)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'value' => $query->groupname ];
    }
    return Response::json($results);
  }

  public function autocomplete2(){
    $user_id = session('user_id') ;

    $term = Input::get('term');

    $results = array();

    // $first = DB::table('hosts')
    // ->join('controls', 'hosts.id', '=', 'controls.host_id')
    // ->where('controls.user_id', $user_id)
    // ->where('controls.control_type', "network-device")
    // ->where('hosts.host','like', '%'.$term.'%')
    // ->get();

    $queries = DB::table('hosts')
    ->join('controls', 'hosts.id', '=', 'controls.host_id')
    ->where('controls.user_id', $user_id)
    ->where('controls.control_type', "network-device")
    ->where('hosts.servername','like','%'.$term.'%')
    ->get();
    // ->take(5)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'value' => $query->servername ];
      $results[] = [ 'value' => $query->host ];
    }
    return Response::json($results);
  }

  public function autocompleteGroup2(){
    $user_id = session('user_id') ;

    $term = Input::get('term');

    $results = array();


    $queries = DB::table('groups')
    ->where('user_id', $user_id)
    ->where('group_type', "network-device")
    ->where('groupname','like','%'.$term.'%')
    ->get();
    // ->take(5)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'value' => $query->groupname ];
    }
    return Response::json($results);
  }


}
