<?php
namespace App\Controllers;
use App\Models\OrderModel;
use App\Models\CustomerModel;
use App\Models\EmployeeModel;
use App\Models\ShipperModel;
use App\Models\OrderDetailModel;
use App\Models\ProductModel;

class Orders extends BaseController
{
    private function header() { return view('layout/header'); }
    private function footer() { return '</main></body></html>'; }

    private function extras()
    {
        return [
            'customers' => (new CustomerModel())->orderBy('CustomerName','ASC')->findAll(),
            'employees' => (new EmployeeModel())->orderBy('LastName','ASC')->findAll(),
            'shippers'  => (new ShipperModel())->findAll(),
            'products'  => (new ProductModel())->orderBy('ProductName','ASC')->findAll(),

        ];
    }

    public function index()
    {
        $data['items'] = (new OrderModel())->obtenerConRelaciones();
        return $this->header() . view('orders/lista', $data) . $this->footer();
    }

    public function create()
    {
        $data = array_merge($this->extras(), ['errores'=>[],'old'=>[]]);
        return $this->header() . view('orders/create', $data) . $this->footer();
    }

        public function store()
    {
        $rules = [
            'CustomerID' => 'required|integer',
            'EmployeeID' => 'required|integer',
            'OrderDate'  => 'required|valid_date',
            'ShipperID'  => 'required|integer',
        ];

        $productIds = $this->request->getPost('ProductID') ?? [];
        $quantities = $this->request->getPost('Quantity')  ?? [];

        $detalles = [];
        $errDetalles = null;
        $vistos = [];
        $count = max(count($productIds), count($quantities));
        for ($i = 0; $i < $count; $i++) {
            $pid = isset($productIds[$i]) ? (int)$productIds[$i] : 0;
            $qty = isset($quantities[$i]) ? (int)$quantities[$i] : 0;
            if ($pid <= 0) continue;
            if ($qty <= 0) {
                $errDetalles = 'La cantidad debe ser mayor a 0 para todos los productos.';
                break;
            }
            if (in_array($pid, $vistos, true)) {
                $errDetalles = 'No se permiten productos duplicados en la orden.';
                break;
            }
            $vistos[] = $pid;
            $detalles[] = ['ProductID' => $pid, 'Quantity' => $qty];
        }

        if (!$errDetalles && empty($detalles)) {
            $errDetalles = 'Debes agregar al menos un producto a la orden.';
        }

        if (!$this->validate($rules) || $errDetalles) {
            $errores = $this->validator ? $this->validator->getErrors() : [];
            if ($errDetalles) $errores['Productos'] = $errDetalles;
            $data = array_merge($this->extras(), [
                'errores' => $errores,
                'old'     => $this->request->getPost()
            ]);
            return $this->header() . view('orders/create', $data) . $this->footer();
        }

        $orderModel = new OrderModel();
        $orderModel->save($this->request->getPost(['CustomerID','EmployeeID','OrderDate','ShipperID']));
        $orderId = $orderModel->getInsertID();

        $detModel = new OrderDetailModel();
        foreach ($detalles as $d) {
            $detModel->insert([
                'OrderID'   => $orderId,
                'ProductID' => $d['ProductID'],
                'Quantity'  => $d['Quantity'],
            ]);
        }

        return redirect()->to('/orders')->with('mensaje', 'Orden registrada correctamente con ' . count($detalles) . ' producto(s).');
    }

    public function editar($id = null)
    {
        $item = (new OrderModel())->find($id);
        if (!$item) return redirect()->to('/orders')->with('mensaje', 'No encontrado.');
        $data = array_merge($this->extras(), $this->datosDetalles($id), ['item' => $item, 'errores' => [], 'editando' => null]);
        return $this->header() . view('orders/editar', $data) . $this->footer();
    }

    public function update($id = null)
    {
        $model = new OrderModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/orders');

        $rules = [
            'CustomerID' => 'required|integer',
            'EmployeeID' => 'required|integer',
            'OrderDate'  => 'required|valid_date',
            'ShipperID'  => 'required|integer',
        ];

        $productIds = $this->request->getPost('ProductID') ?? [];
        $quantities = $this->request->getPost('Quantity')  ?? [];

        $detalles    = [];
        $errDetalles = null;
        $vistos      = [];
        $count       = max(count($productIds), count($quantities));
        for ($i = 0; $i < $count; $i++) {
            $pid = isset($productIds[$i]) ? (int)$productIds[$i] : 0;
            $qty = isset($quantities[$i]) ? (int)$quantities[$i] : 0;
            if ($pid <= 0) continue;
            if ($qty <= 0) { $errDetalles = 'La cantidad debe ser mayor a 0 para todos los productos.'; break; }
            if (in_array($pid, $vistos, true)) { $errDetalles = 'No se permiten productos duplicados en la orden.'; break; }
            $vistos[]   = $pid;
            $detalles[] = ['ProductID' => $pid, 'Quantity' => $qty];
        }

        if (!$errDetalles && empty($detalles)) {
            $errDetalles = 'Debes agregar al menos un producto a la orden.';
        }

        if (!$this->validate($rules) || $errDetalles) {
            $errores = $this->validator ? $this->validator->getErrors() : [];
            if ($errDetalles) $errores['Productos'] = $errDetalles;
            $data = array_merge($this->extras(), $this->datosDetalles($id), [
                'item'     => array_merge($item, $this->request->getPost()),
                'errores'  => $errores,
                'editando' => null,
            ]);
            return $this->header() . view('orders/editar', $data) . $this->footer();
        }

        $model->update($id, $this->request->getPost(['CustomerID','EmployeeID','OrderDate','ShipperID']));

        $db = \Config\Database::connect();
        $db->query('DELETE FROM order_details WHERE OrderID = ?', [(int)$id]);
        foreach ($detalles as $d) {
            $db->query(
                'INSERT INTO order_details (OrderID, ProductID, Quantity) VALUES (?,?,?)',
                [(int)$id, $d['ProductID'], $d['Quantity']]
            );
        }

        return redirect()->to('/orders/detalles/' . $id)->with('mensaje', 'Orden actualizada correctamente.');
    }

    public function delete($id = null)
    {
        (new OrderModel())->delete($id);
        return redirect()->to('/orders')->with('mensaje', 'Orden eliminada.');
    }

    private function cargarDetalles($orderId)
    {
        $db = \Config\Database::connect();
        return $db->query(
            'SELECT od.OrderDetailID, od.OrderID, od.ProductID,
                    p.ProductName, od.Quantity, p.Price,
                    (od.Quantity * p.Price) AS Subtotal
             FROM order_details od
             LEFT JOIN products p ON p.ProductID = od.ProductID
             WHERE od.OrderID = ?
             ORDER BY od.OrderDetailID ASC',
            [$orderId]
        )->getResultArray();
    }

    private function productosEnOrden($orderId): array
    {
        $db = \Config\Database::connect();
        $rows = $db->query(
            'SELECT ProductID FROM order_details WHERE OrderID = ?',
            [$orderId]
        )->getResultArray();
        return array_column($rows, 'ProductID');
    }

    private function datosDetalles($orderId, $editando = null): array
    {
        $usados = $this->productosEnOrden($orderId);
        $editandoProductID = $editando ? (int)$editando['ProductID'] : null;

        return [
            'orden'            => (new OrderModel())->find($orderId),
            'orderId'          => $orderId,
            'detalles'         => $this->cargarDetalles($orderId),
            'products'         => (new ProductModel())->orderBy('ProductName','ASC')->findAll(),
            'productos_usados' => $usados,
            'editando'         => $editando,
            'editandoProductID'=> $editandoProductID,
        ];
    }

    public function detalles($orderId = null)
    {
        $order = (new OrderModel())->find($orderId);
        if (!$order) return redirect()->to('/orders')->with('mensaje', 'Orden no encontrada.');
        return $this->header() . view('orders/detalles', $this->datosDetalles($orderId)) . $this->footer();
    }

    public function detalleStore($orderId = null)
    {
        $productID = (int)$this->request->getPost('ProductID');
        $quantity  = (int)$this->request->getPost('Quantity');

        if ($productID <= 0 || $quantity <= 0) {
            return redirect()->to('/orders/detalles/' . $orderId);
        }

        $db     = \Config\Database::connect();
        $existe = $db->query(
            'SELECT OrderDetailID FROM order_details WHERE OrderID=? AND ProductID=?',
            [(int)$orderId, $productID]
        )->getRow();

        if ($existe) {
            return redirect()->to('/orders/detalles/' . $orderId)
                ->with('mensaje', 'Ese producto ya está en la orden.');
        }

        $db->query(
            'INSERT INTO order_details (OrderID, ProductID, Quantity) VALUES (?,?,?)',
            [(int)$orderId, $productID, $quantity]
        );

        return redirect()->to('/orders/editar/' . $orderId)
            ->with('mensaje', 'Producto agregado.');
    }

    public function detalleEditar($orderId = null, $detId = null)
    {
        $editando = (new OrderDetailModel())->find((int)$detId);
        if (!$editando) return redirect()->to('/orders/editar/' . $orderId);
        $item = (new OrderModel())->find($orderId);
        $data = array_merge($this->extras(), $this->datosDetalles($orderId, $editando), ['item' => $item]);
        return $this->header() . view('orders/editar', $data) . $this->footer();
    }

    public function detalleUpdate($orderId = null, $detId = null)
    {
        $quantity = (int)$this->request->getPost('Quantity');
        if ($quantity > 0) {
            $db = \Config\Database::connect();
            $db->query(
                'UPDATE order_details SET Quantity=? WHERE OrderDetailID=?',
                [$quantity, (int)$detId]
            );
        }
        return redirect()->to('/orders/editar/' . $orderId)
            ->with('mensaje', 'Cantidad actualizada.');
    }

    public function detalleDelete($orderId = null, $detId = null)
    {
        $db = \Config\Database::connect();
        $db->query('DELETE FROM order_details WHERE OrderDetailID=?', [(int)$detId]);
        return redirect()->to('/orders/editar/' . $orderId)
            ->with('mensaje', 'Producto eliminado de la orden.');
    }
}
