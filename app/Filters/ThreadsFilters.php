<?php 

namespace App\Filters;

use App\User;


class ThreadsFilters extends Filters {
     
     protected $filters = ['by'];

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

}