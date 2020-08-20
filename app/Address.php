<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //you can add here country_id, but its better associating
    protected $fillable = [
        'line_1',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

}
