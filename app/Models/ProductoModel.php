<?php

namespace App\Models;
use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table      = 'productos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo', 'nombre', 'descripcion', 'categoria',
        'precio_compra', 'precio_venta', 'stock', 'marca', 'estado', 'imagen'
    ];
    protected $useTimestamps = true;

    public function obtenerProductos()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }
}