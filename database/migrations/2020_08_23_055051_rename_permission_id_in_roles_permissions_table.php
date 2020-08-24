<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePermissionIdInRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles_permissions', function (Blueprint $table) {
            //
            $table->dropForeign(['permission_id']);
            // $table->renameColumn('user_id', 'permission_id');
            $table->foreign('permission_id')->references('id')->on('roles_permissions')->onDelete('cascade');
        });

        // Schema::table('roles_permissions', function (Blueprint $table) {
            
        // });

        // Schema::table('roles_permissions', function (Blueprint $table) {
            
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles_permissions', function (Blueprint $table) {
        //     //dropIfExists
            $table->dropForeign(['permission_id']);
            $table->foreign('permission_id')->references('id')->on('roles_permissions');
        });
        // Schema::dropIfExists('roles_permissions');
        // Schema::table('roles_permissions', function (Blueprint $table) {
            
        // });

        // Schema::table('roles_permissions', function (Blueprint $table) {
            
        // });        
    }
}
