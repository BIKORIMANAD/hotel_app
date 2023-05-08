<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hstatuses', function (Blueprint $table) {
            $table->id();
            $table->string('type_name')->nullable();
            $table->timestamps();
        });

        DB::table('hstatuses')->insert([
            ['type_name' => 'Active'],
            ['type_name' => 'Inactive'],
            ['type_name' => 'Disable']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hstatuses');
    }
};
