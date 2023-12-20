<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->boolean('status')->default(1);
            $table->string('user_name', 255);
            $table->string('email', 400)->nullable();
            $table->integer('phone')->nullable();
            $table->smallInteger('code_country')->nullable();
            $table->enum('experience', ['Muy buena', 'Buena', 'Regular', 'Mala', 'Muy mala']);
            $table->text('com_design');
            $table->text('com_content');
            $table->text('com_funtionallity')->nullable();
            $table->text('com_ease_use');
            $table->text('com_suggest')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_feedback');
    }
};
