<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  public $timestamps  = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'text', 'user_id', 'report_state', 'report_type', 'reported_user_id'
  ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'report_id');
    }
}
