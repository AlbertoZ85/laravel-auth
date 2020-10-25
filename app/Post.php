<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    // protected $guarded = [];
    protected $fillable = ['title', 'body', 'slug', 'img', 'updated_at', 'user_id'];

    public function user() {
        return $this->belongsTo('App\User');

    }
    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
