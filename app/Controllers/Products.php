<?php
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SupplierModel;

class Products extends BaseController
{
    private function header() { return view('layout/header'); }
    private function footer() { return '</main></body></html>'; }

    private function extras()
    {
        return [
            'categories' => (new CategoryModel())->findAll(),
            'suppliers'  => (new SupplierModel())->findAll(),
        ];
    }

    private $rules = [
        'ProductName' => 'required|min_length[2]|max_length[255]',
        'SupplierID'  => 'required|integer',
        'CategoryID'  => 'required|integer',
        'Unit'        => 'required|min_length[2]|max_length[255]',
        'Price'       => 'required|numeric|greater_than[0]',
    ];

    public function index()
    {
        $data = $this->extras();
        $data['items'] = (new ProductModel())->orderBy('ProductID','DESC')->findAll();
        return $this->header() . view('products/lista', $data) . $this->footer();
    }

    public function create()
    {
        return $this->header() . view('products/create', array_merge($this->extras(), ['errores'=>[],'old'=>[]])) . $this->footer();
    }

    public function store()
    {
        if (!$this->validate($this->rules)) {
            return $this->header() . view('products/create', array_merge($this->extras(), [
                'errores' => $this->validator->getErrors(), 'old' => $this->request->getPost()
            ])) . $this->footer();
        }
        (new ProductModel())->save($this->request->getPost(['ProductName','SupplierID','CategoryID','Unit','Price']));
        return redirect()->to('/products')->with('mensaje', 'Producto registrado correctamente.');
    }

    public function editar($id = null)
    {
        $item = (new ProductModel())->find($id);
        if (!$item) return redirect()->to('/products')->with('mensaje', 'No encontrado.');
        return $this->header() . view('products/editar', array_merge($this->extras(), ['item'=>$item,'errores'=>[]])) . $this->footer();
    }

    public function update($id = null)
    {
        $model = new ProductModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/products');
        if (!$this->validate($this->rules)) {
            return $this->header() . view('products/editar', array_merge($this->extras(), [
                'item'    => array_merge($item, $this->request->getPost()),
                'errores' => $this->validator->getErrors()
            ])) . $this->footer();
        }
        $model->update($id, $this->request->getPost(['ProductName','SupplierID','CategoryID','Unit','Price']));
        return redirect()->to('/products')->with('mensaje', 'Producto actualizado correctamente.');
    }

    public function delete($id = null)
    {
        (new ProductModel())->delete($id);
        return redirect()->to('/products')->with('mensaje', 'Producto eliminado.');
    }
}
