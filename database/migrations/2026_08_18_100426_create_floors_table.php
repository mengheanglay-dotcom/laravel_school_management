<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('floors', function(Blueprint $table){$table->id();$table->string('floor_number',50);$table->foreignId('building_id')->constrained('buildings')->cascadeOnDelete();$table->timestamps();$table->unique(['building_id','floor_number']);});} public function down(): void {Schema::dropIfExists('floors');} };
