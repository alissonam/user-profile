<?php

namespace Calls;

/**
 * Class CallRepository
 * @package Calls
 */
class CallRepository
{
    /**
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Support\HigherOrderWhenProxy|\Illuminate\Support\Traits\Conditionable|mixed
     */
    public static function index(array $filters = [])
    {
        return Call::query()->when($filters['title'] ?? null, function ($query, $title) {
            return $query->where('title', 'like', "%$title%");
        });
    }
}
