<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordActivity;

    protected $guarded = ['id'];


    public function favorited()
    {
        return $this->morphTo();
    }
}
