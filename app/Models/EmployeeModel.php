<?php
namespace App\Models;
use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table      = 'employees';
    protected $primaryKey = 'EmployeeID';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['LastName','FirstName','BirthDate','Photo','Notes'];
    protected $useTimestamps = false;
}
