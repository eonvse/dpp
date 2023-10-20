<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\courseDirections;

class CourseDirectionsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function list()
    {
        return view('guide.directions.list',['data' => courseDirections::all()->sortBy('name')]);

    }

    public function create()
    {
        return view('guide.directions.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        courseDirections::create($data);

        return redirect('/guide/directions');
    }

    public function edit(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = courseDirections::where('id', $id)->first();
        }

        return view('guide.directions.edit', ['data' => $data]);
        //
    }

    public function update(Request $request)
    {

        $data = $request->all();
        $upd = courseDirections::find($request->id);
        $upd->name = $request->name;

        $upd->save();
        

        return redirect('/guide/directions');

    }

    public function delete(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = courseDirections::where('id', $id)->first();
        }
        return view('guide.directions.delete', ['data' => $data]);
        //
    }

    public function deleteConfirm(Request $request)
    {
        $del = courseDirections::find($request->id);

        $del->delete();

        return redirect('/guide/directions');        
    }
}
