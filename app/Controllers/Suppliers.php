<?php
namespace App\Controllers;
use App\Models\SupplierModel;

class Suppliers extends BaseController
{
    private function header() { return view('layout/header'); }
    private function footer() { return '</main></body></html>'; }

    public function index()
    {
        $model = new SupplierModel();
        $data['items'] = $model->orderBy('SupplierID','DESC')->findAll();
        return $this->header() . view('suppliers/lista', $data) . $this->footer();
    }

    public function create()
    {
        return $this->header() . view('suppliers/create', ['errores'=>[],'old'=>[]]) . $this->footer();
    }

    public function store()
    {
        $rules = ['SupplierName'=>'required|max_length[255]','ContactName'=>'permit_empty|max_length[255]'];
        if (!$this->validate($rules)) {
            return $this->header() . view('suppliers/create', [
                'errores'=>$this->validator->getErrors(),'old'=>$this->request->getPost()
            ]) . $this->footer();
        }
        $model = new SupplierModel();
        $model->save($this->request->getPost(['SupplierName','ContactName','Address','City','PostalCode','Country','Phone']));
        return redirect()->to('/suppliers')->with('mensaje', 'Proveedor registrado correctamente.');
    }

    public function editar($id = null)
    {
        $model = new SupplierModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/suppliers')->with('mensaje', 'No encontrado.');
        return $this->header() . view('suppliers/editar', ['item'=>$item,'errores'=>[]]) . $this->footer();
    }

    public function update($id = null)
    {
        $model = new SupplierModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/suppliers');
        $rules = ['SupplierName'=>'required|max_length[255]'];
        if (!$this->validate($rules)) {
            return $this->header() . view('suppliers/editar', [
                'item'    => array_merge($item, $this->request->getPost()),
                'errores' => $this->validator->getErrors()
            ]) . $this->footer();
        }
        $model->update($id, $this->request->getPost(['SupplierName','ContactName','Address','City','PostalCode','Country','Phone']));
        return redirect()->to('/suppliers')->with('mensaje', 'Proveedor actualizado correctamente.');
    }

    public function delete($id = null)
    {
        (new SupplierModel())->delete($id);
        return redirect()->to('/suppliers')->with('mensaje', 'Proveedor eliminado.');
    }
}
