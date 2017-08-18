<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Description;
use Redirect;

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

    public function updateDescription(Request $request)
    {
      //
    }

    public function removeDescription($id)
    {
      //
    }

    public function listAllDescriptions($id)
    {
      //
    }
}
