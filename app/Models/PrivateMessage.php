<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
  public $timestamps  = true;

  protected $table = 'private_message';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'message', 'emmiter_id', 'receiver_id', 'read'
  ];

  public function notifications()
  {
    return $this->hasMany(Notification::class, 'private_message');
  }
}