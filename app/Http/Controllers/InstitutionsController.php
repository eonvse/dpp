<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\institutions;
use App\Models\User;

class InstitutionsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function list()
    {
        return view('guide.institutions.list',['data' => institutions::leftJoin('users','users.id','=','institutions.idModerator')->select('institutions.*','users.name as user_name','users.email')->get()->sortBy('name')]);
    }

    public function create()
    {
        $users = User::role('teacher')->get()->sortBy('name');
        return view('guide.institutions.create',['users' => $users]);
    }

    public function store(Request $request)
    {
        institutions::create([
          'name' => $request->input('name'),
          'fullname' => $request->input('fullname'),
          'idModerator' => !empty($request->input('idModerator')) ? $request->input('idModerator') : NULL,
        ]);
        if (!empty($request->idModerator)) {
            $user = User::where('id',$request->idModerator)->first();
            $user->syncRoles('moderator');
        }
        return redirect('/guide/institutions');
    }

    public function edit(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = institutions::where('id', $id)->first();
        }

        $users = User::role('teacher')->orWhere('id',$data->idModerator)->get()->sortBy('name');

        return view('guide.institutions.edit', ['data' => $data, 'users' => $users]);
        //
    }

    public function update(Request $request)
    {

        $data = $request->all();
        $upd = institutions::find($request->id);
        $upd->name = $request->name;
        $upd->fullname = $request->fullname;
        $upd->idModerator = !empty($request->idModerator) ? $request->idModerator : NULL;

        $upd->save();

        if (!empty($request->idModerator)) {
            if (!empty($request->oldModerator)) {
                if ($request->idModerator != $request->oldModerator){
                    $user = User::where('id',$request->idModerator)->first();
                    $user->syncRoles('moderator');

                    $user = User::where('id',$request->oldModerator)->first();
                    $user->syncRoles('teacher');
                }
            }else{
                $user = User::where('id',$request->idModerator)->first();
                $user->syncRoles('moderator');
            }
        }elseif (!empty($request->oldModerator)) {
            $user = User::where('id',$request->oldModerator)->first();
            $user->syncRoles('teacher');
        }
        

        return redirect('/guide/institutions');

    }

    public function delete(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = institutions::where('id', $id)->first();
        }
        
        return view('guide.institutions.delete', ['data' => $data, 'moderator' => User::where('id', $data->idModerator)->first()]);
        //
    }

    public function deleteConfirm(Request $request)
    {
        $del = institutions::find($request->id);

        $del->delete();

        if (!empty($request->idModerator)) {
            $user = User::where('id',$request->idModerator)->first();
            $user->syncRoles('teacher');           
        }

        return redirect('/guide/institutions');        
    }
}
