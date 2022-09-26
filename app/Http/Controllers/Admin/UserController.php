<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Models\Department;
use App\Models\User;
use App\Services\Email\Sendgrid\SendgridService;
use App\Services\Email\Sendgrid\TemplateData\UserCreatedTemplateData;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{

    // use CsvParse;

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
        
        if ($request->hasFile('image') && $request->image->isValid()) {
            $data['image'] = $request->image->store("users");
        }
        
        $data['password'] = bcrypt($data['password']);
        try {
            $user = $this->repository->create($data);

            //TODO: remove hard code
            SendgridService::send(
                'd-ab16489b51f84b6a861ca5b15e3b089b',
                $user->email,
                $user->name,
                UserCreatedTemplateData::transform($user, $request->password),
            );
            
            return redirect()->route('users.index')->with('message', 'cadastro efetuado com sucesso');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        } else {
            $data['password'] = bcrypt($data['password']);
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


    public function storeUserBatch(Request $request)
    {
        if(!$request->hasFile('users-list')) {
            return back()->with('error', 'need a .csv file');
        }

        $filePath = request()->file('users-list')->getPathname();

        if (($open = fopen($filePath, "r")) !== FALSE) {
            $success = [];
            $fail = [];
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                // $users[] = $data;
                // dd($data);
                $userLine = str_getcsv($data[0], ';');
                $password = Str::random(6);
                $dataUser = [
                    'name' => $userLine[0],
                    'department_id' => $userLine[1],
                    'email' => $userLine[2],
                    'password' => bcrypt($password),
                ];
                try {
                    $newUser = $this->repository->create($dataUser);
                    $success[] = $newUser;
                } catch (Exception $e) {
                    $fail[] = $userLine[2];
                }
            }
            if(!empty($fail)) {
                return back()->with('error', implode(', ', $fail));
            }
        }

        return back()->with('success', implode(', ', $success));
    }

    
    /**
     * 
     */
    private function departmentsToOption($departments)
    {
        $departmentsArray = [];
        foreach($departments as $department) {
            $departmentsArray[$department->id] = $department->name;
        }
        return $departmentsArray;
    }
}
