<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateDepartment;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(private Department $repository)
    {}

    public function index()
    {
        $items = $this->repository->all();
        return view('admin.pages.departments.index', ['items' => $items]);
    }

    public function create()
    {
        return view('admin.pages.departments.create');
    }

    public function store(StoreUpdateDepartment $request)
    {
        if(!$this->repository->create($request->all())) {
            return redirect()->route('departments.index')->with('error', 'Erro no cadastro');
        }
        return redirect()->route('departments.index')->with('success', 'Cadastro efetuado com sucesso');
    }

    public function show($id)
    {
        dd('Method not implemented to this controller');
    }

    public function edit($id)
    {
        $deparment = $this->repository->find($id);
        return view('admin.pages.departments.edit', ['item' => $deparment]);
    }

    public function update(StoreUpdateDepartment $request, $id)
    {
        $deparment = $this->repository->find($id);
        $deparment->fill($request->all());
        $deparment->save();
        return redirect()->route('departments.index')->with('success', 'Edição efetuada com sucesso');
    }

    public function destroy($id)
    {
        $deparment = $this->repository->find($id);
        if(!$deparment->delete()) {
            return redirect()->route('departments.index')->with('error', 'Erro na exclusão');
        }
        return redirect()->route('departments.index')->with('success', 'Exclusão efetuada com sucesso');
    }
}
