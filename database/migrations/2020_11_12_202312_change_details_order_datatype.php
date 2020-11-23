<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeDetailsOrderDatatype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('details_orders', function (Blueprint $table) {
            // modificando el tipo de dato
            DB::statement("ALTER TABLE details_orders MODIFY price DOUBLE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('details_orders', function (Blueprint $table) {
            // revirtiendo los cambios a como estaba antes
            DB::statement("ALTER TABLE details_orders MODIFY price SMALLINT");
        });
    }
}
