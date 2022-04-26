<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\PhoneBookUser;
use Log;

class PhonebookUserController extends Controller
{
  /**
   * Function will be called on create user API call
   *
   * @var string
   */
  public function create(Request $request)
  {
      try {

        $validator = Validator::make($request->all(), [
          'first_name' => 'required|string|max:20',
          'last_name' => 'string|max:20|nullable',
        ]);


        if ($validator->fails()) {
          return response()->json(['status' => 'Failed','message' => $validator->errors()->all()],400);
        }

        $PhoneBookUser = new PhoneBookUser;
        $PhoneBookUser->first_name = $request->get('first_name');
        $PhoneBookUser->last_name = $request->get('last_name');

        if ($PhoneBookUser->save())
        {
          return response()->json(['status' => 'Success','message' => 'User created SuccessFully.'],201);
        }

      } catch (\Exception $e) {

        Log::debug($e);

        return response()->json(['status' => 'Failed','message' => 'Failed to create user.Please try after some time.'],500);

      }

  }

  /**
   * Function will be called on edit user API call
   *
   * @var pb_user_id is ID of phoneBook user need to be edited
   */
  public function edit(Request $request,$pb_user_id)
  {
      try {

        $validator = Validator::make($request->all(), [
          'first_name' => 'required|string|max:20',
          'last_name' => 'string|max:20|nullable',
        ]);


        if ($validator->fails()) {
          return response()->json(['status' => 'Failed','message' => $validator->errors()->all()],400);
        }

        $PhoneBookUser = PhoneBookUser::where('pb_user_id','=',$pb_user_id)->first();

        if (!$PhoneBookUser)
        {
          return response()->json(['status' => 'Failed','message' => 'No Record Found.'],404);
        }

        $PhoneBookUser->first_name = $request->get('first_name');
        $PhoneBookUser->last_name = $request->get('last_name');

        if ($PhoneBookUser->save())
        {
          return response()->json(['status' => 'Success','message' => 'User updated SuccessFully.'],200);
        }

      } catch (\Exception $e) {

        Log::debug($e);

        return response()->json(['status' => 'Failed','message' => 'Failed to update user.Please try after some time.'],500);

      }

  }


  /**
   * Function will be called on delete user API call
   *
   * @var pb_user_id is ID of phoneBook user need to be deleted
   */
  public function delete(Request $request,$pb_user_id)
  {
      try {

        $PhoneBookUser = PhoneBookUser::where('pb_user_id','=',$pb_user_id)->first();

        if (!$PhoneBookUser)
        {
          return response()->json(['status' => 'Failed','message' => 'No Record Found.'],404);
        }

        if ($PhoneBookUser->delete())
        {
          return response()->json(['status' => 'Success','message' => 'User deleted SuccessFully.'],200);
        }

      } catch (\Exception $e) {

        Log::debug($e);

        return response()->json(['status' => 'Failed','message' => 'Failed to delete user.Please try after some time.'],500);

      }

  }


}
