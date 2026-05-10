<?php
namespace App\Controllers;
use App\Models\ShipperModel;

class Shippers extends BaseController
{
    private function header() { return view('layout/header'); }
    private function footer() { return '</main></body></html>'; }

    private $rules = [
        'ShipperName' => 'required|min_length[2]|max_length[255]',
        'Phone'       => 'required|min_length[5]|max_length[50]',
    ];

    public function index()
    {
        $data['items'] = (new ShipperModel())->orderBy('ShipperID','DESC')->findAll();
        return $this->header() . view('shippers/lista', $data) . $this->footer();
    }

    public function create()
    {
        return $this->header() . view('shippers/create', ['errores'=>[],'old'=>[]]) . $this->footer();
    }

    public function store()
    {
        if (!$this->validate($this->rules)) {
            return $this->header() . view('shippers/create', [
                'errores' => $this->validator->getErrors(), 'old' => $this->request->getPost()
            ]) . $this->footer();
        }
        (new ShipperModel())->save($this->request->getPost(['ShipperName','Phone']));
        return redirect()->to('/shippers')->with('mensaje', 'Empresa de envío registrada correctamente.');
    }

    public function editar($id = null)
    {
        $item = (new ShipperModel())->find($id);
        if (!$item) return redirect()->to('/shippers')->with('mensaje', 'No encontrado.');
        return $this->header() . view('shippers/editar', ['item'=>$item,'errores'=>[]]) . $this->footer();
    }

    public function update($id = null)
    {
        $model = new ShipperModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/shippers');
        if (!$this->validate($this->rules)) {
            return $this->header() . view('shippers/editar', [
                'item'    => array_merge($item, $this->request->getPost()),
                'errores' => $this->validator->getErrors()
            ]) . $this->footer();
        }
        $model->update($id, $this->request->getPost(['ShipperName','Phone']));
        return redirect()->to('/shippers')->with('mensaje', 'Empresa de envío actualizada correctamente.');
    }

    public function delete($id = null)
    {
        (new ShipperModel())->delete($id);
        return redirect()->to('/shippers')->with('mensaje', 'Empresa de envío eliminada.');
    }
}
