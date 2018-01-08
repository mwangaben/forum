<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favourable, RecordActivity;

    protected $fillable = ['body', 'user_id'];

    protected $with = ['owner', 'favorites', 'thread'];
    protected $appends = ['favoritesCount', 'isFavorited'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($reply) {
            $reply->favorites->each->delete();
        });

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    /**
     * get the owner of the reply
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo

     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * grab the thread associated with a reply
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo

     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
