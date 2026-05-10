<?php
namespace App\Controllers;
use App\Models\CustomerModel;

class Customers extends BaseController
{
    private function header() { return view('layout/header'); }
    private function footer() { return '</main></body></html>'; }

    private $rules = [
        'CustomerName' => 'required|min_length[2]|max_length[255]',
        'ContactName'  => 'required|min_length[2]|max_length[255]',
        'Address'      => 'required|min_length[3]|max_length[255]',
        'City'         => 'required|min_length[2]|max_length[255]',
        'PostalCode'   => 'required|max_length[20]',
        'Country'      => 'required|min_length[2]|max_length[255]',
    ];

    public function index()
    {
        $data['items'] = (new CustomerModel())->orderBy('CustomerID','DESC')->findAll();
        return $this->header() . view('customers/lista', $data) . $this->footer();
    }

    public function create()
    {
        return $this->header() . view('customers/create', ['errores'=>[],'old'=>[]]) . $this->footer();
    }

    public function store()
    {
        if (!$this->validate($this->rules)) {
            return $this->header() . view('customers/create', [
                'errores' => $this->validator->getErrors(), 'old' => $this->request->getPost()
            ]) . $this->footer();
        }
        (new CustomerModel())->save($this->request->getPost(['CustomerName','ContactName','Address','City','PostalCode','Country']));
        return redirect()->to('/customers')->with('mensaje', 'Cliente registrado correctamente.');
    }

    public function editar($id = null)
    {
        $item = (new CustomerModel())->find($id);
        if (!$item) return redirect()->to('/customers')->with('mensaje', 'No encontrado.');
        return $this->header() . view('customers/editar', ['item'=>$item,'errores'=>[]]) . $this->footer();
    }

    public function update($id = null)
    {
        $model = new CustomerModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/customers');
        if (!$this->validate($this->rules)) {
            return $this->header() . view('customers/editar', [
                'item'    => array_merge($item, $this->request->getPost()),
                'errores' => $this->validator->getErrors()
            ]) . $this->footer();
        }
        $model->update($id, $this->request->getPost(['CustomerName','ContactName','Address','City','PostalCode','Country']));
        return redirect()->to('/customers')->with('mensaje', 'Cliente actualizado correctamente.');
    }

    public function delete($id = null)
    {
        (new CustomerModel())->delete($id);
        return redirect()->to('/customers')->with('mensaje', 'Cliente eliminado.');
    }
}
