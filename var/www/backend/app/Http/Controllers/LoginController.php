<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{

  public function register(Request $req)
  {
    $create_id = uniqid();
    $user = new User();
    $user->user_id = $create_id;
    $user->name = $req->name;
    $user->mail = $req->mail;
    $user->pass = $req->pass;
    $user->permit = false;
    $user->save();
  }

  public function test()
  {
    return 'test';
  }
}
