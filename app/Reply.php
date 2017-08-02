<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favourable;
    protected $fillable = ['body', 'user_id'];

    protected $with = ['owner', 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    }
