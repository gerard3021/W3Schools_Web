<?php
namespace App\Models;
use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'CategoryID';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['CategoryName', 'Description'];
    protected $useTimestamps = false;
}
