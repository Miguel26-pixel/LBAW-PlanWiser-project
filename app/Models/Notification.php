<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  public $timestamps  = true;

  protected $table = 'notification';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'notification_type', 'user_id', 'project_message', 'report', 'private_message', 'task', 'task_comment', 'invitation_user_id', 'invitation_project_id'
  ];
}