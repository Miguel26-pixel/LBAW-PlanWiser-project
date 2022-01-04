<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{

    // Don't add create and update timestamps in database.
    public $timestamps  = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'task_id', 'user_id'
    ];


    public function notifications()
  {
    return $this->hasMany(Notification::class, 'taskcomment_id');
  }
}
