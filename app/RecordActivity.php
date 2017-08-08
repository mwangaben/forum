<?php

namespace App;


trait RecordActivity
{


    protected static function bootRecordActivity(){

       if (auth()->guest()) return ; 
    

        foreach (static::getActivitiesToRecord() as $event) {
            
            static::$event(function ($thread) {
                $thread->recordActivity('created');
            });
        }

    }
    protected static function getActivitiesToRecord(){
        return ['created'];     
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getactivityType($event),
            ]);
    }

    public function activity()
    {
          return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event)
    {
        return strtolower((new \ReflectionClass($this))->getShortName()) . '_' . $event;
    }
}