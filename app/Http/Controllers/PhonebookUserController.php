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


}
