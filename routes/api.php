<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhonebookUserController;
use App\Http\Controllers\UserContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('user')->group(function () {
    //Api Route to create a phonebook user
    Route::post('/', [PhonebookUserController::class, 'create']);

    //Api Route to edit a phonebook user {pb_user_id} is ID of phone book user need to be edited
    Route::put('/{pb_user_id}', [PhonebookUserController::class, 'edit']);

    //Api Route to delete a phonebook user
    Route::delete('/{pb_user_id}', [PhonebookUserController::class, 'delete']);

    //Api Route to list all phonebook users
    Route::get('/', [PhonebookUserController::class, 'list']);

});



Route::prefix('contacts')->group(function () {
  //Api Route to add a contact detail for a phonebook user
  Route::post('/{pb_user_id}', [UserContactController::class, 'create']);

  //Api Route to edit a contact detail for a phonebook user
  Route::put('/{contact_id}', [UserContactController::class, 'edit']);
});
