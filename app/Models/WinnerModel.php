<?php

namespace App\Models;

use CodeIgniter\Model;

class WinnerModel extends Model
{
    protected $table = 'winners';
    protected $primaryKey = 'id';
    protected $allowedFields = ['registrant_id', 'prize_id', 'status', 'created_at'];
    protected $useTimestamps = false;
    protected $createdField = 'created_at';

    protected $returnType = 'array';
}
