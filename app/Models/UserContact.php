<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserContact extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'pb_users_contacts';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'contact_id';

  /**
   * Indicates if the model's ID is auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = true;



  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = true;


  protected $hidden = ['deleted_at'];
}
