<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
  public $timestamps  = false;

  protected $table = 'tasks';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'description', 'due_date', 'reminder_date', 'tag', 'creator_id', 'project_id'
  ];


  public function project()
  {
    return $this->belongsTo(Project::class, 'project');
  }

  public function comments()
  {
    return $this->hasMany(TaskComment::class, 'task');
  }

  public function notifications()
  {
    return $this->hasMany(Notification::class, 'task');
  }
}
