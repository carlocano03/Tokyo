<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $table = 'election_tbl';
    protected $primaryKey = 'election_id';
}
