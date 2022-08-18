<?php

namespace Calls;

use App\Http\Requests\Request;

/**
 * Class CallRequest
 * @package Calls
 */
class CallRequest extends Request
{
    /**
     * @return string[]
     */
    public function validateToIndex()
    {
        return [
            'title' => '',
        ];
    }

    /**
     * @return string[]
     */
    public function validateToStore()
    {
        return [
            'title'       => 'required|min:2',
            'category'    => '',
            'description' => '',
            'user_id'     => '',
        ];
    }

    /**
     * @return string[]
     */
    public function validateToUpdate()
    {
        return [
            'title'      => 'min:2',
        ];
    }
}
