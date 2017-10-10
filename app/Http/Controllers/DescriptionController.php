<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Description;
use App\Host;
use Redirect;
use DB;

class DescriptionController extends Controller
{
  //
  public function addDescription(Request $request)
  {
    //
    $controlid = $request->input('controlid');
    $control = DB::table('controls')->where('id', $controlid)->first();
    $serverid = $control->host_id;

    $descname = $request->input('descname');
    $descdetail = $request->input('descdetail');

    $obj = new Description();
    $obj->descname = $descname;
    $obj->descdetail = $descdetail;
    $obj->host_id = $serverid;
    $obj->save();

    $serverobj = Host::find($serverid);
    $GLOBALS['test'] = 2 ;

    $request->session()->flash('status', 'true');
    $request->session()->flash('title', 'Successful!');
    $request->session()->flash('text', 'The host description was added.');
    $request->session()->flash('icon', 'success');

    return Redirect::back()->with('obj',$serverobj)->withErrors($GLOBALS['test']);
  }

  public function editDescription(Request $request)
  {

    $controlid = $request->input('controlid');
    $control = DB::table('controls')->where('id', $controlid)->first();
    $serverid = $control->host_id;

    $descid = $request->input('descid');
    $descname = $request->input('descname');
    $descdetail = $request->input('descdetail');

    DB::table('descriptions')->where('id', $descid)->update(['descname' => $descname , 'descdetail' => $descdetail]);
    // return $descid.' '.$descname.' '.$descdetail ;

    $serverobj = Host::find($serverid);
    $GLOBALS['test'] = 3 ;

    $request->session()->flash('status', 'true');
    $request->session()->flash('title', 'Successful!');
    $request->session()->flash('text', 'The host description was edited.');
    $request->session()->flash('icon', 'success');

    return Redirect::back()->with('obj',$serverobj)->withErrors($GLOBALS['test']);
  }

  public function deleteDescription(Request $request)
  {
    //
    $serverid = $request->input('serverid');
    $descid = $request->input('descid');

    DB::table('descriptions')->where('id', $descid)->delete();

    $serverobj = Host::find($serverid);
    $GLOBALS['test'] = 4 ;

    $request->session()->flash('status', 'true');
    $request->session()->flash('title', 'Successful!');
    $request->session()->flash('text', 'The host description was deleted.');
    $request->session()->flash('icon', 'success');

    return Redirect::back()->with('obj',$serverobj)->withErrors($GLOBALS['test']);
  }

  public function listAllDescriptions($id)
  {
    //
  }
}
