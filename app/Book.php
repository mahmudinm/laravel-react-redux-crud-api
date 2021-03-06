<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['name', 'author_id', 'image', 'category'];

    public function author() {
    	return $this->belongsTo('App\Author');
    }

}
