<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('checklist_id')->nullable();
            $table->unsignedInteger('task_id')->nullable();
            $table->string('object_domain')->nullable();
            $table->string('object_id')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_completed')->nullable();
            $table->string('due')->nullable();
            $table->integer('urgency')->nullable();
            $table->string('completed_at')->nullable();
            $table->unsignedInteger('last_update_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklist_attributes');
    }
}
