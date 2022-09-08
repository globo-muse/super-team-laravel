<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct(
        private User $repository,
        private Department $department
    )
    {}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->repository->paginate();

        return view('admin.pages.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = $this->departmentsToOption($this->department->all());
        return view('admin.pages.users.create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        if(!$this->repository->create($data)) {
            return redirect()->back()->with('error', 'Erro no cadastro, tente novamente');
        }

        if ($request->hasFile('image') && $request->image->isValid()) {
            $data['image'] = $request->image->store("users");
        }

        return redirect()->route('users.index')->with('message', 'cadastro efetuado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->back()->with('info', 'Show não é um metodo válido esse controller');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$user = $this->repository->find($id)) {
            return redirect()->back()->with('Usuário não encontrado');
        }
        $departments = $this->departmentsToOption($this->department->all());
        return view('admin.pages.users.edit', ['user' => $user, 'departments' => $departments ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateUserRequest $request, $id)
    {
        if(!$user = $this->repository->find($id)) {
            return redirect()->route('users.index')->with('error', 'Usuário não encontrado');
        }
        $data = $request->all();
        if(empty($data['password'])) {
            unset($data['password']);
        }

        if ($request->hasFile('image') && $request->image->isValid()) {

            if (!empty($user->image) && Storage::exists($user->image)) {
                Storage::delete($user->image);
            }

            $data['image'] = $request->image->store("users");
        }

        $user->update($data);
        return redirect()->route('users.index')->with('message', 'Usuário editado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$user = $this->repository->find($id)) {
            return redirect()->route('users.index')->with('error', 'Usuário não encontrado');
        }
        $user->delete();
        return redirect()->route('users.index')->with('message', 'Usuário removido com sucesso');
    }

    private function departmentsToOption($departments)
    {
        $departmentsArray = [];
        foreach($departments as $department) {
            $departmentsArray[$department->id] = $department->name;
        }
        return $departmentsArray;
    }
}
