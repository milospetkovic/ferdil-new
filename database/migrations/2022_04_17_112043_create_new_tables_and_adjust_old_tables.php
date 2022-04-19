<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Company as CompanyModel;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;

class CreateNewTablesAndAdjustOldTables extends Migration
{
    private $firstCompanyId = 1;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::disableForeignKeyConstraints();

        // Create companies table.
        if (!Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->string('name', 64)->unique();
                $table->timestamps();
            });
        }

        // Insert first company.
        $companyModel = new CompanyModel();
        if (empty(CompanyModel::all()->count())) {
            $companyModel->name = "Fer Dil";
            $companyModel->created_at = \Carbon\Carbon::now();
            $companyModel->updated_at = \Carbon\Carbon::now();
            $companyModel->save();
        }

        // Add `fk_company` column to the `users` table.
        if (Schema::hasTable('users') &&
            !Schema::hasColumn('users', 'fk_company'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->bigInteger('fk_company', false, true)->after('id');
            });
        }

        if (Schema::hasColumn('users', 'fk_company')
        ) {
            // Link existing users with first company.
            DB::table('users')->where('fk_company', '=', 0)->update(array('fk_company' => $this->firstCompanyId));

            // Add foreign key `fk_company` in `users` table.
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('fk_company')->references('id')->on('companies')->cascadeOnUpdate()->cascadeOnDelete();
            });
        }

        // Rename old `company` table to `customers`.
        if (Schema::hasTable('company')) {
            Schema::rename('company', 'customers');
        }

        // Remove old unique index from the `customers` table (previous `company` table).
        if (Schema::hasTable('customers')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropIndex('company_name_unique');
            });
        }

        // Add `fk_company` column and constraints to the `customers` table.
        if (Schema::hasTable('customers') &&
            !Schema::hasColumn('customers', 'fk_company'))
        {
            // Add `fk_company` column to the `customers` table.
            Schema::table('customers', function (Blueprint $table) {
                $table->bigInteger('fk_company', false, true)->after('id');
            });

            // Link existing customers with the first company.
            DB::table('customers')->where('fk_company', '=', 0)->update(array('fk_company' => $this->firstCompanyId));

            // Add new unique index in the `customers` table.
            Schema::table('customers', function (Blueprint $table) {
                $table->unique(['fk_company', 'name'], 'fk_company_name_unique');
            });

            // Add foreign key `fk_company` in the `customers` table.
            Schema::table('customers', function (Blueprint $table) {
                $table->foreign('fk_company')->references('id')->on('companies')->cascadeOnUpdate()->cascadeOnDelete();
            });
        }

        // Adjustments in `worker` table.
        if (Schema::hasTable('worker') &&
            Schema::hasColumn('worker', 'fk_company'))
        {
            // Drop foreign key in the `worker` table.
            DB::statement('ALTER TABLE worker DROP FOREIGN KEY worker_fk_company_foreign');

            // Remove old unique index from the `worker` table.
            Schema::table('worker', function (Blueprint $table) {
                $table->dropIndex('worker_fk_company_first_name_last_name_unique');
            });

            // Rename `fk_company` column to the `fk_customer` column in the `worker` table.
            DB::statement('ALTER TABLE worker CHANGE fk_company fk_customer INT(11) NOT NULL COMMENT \'Link worker to a customer\'');

            // Add foreign key `fk_customer` in the `worker` table.
            Schema::table('worker', function (Blueprint $table) {
                $table->foreign('fk_customer')->references('id')->on('customers')->cascadeOnUpdate()->cascadeOnDelete();;
            });

            // Add `fk_company` column to the `worker` table.
            Schema::table('worker', function (Blueprint $table) {
                $table->bigInteger('fk_company', false, true)->after('id');
            });

            // Link existing workers with the first company.
            DB::table('worker')->where('fk_company', '=', 0)->update(array('fk_company' => $this->firstCompanyId));

            // Add foreign key `fk_company` in the `worker` table.
            Schema::table('worker', function (Blueprint $table) {
                $table->foreign('fk_company')->references('id')->on('companies')->onUpdate('no action')->onDelete('no action');
            });

            // Add new unique index in the `worker` table.
            Schema::table('worker', function (Blueprint $table) {
                $table->unique(['fk_company', 'fk_customer', 'first_name', 'last_name', 'jmbg'], 'worker_unique');
            });
        }

        // Rename `worker` table to the `workers` table.
        if (Schema::hasTable('worker')) {
            Schema::rename('worker', 'workers');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
