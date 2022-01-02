<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAssign extends Model
{
  use HasCompositePrimaryKey;
  public $timestamps  = false;

  protected $table = 'userassigns';

  protected $primaryKey = ['user_id', 'task_id'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
       'user_id', 'task_id'
  ];
}
