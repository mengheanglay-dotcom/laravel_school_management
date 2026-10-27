<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; use Illuminate\Database\Eloquent\Model;
class Floor extends Model { use HasFactory; protected $fillable=['floor_number','building_id']; public function building(){return $this->belongsTo(Building::class);} public function rooms(){return $this->hasMany(Room::class);} }
