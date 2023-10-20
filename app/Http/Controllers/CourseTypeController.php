<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\courseType;

class CourseTypeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function list()
    {
        return view('guide.courseTypes.list',['data' => courseType::all()->sortBy('name')]);
    }

    public function create()
    {
        return view('guide.courseTypes.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        courseType::create($data);

        return redirect('/guide/courseTypes');
    }

    public function edit(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = courseType::where('id', $id)->first();
        }

        return view('guide.courseTypes.edit', ['data' => $data]);
        //
    }

    public function update(Request $request)
    {

        $data = $request->all();
        $upd = courseType::find($request->id);
        $upd->name = $request->name;

        $upd->save();
        

        return redirect('/guide/courseTypes');

    }

    public function delete(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = courseType::where('id', $id)->first();
        }
        return view('guide.courseTypes.delete', ['data' => $data]);
        //
    }

    public function deleteConfirm(Request $request)
    {
        $del = courseType::find($request->id);

        $del->delete();

        return redirect('/guide/courseTypes');        
    }

}
