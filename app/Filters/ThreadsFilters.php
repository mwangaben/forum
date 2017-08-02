<?php

namespace App\Filters;

use App\User;

class ThreadsFilters extends Filters
{

    protected $filters = ['by', 'popular'];

    /**
     * @param $username
     * @return mixed
     * @internal param $builder
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);

    }
    /*
     * Filter the query according to the most popularity  threads
     *
     * @return $this
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }

}
