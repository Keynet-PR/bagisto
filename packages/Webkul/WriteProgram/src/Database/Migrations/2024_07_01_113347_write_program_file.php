<?php declare(strict_types=1); 

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
        Schema::create('write_program_files', function (Blueprint $table) {
            $table->string('file_name');
            $table->integer('write_program_id')->unsigned();
            $table->morphs('filable');
            $table->timestamps();
            $table->foreign('write_program_id')->references('id')->on('write_programs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('write_program_files');
    }
};
