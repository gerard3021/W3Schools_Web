<?php
namespace App\Controllers;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    private function header() { return view('layout/header'); }
    private function footer() { return '</main></body></html>'; }

    public function index()
    {
        $data['items'] = (new CategoryModel())->orderBy('CategoryID','DESC')->findAll();
        return $this->header() . view('categories/lista', $data) . $this->footer();
    }

    public function create()
    {
        return $this->header() . view('categories/create', ['errores'=>[],'old'=>[]]) . $this->footer();
    }

    public function store()
    {
        $rules = [
            'CategoryName' => 'required|min_length[2]|max_length[255]',
            'Description'  => 'required|min_length[3]|max_length[255]',
        ];
        if (!$this->validate($rules)) {
            return $this->header() . view('categories/create', [
                'errores' => $this->validator->getErrors(),
                'old'     => $this->request->getPost()
            ]) . $this->footer();
        }
        (new CategoryModel())->save([
            'CategoryName' => $this->request->getPost('CategoryName'),
            'Description'  => $this->request->getPost('Description'),
        ]);
        return redirect()->to('/categories')->with('mensaje', 'Categoría registrada correctamente.');
    }

    public function editar($id = null)
    {
        $item = (new CategoryModel())->find($id);
        if (!$item) return redirect()->to('/categories')->with('mensaje', 'No encontrado.');
        return $this->header() . view('categories/editar', ['item'=>$item,'errores'=>[]]) . $this->footer();
    }

    public function update($id = null)
    {
        $model = new CategoryModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/categories');
        $rules = [
            'CategoryName' => 'required|min_length[2]|max_length[255]',
            'Description'  => 'required|min_length[3]|max_length[255]',
        ];
        if (!$this->validate($rules)) {
            return $this->header() . view('categories/editar', [
                'item'    => array_merge($item, $this->request->getPost()),
                'errores' => $this->validator->getErrors()
            ]) . $this->footer();
        }
        $model->update($id, [
            'CategoryName' => $this->request->getPost('CategoryName'),
            'Description'  => $this->request->getPost('Description'),
        ]);
        return redirect()->to('/categories')->with('mensaje', 'Categoría actualizada correctamente.');
    }

    public function delete($id = null)
    {
        (new CategoryModel())->delete($id);
        return redirect()->to('/categories')->with('mensaje', 'Categoría eliminada.');
    }
}
