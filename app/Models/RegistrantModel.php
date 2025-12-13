<?php namespace App\Models;

use CodeIgniter\Model;

class RegistrantModel extends Model
{
    protected $table = 'registran';
    protected $allowedFields = ['name', 'email', 'phone_number', 'company', 'bisnis_unit', 'inputed_time'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';
}
