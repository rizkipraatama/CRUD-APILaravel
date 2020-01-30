<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

	protected $table = 'books';
    protected $fillable = [
        'id','bookcode', 'title', 'year','writer','stock',
    ];

public function borrow()
    {
        return $this->hasMany('App\Borrow');
    }
}
