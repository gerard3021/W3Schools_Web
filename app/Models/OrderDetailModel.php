<?php
namespace App\Models;
use CodeIgniter\Model;

class OrderDetailModel extends Model
{
    protected $table            = 'order_details';
    protected $primaryKey       = 'OrderDetailID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['OrderID','ProductID','Quantity'];
    protected $useTimestamps    = false;

    public function insertarDetalle(int $orderId, int $productId, int $qty): bool
    {
        return $this->db->query(
            'INSERT INTO order_details (OrderID, ProductID, Quantity) VALUES (?,?,?)',
            [$orderId, $productId, $qty]
        );
    }

    public function obtenerConRelaciones()
    {
        return $this->db->table('order_details od')
            ->select('od.OrderDetailID, od.OrderID, p.ProductName, od.Quantity, p.Price, (od.Quantity * p.Price) as Subtotal')
            ->join('products p', 'p.ProductID = od.ProductID', 'left')
            ->orderBy('od.OrderDetailID', 'DESC')
            ->get()->getResultArray();
    }
}
