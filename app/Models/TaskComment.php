<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'taskcomments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'task_id', 'user_id'
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }

}
