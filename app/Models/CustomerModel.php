<?php
namespace App\Models;
use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table      = 'customers';
    protected $primaryKey = 'CustomerID';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['CustomerName','ContactName','Address','City','PostalCode','Country'];
    protected $useTimestamps = false;
}
