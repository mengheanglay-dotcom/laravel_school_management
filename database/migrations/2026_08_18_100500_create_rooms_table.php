<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('rooms', function(Blueprint $table){$table->id();$table->string('room_number',100);$table->foreignId('floor_id')->constrained('floors')->cascadeOnDelete();$table->timestamps();$table->unique(['floor_id','room_number']);});} public function down(): void {Schema::dropIfExists('rooms');} };
