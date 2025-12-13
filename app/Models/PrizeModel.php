<?php namespace App\Models;

use CodeIgniter\Model;

class PrizeModel extends Model
{
    protected $table = 'prizes';
    protected $primaryKey = 'id';

    protected $allowedFields = ['prize_name', 'name', 'stock', 'raffled', 'images', 'image', 'is_grandprize', 'is_grand_prize'];
    
    protected $returnType = 'array';

    protected $useTimestamps = false;
}
