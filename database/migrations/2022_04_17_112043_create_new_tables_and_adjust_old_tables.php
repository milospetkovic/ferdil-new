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

        // Rename old `company` table to `customers`.
        if (Schema::hasTable('company')) {
            Schema::rename('company', 'customers');
        }

        // Add `fk_company` column to the `users` table.
        if (Schema::hasTable('users') &&
            !Schema::hasColumn('users', 'fk_company'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->bigInteger('fk_company', false, true)->after('id');
            });
        }

        // Link existing users with first company.
        if (Schema::hasColumn('users', 'fk_company')
        ) {
            DB::table('users')->where('fk_company', '=', 0)->update(array('fk_company' => $this->firstCompanyId));
        }

        // Add `fk_company` column to the `customers` table.
        if (Schema::hasTable('customers') &&
            !Schema::hasColumn('customers', 'fk_company'))
        {
            Schema::table('customers', function (Blueprint $table) {
                $table->bigInteger('fk_company', false, true)->after('id');
            });
        }

        // Link existing customers with first company.
        if (Schema::hasColumn('customers', 'fk_company')
        ) {
            DB::table('customers')->where('fk_company', '=', 0)->update(array('fk_company' => $this->firstCompanyId));
        }

        // Rename `fk_company` column to the `fk_customer` column in the `workers` table.
        if (Schema::hasTable('worker') &&
            Schema::hasColumn('worker', 'fk_company'))
        {
            DB::statement('ALTER TABLE worker DROP FOREIGN KEY worker_fk_company_foreign');

            DB::statement('ALTER TABLE worker CHANGE fk_company fk_customer INT(11) NOT NULL COMMENT \'Link worker to the customer\'');

            Schema::table('worker', function (Blueprint $table) {
                $table->foreign('fk_customer')->references('id')->on('customers');
            });
        }

        // Rename old `worker` table to `workers`.
        if (Schema::hasTable('worker')) {
            Schema::rename('worker', 'workers');
        }

        // Add `fk_company` column to the `worker` table.
        if (Schema::hasTable('worker') &&
            !Schema::hasColumn('worker', 'fk_company'))
        {
            Schema::table('worker', function (Blueprint $table) {
                $table->bigInteger('fk_company', false, true)->after('id');
            });
        }

        // Link existing workers with first company.
        if (Schema::hasColumn('worker', 'fk_company')
        ) {
            DB::table('worker')->where('fk_company', '=', 0)->update(array('fk_company' => $this->firstCompanyId));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        // Rename `workers` table to `worker` table.
//        if (Schema::hasTable('workers')) {
//            Schema::rename('workers', 'worker');
//        }
//
//        // Drop `fk_company` column from the `workers` table.
//        if (Schema::hasTable('workers') &&
//            Schema::hasColumn('workers', 'fk_company')
//        ) {
//            Schema::table('workers', function (Blueprint $table) {
//                $table->dropColumn('fk_company');
//            });
//        }
//
//        // Drop `fk_company` column from the `customers` table.
//        if (Schema::hasTable('customers') &&
//            Schema::hasColumn('customers', 'fk_company')
//        ) {
//            Schema::table('customers', function (Blueprint $table) {
//                $table->dropColumn('fk_company');
//            });
//        }
//
//        // Drop `fk_company` column from the `users` table.
//        if (Schema::hasTable('users') &&
//            Schema::hasColumn('users', 'fk_company')
//        ) {
//            Schema::table('users', function (Blueprint $table) {
//                $table->dropColumn('fk_company');
//            });
//        }
//
//        // Rename `customers` table to `company` table.
//        if (Schema::hasTable('customers')) {
//            Schema::rename('customers', 'company');
//        }
//
//        Schema::dropIfExists('companies');
    }

}
