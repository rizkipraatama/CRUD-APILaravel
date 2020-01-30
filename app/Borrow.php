<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $table = 'borrow';
    public $timestamps = false;
    protected $fillable = ['id','admin_id', 'user_id', 'book_id','date','returning','isApproved' ];

     public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
    public function admin()
    {
        return $this->belongsTo('App\Admin','id');
    }
    public function book()
    {
        return $this->belongsTo('App\Book','id');
    }
}
