<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company as CompanyModel;
use App\Models\Worker as WorkerModel;
use App\Traits\Models\GetTableNameForModel;

/**
 * @property int $id
 * @property integer $fk_company
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 * @property string $description
 * @property boolean $inactive
 * @property Company $company
 * @property Worker[] $workers
 */
class Customer extends Model
{
    use GetTableNameForModel;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * @var array
     */
    protected $fillable = ['fk_company', 'created_at', 'updated_at', 'name', 'description', 'inactive'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(CompanyModel::class, 'fk_company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workers()
    {
        return $this->hasMany(WorkerModel::class, 'fk_customer');
    }

}
