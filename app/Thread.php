<?php

namespace App;

use App\Reply;
use App\Channel;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    
   protected $fillable = ['body', 'title', 'user_id', 'channel_id'];

    public function path()
    {
    	  return  "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
    	  return $this->hasMany(Reply::class);
    }

    public function channel()
    {
          return $this->belongsTo(Channel::class);
    }

    public function creator()
    {
    	  return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
          return $this->replies()->create($reply);
    }
}
