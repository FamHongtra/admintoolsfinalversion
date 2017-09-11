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
    $user_id = 1 ;

    $term = Input::get('term');

    $results = array();

    $queries = DB::table('hosts')
    ->join('controls', 'hosts.id', '=', 'controls.host_id')
    ->where('controls.user_id', $user_id)
    ->where('hosts.servername','like','%'.$term.'%')
    ->orWhere('hosts.host','like', '%'.$term.'%')
    ->get();
    // ->take(5)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'value' => $query->servername ];
      $results[] = [ 'value' => $query->host ];
    }
    return Response::json($results);
  }
}
