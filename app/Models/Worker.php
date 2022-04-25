<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Worker as WorkerModel;
use App\Models\Company as CompanyModel;

/**
 * @property int $id
 * @property integer $fk_company
 * @property int $fk_customer
 * @property string $created_at
 * @property string $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $contract_start
 * @property string $contract_end
 * @property string $jmbg
 * @property string $active_until_date
 * @property boolean $send_contract_ended_notification
 * @property string $description
 * @property boolean $inactive
 * @property Customer $customer
 * @property Company $company
 */
class Worker extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['fk_company', 'fk_customer', 'created_at', 'updated_at', 'first_name', 'last_name', 'contract_start', 'contract_end', 'jmbg', 'active_until_date', 'send_contract_ended_notification', 'description', 'inactive'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(WorkerModel::class, 'fk_customer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(CompanyModel::class, 'fk_company');
    }

}
