<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User as UserModel;
use App\Traits\Models\GetTableNameForModel;

class Company extends Model
{
    use HasFactory, GetTableNameForModel;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * @var array
     */
    protected $fillable = ['name', 'created_at', 'updated_at'];

    /**
     * Get users of the company.
     */
    public function users()
    {
        return $this->hasMany(UserModel::class, 'fk_company');
    }

}
