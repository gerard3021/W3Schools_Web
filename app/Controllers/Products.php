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

    public function index()
    {
        $data = $this->extras();
        $data['items'] = (new ProductModel())->orderBy('ProductID','DESC')->findAll();
        return $this->header() . view('products/lista', $data) . $this->footer();
    }

    public function create()
    {
        $data = array_merge($this->extras(), ['errores'=>[],'old'=>[]]);
        return $this->header() . view('products/create', $data) . $this->footer();
    }

    public function store()
    {
        $rules = [
            'ProductName' => 'required|max_length[255]',
            'Price'       => 'required|numeric|greater_than[0]',
        ];
        if (!$this->validate($rules)) {
            $data = array_merge($this->extras(), [
                'errores' => $this->validator->getErrors(),
                'old'     => $this->request->getPost()
            ]);
            return $this->header() . view('products/create', $data) . $this->footer();
        }
        (new ProductModel())->save($this->request->getPost(['ProductName','SupplierID','CategoryID','Unit','Price']));
        return redirect()->to('/products')->with('mensaje', 'Producto registrado correctamente.');
    }

    public function editar($id = null)
    {
        $item = (new ProductModel())->find($id);
        if (!$item) return redirect()->to('/products')->with('mensaje', 'No encontrado.');
        $data = array_merge($this->extras(), ['item'=>$item,'errores'=>[]]);
        return $this->header() . view('products/editar', $data) . $this->footer();
    }

    public function update($id = null)
    {
        $model = new ProductModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/products');
        $rules = ['ProductName'=>'required|max_length[255]','Price'=>'required|numeric|greater_than[0]'];
        if (!$this->validate($rules)) {
            $data = array_merge($this->extras(), [
                'item'    => array_merge($item, $this->request->getPost()),
                'errores' => $this->validator->getErrors()
            ]);
            return $this->header() . view('products/editar', $data) . $this->footer();
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
