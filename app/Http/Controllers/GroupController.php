<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSH;
use App\Group;
use Redirect;
use Hash;
use DB;

class GroupController extends Controller
{
  //
  public function createGroup(Request $request)
  {
    //
    $user_id = session('user_id');
    $groupname = $request->input('groupname');
    $bywhat = $request->input('bywhat');
    //select by controlid
    $selecthost = $request->input('selecthost');


    $obj = new Group();
    $obj->groupname = $groupname;
    $obj->group_type = $bywhat;
    $obj->user_id = $user_id;
    $obj->save();

    $latest_group = DB::table('groups')->orderBy('id', 'desc')->first();

    foreach ($selecthost as $key => $host) {

      DB::table('controls')
      ->where('user_id', $user_id)
      ->where('id', $host)
      ->update(['group_id' => $latest_group->id]);

    }

    $request->session()->flash('status', 'true');
    $request->session()->flash('title', 'Successful!');
    $request->session()->flash('icon', 'success');

    if($bywhat == "server"){
      $request->session()->flash('text', 'The server group was created.');
      return redirect('showhost');
    }else if($bywhat == "network-device"){
      $request->session()->flash('text', 'The network-device group was created.');
      return redirect('shownwdev');
    }

  }



  public function groupAddmore(Request $request)
  {
    //
    $user_id = session('user_id');
    $group_id = $request->input('group_id');
    $groupname = $request->input('groupname');
    $selecthost = $request->input('selecthost');


    foreach ($selecthost as $key => $host) {

      DB::table('controls')
      ->where('user_id', $user_id)
      ->where('id', $host)
      ->update(['group_id' => $group_id]);

    }

    $group_type = DB::table('groups')
    ->where('id', $group_id)
    ->value('group_type');

    $request->session()->flash('status', 'true');
    $request->session()->flash('title', 'Successful!');
    $request->session()->flash('icon', 'success');

    if($group_type == "server"){
      $request->session()->flash('text', 'The server group was updated.');
      return redirect('showhost');
    }else if($group_type == "network-device"){
      $request->session()->flash('text', 'The network-device group was updated.');
      return redirect('shownwdev');
    }

  }


  public function leftGroup(Request $request)
  {
    //
    $user_id = session('user_id');
    $control_id = $request->input('control_id');

    $control_type = DB::table('controls')
    ->where('id', $control_id)
    ->value('control_type');


    DB::table('controls')
    ->where('id', $control_id)
    ->update(['group_id' => 0 ]);


    $request->session()->flash('status', 'true');
    $request->session()->flash('title', 'Successful!');
    $request->session()->flash('icon', 'success');

    if($control_type == "server"){
      $request->session()->flash('text', 'The server group was updated.');
      return redirect('showhost');
    }else if($control_type == "network-device"){
      $request->session()->flash('text', 'The network-device group was updated.');
      return redirect('shownwdev');
    }

  }

  public function delGroup(Request $request)
  {
    //
    $user_id = session('user_id');
    $group_id = $request->input('group_id');

    $groupmembers = DB::table('controls')
    ->where('user_id', $user_id)
    ->where('group_id', $group_id)
    ->get();

    foreach ($groupmembers as $key => $groupmember) {
      DB::table('controls')
      ->where('user_id', $user_id)
      ->where('host_id', $groupmember->host_id)
      ->update(['group_id' => 0]);
    }

    $group_type = DB::table('groups')
    ->where('id', $group_id)
    ->value('group_type');

    DB::table('groups')
    ->where('id', $group_id)
    ->delete();


    $request->session()->flash('status', 'true');
    $request->session()->flash('title', 'Successful!');
    $request->session()->flash('icon', 'success');

    if($group_type == "server"){
      $request->session()->flash('text', 'The server group was deleted.');
      return redirect('showhost');
    }else if($group_type == "network-device"){
      $request->session()->flash('text', 'The network-device group was deleted.');
      return redirect('shownwdev');
    }
  }

}
