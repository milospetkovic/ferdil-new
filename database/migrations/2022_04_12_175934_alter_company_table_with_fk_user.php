<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Entity\Company as CompanyModel;

class AlterCompanyTableWithFkUser extends Migration
{
    private $tableName = 'company';

    private $columnName = 'fk_user';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn($this->tableName, $this->columnName)) {
            $columnName = $this->columnName;
            Schema::table($this->tableName, function (Blueprint $table) use($columnName) {

                // Add column.
                $table->integer($columnName, false, true)->after('id')->comment('Foreign key to the `users` table.');

            });

            Schema::table($this->tableName, function (Blueprint $table) use($columnName) {

                // Update every company with user.
                CompanyModel::where($columnName, 0)
                    ->update([$columnName => 3]);

                // Foreign key.
                $table->foreign('fk_user')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            });
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
