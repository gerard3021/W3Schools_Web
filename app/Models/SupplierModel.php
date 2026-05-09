<?php
namespace App\Models;
use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table      = 'suppliers';
    protected $primaryKey = 'SupplierID';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['SupplierName','ContactName','Address','City','PostalCode','Country','Phone'];
    protected $useTimestamps = false;
}
