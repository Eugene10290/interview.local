<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['id', 'user_id', 'title', 'slug', 'description', 'product_image', 'price' ];
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    /**
     * Продукт пренадлежить пользователю
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

}
