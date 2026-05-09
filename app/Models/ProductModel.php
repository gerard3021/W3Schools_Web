<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'ProductID';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['ProductName','SupplierID','CategoryID','Unit','Price'];
    protected $useTimestamps = false;
}
