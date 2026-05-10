<?php
namespace App\Controllers;
use App\Models\EmployeeModel;

class Employees extends BaseController
{
    private function header() { return view('layout/header'); }
    private function footer() { return '</main></body></html>'; }

    private string $uploadPath = FCPATH . 'uploads/';

    private function subirFoto(): string|null
    {
        $foto = $this->request->getFile('Photo');
        if (!$foto || !$foto->isValid() || $foto->hasMoved()) {
            return null;
        }
        $nombre = time() . '_' . $foto->getRandomName();
        $foto->move($this->uploadPath, $nombre);
        return $nombre;
    }

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
        $rules = [
            'LastName'  => 'required|min_length[2]|max_length[255]',
            'FirstName' => 'required|min_length[2]|max_length[255]',
            'BirthDate' => 'required|valid_date',
            'Photo'     => 'is_image[Photo]',
        ];
        if (!$this->validate($rules)) {
            return $this->header() . view('employees/create', [
                'errores' => $this->validator->getErrors(),
                'old'     => $this->request->getPost()
            ]) . $this->footer();
        }
        $nombreFoto = $this->subirFoto();
        (new EmployeeModel())->save([
            'LastName'  => $this->request->getPost('LastName'),
            'FirstName' => $this->request->getPost('FirstName'),
            'BirthDate' => $this->request->getPost('BirthDate'),
            'Notes'     => $this->request->getPost('Notes'),
            'Photo'     => $nombreFoto,
        ]);
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

        $foto = $this->request->getFile('Photo');
        $hayFotoNueva = $foto && $foto->isValid() && !$foto->hasMoved();

        $rules = [
            'LastName'  => 'required|min_length[2]|max_length[255]',
            'FirstName' => 'required|min_length[2]|max_length[255]',
            'BirthDate' => 'required|valid_date',
        ];
        if ($hayFotoNueva) {
            $rules['Photo'] = 'is_image[Photo]|max_size[Photo,2048]';
        }

        if (!$this->validate($rules)) {
            return $this->header() . view('employees/editar', [
                'item'    => array_merge($item, $this->request->getPost()),
                'errores' => $this->validator->getErrors()
            ]) . $this->footer();
        }

        $datos = [
            'LastName'  => $this->request->getPost('LastName'),
            'FirstName' => $this->request->getPost('FirstName'),
            'BirthDate' => $this->request->getPost('BirthDate'),
            'Notes'     => $this->request->getPost('Notes'),
        ];

        if ($hayFotoNueva) {
            if (!empty($item['Photo']) && file_exists($this->uploadPath . $item['Photo'])) {
                unlink($this->uploadPath . $item['Photo']);
            }
            $datos['Photo'] = $this->subirFoto();
        }

        $model->update($id, $datos);
        return redirect()->to('/employees')->with('mensaje', 'Empleado actualizado correctamente.');
    }

    public function delete($id = null)
    {
        $item = (new EmployeeModel())->find($id);
        if ($item && !empty($item['Photo']) && file_exists($this->uploadPath . $item['Photo'])) {
            unlink($this->uploadPath . $item['Photo']);
        }
        (new EmployeeModel())->delete($id);
        return redirect()->to('/employees')->with('mensaje', 'Empleado eliminado.');
    }
}
