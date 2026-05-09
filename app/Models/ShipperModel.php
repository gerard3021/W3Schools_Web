<?php
namespace App\Models;
use CodeIgniter\Model;

class ShipperModel extends Model
{
    protected $table      = 'shippers';
    protected $primaryKey = 'ShipperID';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['ShipperName','Phone'];
    protected $useTimestamps = false;
}
