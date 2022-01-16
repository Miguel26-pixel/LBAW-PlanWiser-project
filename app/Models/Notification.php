<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  public $timestamps  = false;


  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'notification_type', 'user_id', 'project_message_id', 'report_id', 'private_message_id', 'task_id', 'task_comment_id', 'invitation_user_id', 'invitation_project_id'
  ];


  public function project()
  {
    return $this->belongsTo(Project::class, 'invitation_project_id');
  }

  public function task()
  {
    return $this->belongsTo(Task::class);
  }
}
