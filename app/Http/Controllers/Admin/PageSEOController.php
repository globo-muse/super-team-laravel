<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePageSEORequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageSEOController extends Controller
{

    public function __construct(private Page $repository)
    {}

    public function index()
    {
        $pages = $this->repository->all();
        return view('admin.pages.pages.index', ['pages' => $pages]);
    }

    public function create()
    {
        return view('admin.pages.pages.create');
    }

    public function store(StoreUpdatePageSEORequest $request)
    {
        $data = $request->all();
        
        if ($request->hasFile('image') && $request->image->isValid()) {
            // $rand = random_int(10000, 1000000);
            $data['image'] = $request->image->store("pages");
        }
        
        $page = $this->repository->create($data);

        if(!$page) {
            dd('error');
        }
        return redirect()->route('pages-seo.index');
    }

    public function show($id)
    {
        dd('NOT ACTION TO THIS');
    }

    public function edit($id)
    {
        $page = $this->repository->where('id', $id)->first();
        return view('admin.pages.pages.edit', ['page' => $page]);
    }

    public function update(Request $request, $id)
    {
        if (!$page = $this->repository->find($id)) {
            return redirect()->back();
        }

        $data = $request->all();

        if ($request->hasFile('image') && $request->image->isValid()) {

            if (Storage::exists($page->image)) {
                Storage::delete($page->image);
            }

            $data['image'] = $request->image->store("pages");
        }

        $page->update($data);

        return redirect()->route('pages-seo.index');
    }

    public function destroy($id)
    {
        $page = $this->repository->where('id', $id)->first();
        if(!$page) {
            dd('error, 404');
        }
        $page->destroy();
        return redirect()->route('pages-seo.index');
    }
}
