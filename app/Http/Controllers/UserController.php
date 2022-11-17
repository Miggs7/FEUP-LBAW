<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  /**
   * Gets user by his id.
   *
   * @param  int  $id_user
   * @return Response
   */
  public static function getUserById($id_user)
  {
    $user = User::find($id_user);
    return $user;
  }

    /**
   * Update user.
   *
   * @param  Request  $request
   * @return redirect
   */
  public static function updateUser(Request $request){

    $input = $request->input();
    $user = User::find($input['id']);

    if($input['name']){
      $user->name = $input['name'];
      $user->save();
    }
    
    if($input['password']){
      $user->password = bcrypt($input['password']);
      $user->save();
    }
    
    return redirect('/user/'.$user->id);
  }

}