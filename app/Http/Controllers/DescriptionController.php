<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Description;
use Redirect;
use DB;

class DescriptionController extends Controller
{
    //
    public function addDescription(Request $request)
    {
      //
      $serverid = $request->input('serverid');
      $descname = $request->input('descname');
      $descdetail = $request->input('descdetail');

      $obj = new Description();
      $obj->descname = $descname;
      $obj->descdetail = $descdetail;
      $obj->host_id = $serverid;
      $obj->save();

      return Redirect::back();
    }

    public function editDescription(Request $request)
    {
      //
      $serverid = $request->input('serverid');
      $descid = $request->input('descid');
      $descname = $request->input('descname');
      $descdetail = $request->input('descdetail');

      DB::table('descriptions')->where('id', $descid)->update(['descname' => $descname , 'descdetail' => $descdetail]);
      // return $descid.' '.$descname.' '.$descdetail ;
      return Redirect::back();

    }

    public function deleteDescription($id)
    {
      //
      DB::table('descriptions')->where('id', $id)->delete();
      return Redirect::back();
    }

    public function listAllDescriptions($id)
    {
      //
    }
}
