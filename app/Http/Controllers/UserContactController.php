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


  /**
   * Function will be called on edit user contact API call
   *
   * @var $request Request object
   * @var $contact ID of phonebook user contact for which contact details need to be edited
   */
  public function edit(Request $request,$contact_id)
  {
      try {

        $validator = Validator::make($request->all(), [
          'phone_number' => 'required|numeric|digits:10',
          'type' => 'string|in:home,office|required',
        ]);


        if ($validator->fails()) {
          return response()->json(['status' => 'Failed','message' => $validator->errors()->all()],400);
        }

        $UserContact = UserContact::where('contact_id','=',$contact_id)->first();

        if (!$UserContact)
        {
          return response()->json(['status' => 'Failed','message' => 'No Record Found.'],404);
        }

        $UserContact->mobile_number = $request->get('phone_number');
        $UserContact->type = $request->get('type');

        if ($UserContact->save())
        {
          return response()->json(['status' => 'Success','message' => 'User Contact updated SuccessFully.'],201);
        }

      } catch (\Exception $e) {

        Log::debug($e);

        return response()->json(['status' => 'Failed','message' => 'Failed to update user contact.Please try after some time.'],500);

      }

  }

  /**
   * Function will be called on delete user contact API call
   *
   * @var $request Request object
   * @var $contact ID of phonebook user contact for which contact details need to be deleted
   */
  public function delete(Request $request,$contact_id)
  {
      try {

        $UserContact = UserContact::where('contact_id','=',$contact_id)->first();

        if (!$UserContact)
        {
          return response()->json(['status' => 'Failed','message' => 'No Record Found.'],404);
        }

        if ($UserContact->delete())
        {
          return response()->json(['status' => 'Success','message' => 'User Contact deleted SuccessFully.'],201);
        }

      } catch (\Exception $e) {

        Log::debug($e);

        return response()->json(['status' => 'Failed','message' => 'Failed to delete user contact.Please try after some time.'],500);

      }

  }


  /**
   * Function will be called to list all contacts of a user
   *
   * @var $request Request object
   * @var $pb_user_id ID of phonebook user for which contact details need to be listed
   */
  public function list(Request $request,$pb_user_id)
  {
      try {

        $UserContact = UserContact::where('pb_user_id','=',$pb_user_id)->get();

        if (count($UserContact) > 0)
        {
          return response()->json(['status' => 'Success','message' => $UserContact],201);
        }

        return response()->json(['status' => 'Failed','message' => 'No Record Found.'],404);

      } catch (\Exception $e) {

        Log::debug($e);

        return response()->json(['status' => 'Failed','message' => 'Failed to delete user contact.Please try after some time.'],500);

      }

  }
}
