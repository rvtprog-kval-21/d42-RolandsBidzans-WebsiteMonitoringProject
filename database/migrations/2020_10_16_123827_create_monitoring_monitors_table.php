<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringMonitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_check_types', function (Blueprint $table) {
            $table->id();
            $table->string("check_type_name");
        });

        Schema::create('monitoring_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('application_id');
            $table->string("application_name");

            $table->primary("application_id");
        });

        Schema::create('monitoring_items', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id');
            $table->string("check_address");
            $table->unsignedBigInteger("check_type");
            $table->unsignedBigInteger("application");

            $table->primary("item_id");

            $table->foreign('check_type')->references('id')->on('monitoring_check_types')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('application')->references('application_id')->on('monitoring_applications')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('monitoring_users_groups', function (Blueprint $table) {
            $table->string('group_id');
            $table->unsignedBigInteger('group_admin_id');
            $table->string('group_name');

            $table->primary('group_id');

            $table->foreign('group_admin_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('monitoring_group_members', function (Blueprint $table) {
            $table->string('group_id');
            $table->unsignedBigInteger('group_member');
            $table->unsignedBigInteger('group_member_permission');

            $table->primary(["group_id","group_member"]);

            $table->foreign('group_id')->references('group_id')->on('monitoring_users_groups')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('group_member')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    
        Schema::create('monitoring_hosts_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('host_group_id');
            $table->string("host_group_name");
            $table->string("user_group");

            $table->primary("host_group_id");

            $table->foreign('user_group')->references('group_id')->on('monitoring_users_groups')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('monitoring_hosts', function (Blueprint $table) {
            $table->unsignedBigInteger('host_id');
            $table->string("host_name");
            $table->string("check_address");
            $table->unsignedBigInteger("host_group");

            $table->primary("host_id");

            $table->foreign('host_group')->references('host_group_id')->on('monitoring_hosts_groups')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('monitoring_monitors', function (Blueprint $table) {
            $table->id();
            $table->string('friendly_name');
            $table->string('user_group');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('item');

            $table->timestamps();

            $table->foreign('user_group')->references('group_id')->on('monitoring_users_groups')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('item')->references('item_id')->on('monitoring_items')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('web_scenarios', function (Blueprint $table) {

            $table->unsignedBigInteger("httptest_id");
            $table->string("httptest_name");

            $table->primary("httptest_id");
        });

        Schema::create('host_has_application', function (Blueprint $table) {

            $table->unsignedBigInteger("host_id");
            $table->unsignedBigInteger("application");

            $table->primary(["host_id","application"]);

            $table->foreign('host_id')->references('host_id')->on('monitoring_hosts')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('application')->references('application_id')->on('monitoring_applications')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('host_has_web_scenario', function (Blueprint $table) {

            $table->unsignedBigInteger("web_scenario");
            $table->unsignedBigInteger("host_id");

            $table->primary(["web_scenario","host_id"]);

            $table->foreign('web_scenario')->references('httptest_id')->on('web_scenarios')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('host_id')->references('host_id')->on('monitoring_hosts')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitoring_monitors');
    }
}
