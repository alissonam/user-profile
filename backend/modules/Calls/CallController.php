<?php

namespace Calls;

use App\Http\Controllers\Controller;

/**
 * Class CallController
 * @package Calls
 */
class CallController extends Controller
{
    use CallResponse;

    /** @var CallService */
    private CallService $callService;

    /**
     * CallController constructor.
     * @param CallService $callService
     */
    public function __construct(CallService $callService)
    {
        $this->callService = $callService;
    }

    /**
     * @param CallRequest $request
     * @return mixed
     */
    public function index(CallRequest $request)
    {
        $result = $this->callService->index($request->validated());

        return $this->response($result['response'], $result['status']);
    }

    /**
     * @param CallRequest $request
     * @return mixed
     */
    public function store(CallRequest $request)
    {
        $result = $this->callService->store($request->validated());

        return $this->response($result['response'], $result['status']);
    }

    /**
     * @param Call $call
     * @return mixed
     */
    public function show(Call $call)
    {
        return $this->response($call->load(\request('with') ?? [])->toArray());
    }

    /**
     * @param CallRequest $request
     * @param Call $call
     * @return mixed
     */
    public function update(CallRequest $request, Call $call)
    {
        $result = $this->callService->update($call, $request->validated());

        return $this->response($result['response'], $result['status']);
    }

    /**
     * @param Call $call
     * @return mixed
     */
    public function destroy(Call $call)
    {
        $result = $this->callService->destroy($call);

        return $this->response($result['response'], $result['status']);
    }
}
