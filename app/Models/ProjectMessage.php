<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMessage extends Model
{
  public $timestamps  = true;

  protected $table = 'project_message';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'text', 'user_id', 'project_id'
  ];
}