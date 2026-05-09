<?php
namespace App\Models;
use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table      = 'orders';
    protected $primaryKey = 'OrderID';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['CustomerID','EmployeeID','OrderDate','ShipperID'];
    protected $useTimestamps = false;

    public function obtenerConRelaciones()
    {
        return $this->db->table('orders o')
            ->select('o.OrderID, c.CustomerName, e.FirstName, e.LastName, o.OrderDate, s.ShipperName')
            ->join('customers c', 'c.CustomerID = o.CustomerID', 'left')
            ->join('employees e', 'e.EmployeeID = o.EmployeeID', 'left')
            ->join('shippers s',  's.ShipperID  = o.ShipperID',  'left')
            ->orderBy('o.OrderID', 'DESC')
            ->get()->getResultArray();
    }
}
