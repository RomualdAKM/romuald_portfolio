<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name','proficiency','service_id'];

    public function service() {

        return $this->belongsTo(Service::class);
    }
}