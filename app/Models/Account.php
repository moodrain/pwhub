<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Account extends Model
{

    public static $searchRule = [
        'id' => '=',
        'applicationId' => '=',
        'username' => 'like',
        'note' => 'like',
    ];

    public static $sortRule = [
        'id', 'applicationId', 'username'
    ];

    protected $with = ['application'];

    protected static function booted()
    {
        static::addGlobalScope('my', function(Builder $builder) {
            uid() && $builder->where('user_id', uid());
        });

    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

}
