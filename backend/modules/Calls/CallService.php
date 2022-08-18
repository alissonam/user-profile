<?php

namespace Calls;

use App\Http\Services\Service;

/**
 * Class CallService
 * @package Calls
 */
class CallService extends Service
{
    /**
     * @param array $filters
     * @return array
     */
    public function index(array $filters)
    {
        $callsQuery = CallRepository::index($filters);

        return self::buildReturn(
            $callsQuery
                ->with(\request()->with ?? [])
                ->paginate(\request()->perPage)
        );
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data)
    {
        $call = Call::create($data);

        return self::buildReturn($call);
    }

    /**
     * @param Call $call
     * @param array $data
     * @return array
     */
    public function update(Call $call, array $data)
    {
        $call->update($data);

        return self::buildReturn($call);
    }

    /**
     * @param Call $call
     * @return array
     */
    public function destroy(Call $call)
    {
        $call->delete();

        return self::buildReturn();
    }
}
