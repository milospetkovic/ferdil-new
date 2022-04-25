<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkerResource;
use App\Models\Worker as WorkerModel;

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

}
