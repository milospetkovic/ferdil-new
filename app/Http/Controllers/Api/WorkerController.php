<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkerRequest;
use App\Http\Resources\WorkerResource;
use App\Models\Worker as WorkerModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    /**
     * Return user's workers.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Validation\ValidationException
     * @author Miloš Petković <elitasoft.web@gmail.com>
     */
    public function getUserWorkers()
    {
        return WorkerResource::collection(WorkerModel::where('fk_company', auth()->user()->company->id)->get());
    }

    public function store(WorkerRequest $request)
    {
        $data = $request->all();
        $data['fk_company'] = auth()->user()->company->id;
        $worker = WorkerModel::create($data);
        return new WorkerResource($worker);
    }

    public function show($workerId)
    {
        $worker = WorkerModel::where('id', $workerId)
            ->where('fk_company', auth()->user()->company->id)
            ->firstOrFail();
        return new JsonResponse($worker);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WorkerRequest $request
     * @param WorkerModel $worker
     * @return JsonResponse
     */
    public function update(WorkerRequest $request, WorkerModel $worker)
    {
        if ($request->validated()) {
            $worker->update($request->all());
        }
        return new JsonResponse($worker);
    }

}
