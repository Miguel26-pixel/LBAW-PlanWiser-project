<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAssign extends Model
{
  public $timestamps  = false;

  protected $table = 'user_assign';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
       'user_id', 'task_id'
  ];
}