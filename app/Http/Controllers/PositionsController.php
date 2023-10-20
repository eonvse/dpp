<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\positions;

class PositionsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function list()
    {
        return view('guide.positions.list',['data' => positions::all()->sortBy('name')]);
    }

    public function create()
    {
        return view('guide.positions.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        positions::create($data);

        return redirect('/guide/positions');
    }

    public function edit(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = positions::where('id', $id)->first();
        }

        return view('guide.positions.edit', ['data' => $data]);
        //
    }

    public function update(Request $request)
    {

        $data = $request->all();
        $upd = positions::find($request->id);
        $upd->name = $request->name;

        $upd->save();
        

        return redirect('/guide/positions');

    }

    public function delete(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = positions::where('id', $id)->first();
        }
        return view('guide.positions.delete', ['data' => $data]);
        //
    }

    public function deleteConfirm(Request $request)
    {
        $del = positions::find($request->id);

        $del->delete();

        return redirect('/guide/positions');        
    }


}
