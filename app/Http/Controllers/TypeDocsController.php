<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\typeDocs;

class TypeDocsController extends Controller
{
    //
    //
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function list()
    {
        return view('guide.types.list',['data' => typeDocs::all()->sortBy('name')]);
    }

    public function create()
    {
        return view('guide.types.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        typeDocs::create($data);

        return redirect('/guide/types');
    }

    public function edit(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = typeDocs::where('id', $id)->first();
        }

        return view('guide.types.edit', ['data' => $data]);
        //
    }

    public function update(Request $request)
    {

        $data = $request->all();
        $upd = typeDocs::find($request->id);
        $upd->name = $request->name;

        $upd->save();
        

        return redirect('/guide/types');

    }

    public function delete(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = typeDocs::where('id', $id)->first();
        }
        return view('guide.types.delete', ['data' => $data]);
        //
    }

    public function deleteConfirm(Request $request)
    {
        $del = typeDocs::find($request->id);

        $del->delete();

        return redirect('/guide/types');        
    }
}
