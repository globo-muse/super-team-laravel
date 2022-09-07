<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected User $repository;
    
    public function __construct(User $user)
    {
        $this->repository = $user;
    }


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
        return view('admin.pages.users.create');
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
        return view('admin.pages.users.edit', ['user' => $user]);
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
}
