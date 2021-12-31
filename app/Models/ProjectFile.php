<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
  public $timestamps  = true;

  protected $table = 'projectfiles';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'url', 'project_id', 'name'
  ];
}
