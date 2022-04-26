<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\UserContact;
use App\Models\PhoneBookUser;
use Log;

class UserContactController extends Controller
{

  /**
   * Function will be called on create user contact API call
   *
   * @var $request Request object
   * @var $pb_user_id ID of phonebook user for which contact details need to be created 
   */
  public function create(Request $request,$pb_user_id)
  {
      try {

        $validator = Validator::make($request->all(), [
          'phone_number' => 'required|numeric|digits:10',
          'type' => 'string|in:home,office|required',
        ]);


        if ($validator->fails()) {
          return response()->json(['status' => 'Failed','message' => $validator->errors()->all()],400);
        }

        $PhoneBookUser = PhoneBookUser::where('pb_user_id','=',$pb_user_id)->first();

        if (!$PhoneBookUser)
        {
          return response()->json(['status' => 'Failed','message' => 'No Record Found.'],404);
        }

        $UserContact = new UserContact;
        $UserContact->pb_user_id = $pb_user_id;
        $UserContact->mobile_number = $request->get('phone_number');
        $UserContact->type = $request->get('type');

        if ($UserContact->save())
        {
          return response()->json(['status' => 'Success','message' => 'User Contact created SuccessFully.'],201);
        }

      } catch (\Exception $e) {

        Log::debug($e);

        return response()->json(['status' => 'Failed','message' => 'Failed to create user contact.Please try after some time.'],500);

      }

  }
}
