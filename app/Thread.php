<?php

namespace App;

use App\Channel;
use App\Reply;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordActivity;
    
    protected $fillable = ['body', 'title', 'user_id', 'channel_id'];
    protected $with     = ['creator', 'channel'];

    protected static function boot()
    {

        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies()->delete();
        });
        

    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
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

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function deleteThread($thread)
    {
        return $this->where('thread_id', $thread->id)->delete();
    }
}
