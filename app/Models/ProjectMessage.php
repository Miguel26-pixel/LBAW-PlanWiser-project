<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMessage extends Model
{
  public $timestamps  = false;

  protected $table = 'projectmessages';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'text', 'user_id', 'project_id', 'created_at'
  ];

  public function user() {
      return $this->belongsTo(User::class);
  }

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
