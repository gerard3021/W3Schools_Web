<?php
namespace App\Controllers;
use App\Models\SupplierModel;

class Suppliers extends BaseController
{
    private function header() { return view('layout/header'); }
    private function footer() { return '</main></body></html>'; }

    private $rules = [
        'SupplierName' => 'required|min_length[2]|max_length[255]',
        'ContactName'  => 'required|min_length[2]|max_length[255]',
        'Address'      => 'required|min_length[3]|max_length[255]',
        'City'         => 'required|min_length[2]|max_length[255]',
        'PostalCode'   => 'required|max_length[20]',
        'Country'      => 'required|min_length[2]|max_length[255]',
        'Phone'        => 'required|min_length[4]|max_length[50]',
    ];

    public function index()
    {
        $data['items'] = (new SupplierModel())->orderBy('SupplierID','DESC')->findAll();
        return $this->header() . view('suppliers/lista', $data) . $this->footer();
    }

    public function create()
    {
        return $this->header() . view('suppliers/create', ['errores'=>[],'old'=>[]]) . $this->footer();
    }

    public function store()
    {
        if (!$this->validate($this->rules)) {
            return $this->header() . view('suppliers/create', [
                'errores' => $this->validator->getErrors(), 'old' => $this->request->getPost()
            ]) . $this->footer();
        }
        (new SupplierModel())->save($this->request->getPost(['SupplierName','ContactName','Address','City','PostalCode','Country','Phone']));
        return redirect()->to('/suppliers')->with('mensaje', 'Proveedor registrado correctamente.');
    }

    public function editar($id = null)
    {
        $item = (new SupplierModel())->find($id);
        if (!$item) return redirect()->to('/suppliers')->with('mensaje', 'No encontrado.');
        return $this->header() . view('suppliers/editar', ['item'=>$item,'errores'=>[]]) . $this->footer();
    }

    public function update($id = null)
    {
        $model = new SupplierModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/suppliers');
        if (!$this->validate($this->rules)) {
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
