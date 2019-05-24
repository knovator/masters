<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code');
            $table->string('slug')->nullable();
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('parent_id')->nullable();
//            $table->unsignedBigInteger('file_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
//            $table->unsignedBigInteger('created_by')->nullable();
//            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('masters', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('masters')->onDelete('cascade');
//            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
//            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('masters');
    }
}
