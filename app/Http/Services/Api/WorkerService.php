<?php

namespace App\Http\Services\Api;

use DB;
use App\Models\Worker as WorkerModel;
use App\Models\Customer as CustomerModel;

class WorkerService
{

    public function getWorkersSql()
    {
        return DB::table(WorkerModel::getTableName().' AS w')
            ->join(CustomerModel::getTableName().' AS c', 'c.id', '=', 'w.fk_customer')
            ->select('c.id', 'c.name',
                // Count all workers linked with customer.
                DB::raw('(SELECT COUNT(*) FROM workers as w1 WHERE w1.fk_customer = c.id) AS customer_count_all_workers'),
                // Count active workers linked with customer.
                DB::raw('(SELECT COUNT(*) FROM workers as w2 WHERE w2.fk_customer = c.id AND (w2.inactive != 1 OR w2.inactive IS NULL)) AS customer_count_active_workers'),
                'w.id as worker_id', 'w.first_name', 'w.last_name', 'w.contract_start', 'w.contract_end', 'w.jmbg', 'w.inactive',
                'w.active_until_date', 'w.send_contract_ended_notification', 'w.description'
            )
            ->where('c.fk_company', auth()->user()->company->id);
    }

}
