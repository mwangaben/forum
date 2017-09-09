<?php 
namespace App;


class Person
{
    public function tell(User $user)
    {
        return $user->first()->id;
    }
}
