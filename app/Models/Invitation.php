<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
  use HasCompositePrimaryKey;
  public $timestamps  = false;

  protected $table = 'invitations';

  protected $primaryKey = ['user_id', 'project_id'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
       'user_id', 'project_id', 'accept', 'user_role'
  ];
}