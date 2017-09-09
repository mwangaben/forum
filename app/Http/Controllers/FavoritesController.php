<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Reply $reply)
    {
        $reply->favorite();
        if (request()->expectsJson()) {
        	return response(['status' => 'Favorited']);
        }

        // return back()->with('flash', 'You have favorited the reply');
    }

    public function destroy(Reply $reply)
    {
       $reply->unFavorite();
       if(request()->expectsJson()){
       	   return response(['status' => 'Un Favorited']);
       }

    	  // return back();
    }
}
