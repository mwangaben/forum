<?php

namespace App;

use App\User;
use App\Thread;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favourable, RecordActivity;

    protected $fillable = ['body', 'user_id'];

    protected $with = ['owner', 'favorites', 'thread'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
    	  return $this->belongsTo(Thread::class);
    }

}
