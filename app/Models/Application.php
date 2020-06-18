<?php

namespace App\Models;

class Application extends Model
{

    public static $searchRule = [
        'id' => '=',
        'name' => 'like',
        'site' => 'like'
    ];

    public static $sortRule = [
        'id', 'name', 'site', 'createdAt'
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
