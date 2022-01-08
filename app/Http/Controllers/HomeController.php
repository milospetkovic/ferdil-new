<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View as ViewAlias;
use Illuminate\Http\Request;
use App\Models\Managers\CompanyManager;
use App\Models\Managers\WorkerManager;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Shows the application dashboard.
     * If user is not logged redirect to the login form.
     *
     * @return ViewAlias
     */
    public function index()
    {
        $compManager = new CompanyManager();
        $countCompanies = $compManager->returnCountOfAllCompanies();
        if (!($countCompanies > 0)) {
            $countCompanies = 0;
        }

        $workerManager = new WorkerManager();
        $countWorkers = $workerManager->countWorkers();
        if (!($countWorkers > 0)) {
            $countWorkers = 0;
        }

        $countInactiveWorkers = 0;
        if ($countWorkers) {
            $countInactiveWorkers = $workerManager->countWorkers(null, 1);
        }

        $countActiveWorkers = 0;
        if ($countWorkers) {
            $countActiveWorkers = $countWorkers - $countInactiveWorkers;
        }

        return view('home', [
            'companies_count'      => $countCompanies,
            'workers_count'        => $countWorkers,
            'active_workers_count' => $countActiveWorkers
        ]);
    }
}
