<?php

namespace Calls;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Call
 * @package Calls
 */
class Call extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'category',
        'description',
        'user_id',
    ];
}
