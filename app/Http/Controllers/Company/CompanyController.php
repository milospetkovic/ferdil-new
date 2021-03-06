<?php

namespace App\Http\Controllers\Company;

use App\Models\Entity\Company;
use App\Models\Entity\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Managers\CompanyManager;
use App\Helpers\EventMessages;
use App\Models\Managers\WorkerManager;

class CompanyController extends Controller
{
    /**
     * @var CompanyManager
     */
    private $companyManager;

    /**
     * @var WorkerManager
     */
    private $workerManager;

    public function __construct()
    {
        $this->middleware('auth');

        $this->companyManager = new CompanyManager();
        $this->workerManager = new WorkerManager();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'view_type' => 'create'
        ];

        return view('company.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:company|max:128'
        ]);

        $name = $request->input('name');

        $companyID = $this->companyManager->storeCompany($name);

        flash(EventMessages::ACTION_SUCCESS, "success");

        return redirect()->action('App\Http\Controllers\Company\CompanyController@create');

        // use if redirect should be to the newly created company
        //return redirect()->action('App\Http\Controllers\Company\CompanyController@show', ['id' => $companyID]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $showinactive = $request->get('showinactive');

        $company = $this->companyManager->getCompany($id);

        $workers = $this->workerManager->returnWorkersAndCompanies($id, $showinactive)->toArray();

        $data['company'] = $company;

        return view('company.show', [  'showinactive' => $showinactive,
                                            'company' => $company,
                                            'workers' => $workers ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);

        $data = [
            'view_type' => 'edit',
            'company'   => $company
        ];

        return view('company.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'company_id' => 'required|integer',
            'name'       => 'required|unique:company|max:128'
        ]);

        $id = $request->input('company_id');
        $name = $request->input('name');

        $company = Company::find($id);
        $company->name = $name;
        $company->save();

        flash(EventMessages::ACTION_SUCCESS, "success");

        return redirect()->action('App\Http\Controllers\Company\CompanyController@create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * List all companies.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listCompanies()
    {
        $companies = $this->companyManager->returnAllCompanies()->toArray();
        $company_cnt_workers = [];
        $company_cnt_inactive_workers = [];
        $company_cnt_active_workers = [];

        if (is_array($companies) && count($companies)) {
            foreach ($companies as $comp) {
                $company_cnt_workers[$comp->id] = $this->workerManager->countWorkers($comp->id);
                $company_cnt_inactive_workers[$comp->id] = $this->workerManager->countWorkers($comp->id, 1);
                if ($company_cnt_inactive_workers[$comp->id]) {
                    $company_cnt_active_workers[$comp->id] = $company_cnt_workers[$comp->id] - $company_cnt_inactive_workers[$comp->id];
                }
            }
        }

        return view('company.list', [  'companies' => $companies,
                                            'company_cnt_workers' => $company_cnt_workers,
                                            'company_cnt_inactive_workers' => $company_cnt_inactive_workers,
                                            'company_cnt_active_workers' => $company_cnt_active_workers ]);
    }

    /**
     * Delete a company and company's linked workers.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $res = Company::destroy($id);

        if ($res > 0) {
            flash(EventMessages::ACTION_SUCCESS, "success");
            return redirect()->action('App\Http\Controllers\Company\CompanyController@listCompanies');
        }

        flash(EventMessages::ACTION_ERROR, "error");
        return redirect()->action('App\Http\Controllers\Company\CompanyController@show', $id);
    }

}
