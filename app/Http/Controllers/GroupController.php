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
    $user_id = $request->input('user_id');
    $groupname = $request->input('groupname');
    $selecthost = $request->input('selecthost');

    $obj = new Group();
    $obj->groupname = $groupname;
    $obj->user_id = $user_id;
    $obj->save();

    $latest_group = DB::table('groups')->orderBy('id', 'desc')->first();

    foreach ($selecthost as $key => $host) {

      DB::table('controls')
      ->where('user_id', $user_id)
      ->where('host_id', $host)
      ->update(['group_id' => $latest_group->id]);

    }

    $request->session()->flash('status', 'true');
    $request->session()->flash('title', 'Successful!');
    $request->session()->flash('text', 'The host group was created.');
    $request->session()->flash('icon', 'success');


    return redirect('showhost');
  }
}
