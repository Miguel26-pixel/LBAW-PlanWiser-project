<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteProject extends Model
{
  public $timestamps  = false;

  protected $table = 'favorite_project';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
       'user_id', 'project_id'
  ];
}