<?php
namespace App\Controllers;
use App\Models\EmployeeModel;

class Employees extends BaseController
{
    private function header() { return view('layout/header'); }
    private function footer() { return '</main></body></html>'; }

    public function index()
    {
        $data['items'] = (new EmployeeModel())->orderBy('EmployeeID','DESC')->findAll();
        return $this->header() . view('employees/lista', $data) . $this->footer();
    }

    public function create()
    {
        return $this->header() . view('employees/create', ['errores'=>[],'old'=>[]]) . $this->footer();
    }

    public function store()
    {
        $rules = ['LastName'=>'required|max_length[255]','FirstName'=>'required|max_length[255]'];
        if (!$this->validate($rules)) {
            return $this->header() . view('employees/create', [
                'errores'=>$this->validator->getErrors(),'old'=>$this->request->getPost()
            ]) . $this->footer();
        }
        (new EmployeeModel())->save($this->request->getPost(['LastName','FirstName','BirthDate','Photo','Notes']));
        return redirect()->to('/employees')->with('mensaje', 'Empleado registrado correctamente.');
    }

    public function editar($id = null)
    {
        $item = (new EmployeeModel())->find($id);
        if (!$item) return redirect()->to('/employees')->with('mensaje', 'No encontrado.');
        return $this->header() . view('employees/editar', ['item'=>$item,'errores'=>[]]) . $this->footer();
    }

    public function update($id = null)
    {
        $model = new EmployeeModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/employees');
        $rules = ['LastName'=>'required|max_length[255]','FirstName'=>'required|max_length[255]'];
        if (!$this->validate($rules)) {
            return $this->header() . view('employees/editar', [
                'item'    => array_merge($item, $this->request->getPost()),
                'errores' => $this->validator->getErrors()
            ]) . $this->footer();
        }
        $model->update($id, $this->request->getPost(['LastName','FirstName','BirthDate','Photo','Notes']));
        return redirect()->to('/employees')->with('mensaje', 'Empleado actualizado correctamente.');
    }

    public function delete($id = null)
    {
        (new EmployeeModel())->delete($id);
        return redirect()->to('/employees')->with('mensaje', 'Empleado eliminado.');
    }
}
