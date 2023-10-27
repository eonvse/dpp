<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\teachers;
use App\Models\User;
use App\Models\positions;
use App\Models\institutions;

use App\Exports\PersonalExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;


class TeachersController extends Controller
{
    //
    private $ItemCountPage = 20; //Количество записей на страницу

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function list(Request $request)
    {

        $data = new teachers;
        $user = Auth::user();
        $teacher = '';

        $fIdTeachers = $request->fIdTeachers;
        if (!empty($fIdTeachers)) {
            $data = $data->where('id', '=', $fIdTeachers);
            $teacher = teachers::where('id','=',$fIdTeachers)->first();
        }           
        
        $fSurname = $request->fSurname;
        if (!empty($fSurname)) {
            $data = $data->where('surname', 'like', '%'.$fSurname.'%');
        }
        
        $fidInstitution = '';
        if (!empty($user->hasRole('admin'))) { 
            $fidInstitution = $request->fidInstitution;
            if (!empty($fidInstitution)) {
                $data = $data->where('idInstitutions', '=', $fidInstitution);
            }
        }else{
            if (!empty($user->moderatorInstitution->id)) {
                $data = $data->where('idInstitutions', '=', $user->moderatorInstitution->id);  
            }
        }
        
        $fidPosition = $request->fidPosition;
        if (!empty($fidPosition)) {
            $data = $data->where('idPositions', '=', $fidPosition);
        } 
        
        $data = $data->sortable(['surname'])
                    ->paginate($this->ItemCountPage)->withQueryString();

        $positions = positions::all()->sortBy('name');
        if (!empty($user->hasRole('admin'))) { 
            $institutions = institutions::all()->sortBy('name');
        }else{
            $institutions = institutions::where('id','=',$user->moderatorInstitution->id)->get();
        }

        $guides = ['positions'=>$positions,'institutions'=>$institutions];

        $filter = ['fIdTeachers'=>$fIdTeachers,'teacher'=>$teacher,'fSurname'=>$fSurname,'fidInstitution'=>$fidInstitution,'fidPosition'=>$fidPosition];

        return view('teachers.list',['data' => $data, 'filter' => $filter, 'guides' => $guides]);
    }

    public function create()
    {
        $users = User::whereNotIn('id',teachers::select('idUser')->where('idUser','>',0))->get()->sortBy('name');
        $positions = positions::all()->sortBy('name');
        $institutions = institutions::all()->sortBy('name');
        return view('teachers.create', ['users' => $users,
                                        'positions' => $positions,
                                        'institutions' => $institutions]);
    }


    public function store(Request $request)
    {
        teachers::create([
          'name' => $request->name,
          'surname' => $request->surname,
          'patronymic' => !empty($request->patronymic) ? $request->patronymic : NULL,
          'idPositions' => $request->idPositions,
          'idInstitutions' => $request->idInstitutions,
          'idType' => $request->idType ?? 0,
          'dateDoc' => !empty($request->dateDoc) ? $request->dateDoc : NULL,
          'idUser' => $request->idUser,
          'idAutor' => Auth::user()->id,
          'idUpdater' => Auth::user()->id,
        ]);

        return redirect('teachers');
    }

    public function edit(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = teachers::where('id', $id)->first();
        }

        $users = User::whereNotIn('id',teachers::select('idUser')->where('idUser','>',0))->orWhere('id','=',$data->idUser)->get()->sortBy('name');
        $positions = positions::all()->sortBy('name');
        $institutions = institutions::all()->sortBy('name');


        return view('teachers.edit',   ['data' => $data, 
                                        'users' => $users,
                                        'positions' => $positions, 
                                        'institutions' => $institutions]);
        //
    }

    public function update(Request $request)
    {

        $data = $request->all();
        $upd = teachers::find($request->id);
        $upd->name = $request->name;
        $upd->surname = $request->surname;
        $upd->patronymic = !empty($request->patronymic) ? $request->patronymic : NULL;
        $upd->idPositions = $request->idPositions;
        $upd->idInstitutions = $request->idInstitutions;
        $upd->idType = $request->idType ?? 0;
        $upd->dateDoc = !empty($request->dateDoc) ? $request->dateDoc : NULL;
        $upd->idUser = $request->idUser;
        $upd->idUpdater = Auth::user()->id;

        $upd->save();

        return redirect('teachers');

    }

    public function delete(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = teachers::where('id', $id)->first();
            $institutions = institutions::where('id','=',$data->idInstitutions)->get('name')->first();
            $positions = positions::where('id','=',$data->idPositions)->get('name')->first();
        }
        
        return view('teachers.delete', ['data' => $data, 
                                        'institutions' => $institutions,
                                        'positions' => $positions]);
        //
    }

    public function deleteConfirm(Request $request)
    {
        $del = teachers::find($request->id);
        $del->delete();

        /*if (!empty($request->idUser)) {
            $del = User::find($request->idUser);
            $del->delete();
        }*/

        return redirect('teachers');        
    }

   /*
    public function personal()
    {
        
        $data = Auth::user()->teacher; 

        return view('teachers.personal.view',['data' => $data]);

    }

    public function personalEdit()
    {
        $id = Auth::user()->id;
        $data = teachers::where('idUser', $id)->first();
        if (empty($data)) { $data=[]; }
        $positions = positions::all()->sortBy('name');
        $institutions = institutions::all()->sortBy('name');
        $types = typeDocs::all()->sortBy('name');

        return view('teachers.personal.edit',  ['data' => $data, 
                                                'positions' => $positions, 
                                                'institutions' => $institutions, 
                                                'types' => $types]);
        //
    }


    public function personalStore(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $surname = $request->surname;
        $patronymic = !empty($request->patronymic) ? $request->patronymic : NULL;
        $idPositions = $request->idPositions;
        $idInstitutions = $request->idInstitutions;
        $idType = $request->idType;
        $dateDoc = !empty($request->dateDoc) ? $request->dateDoc : NULL;
        $idUser = $request->idUser;
        $idAutor = Auth::user()->id;
        $idUpdater = Auth::user()->id;
        if (empty($id)) {  
            teachers::create([
              'name' => $name,
              'surname' => $surname,
              'patronymic' => $patronymic,
              'idPositions' => $idPositions,
              'idInstitutions' => $idInstitutions,
              'idType' => $idType,
              'dateDoc' => $dateDoc,
              'idUser' => $idUser,
              'idAutor' => Auth::user()->id,
              'idUpdater' => Auth::user()->id,
            ]);
        }else{
            $upd = teachers::find($request->id);
            $upd->name = $name;
            $upd->surname = $surname;
            $upd->patronymic = $patronymic;
            $upd->idPositions = $idPositions;
            $upd->idInstitutions = $idInstitutions;
            $upd->idType = $idType;
            $upd->dateDoc = $dateDoc;
            $upd->idUpdater = Auth::user()->id;

            $upd->save();
        }

        return redirect('personal');
    }*/

    public function personalExport() 
    {

        return Excel::download(new PersonalExport,'АИС Мониторинг освоения ДПП - Персональные курсы '.date('d-m-Y hi').'.xlsx');
    }

    public function usersList(Request $request)
    {

        return view('teachers.users.list');
    }

    public function moderatorUpdate(Request $request) {
        
        $upd = institutions::find($request->id);
        $upd->idModerator = $request->idModerator;

        $upd->save();

        $user = User::where('id',$request->idModerator)->first();
        $user->syncRoles('moderator');
        $user = User::where('id',$request->oldModerator)->first();
        $user->syncRoles('teacher');
        
        return redirect ('users');

    }

    public function moderatorAdd(Request $request) {
        

        $upd = institutions::find($request->id);
        $upd->idModerator = $request->idModerator;

        $upd->save();

        $user = User::where('id',$request->idModerator)->first();
        $user->syncRoles('moderator');
        
        return redirect ('users');

    }

    public function moderatorDel(Request $request)
    {
        $upd = institutions::find($request->id);
        $idModerator = $upd->idModerator;
        $upd->idModerator = NULL;

        $upd->save();

        $user = User::where('id',$idModerator)->first();
        $user->syncRoles('teacher');
        
        return redirect ('users'); 
    }

    public function usersAddMod(Request $request) {
        

        return view('teachers.users.create',['teachers'=>teachers::where('id', $request->teachers)->first()]);

    }

    public function usersAdd(Request $request) {
        

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->addPassword),
            'isAgreement' => 1,
        ]);

        $user->assignRole('teacher');

        event(new Registered($user));

        if (!empty($request->idTeachers)){
            $newUser=User::where('email', $request->email)->first();
            $upd = teachers::find($request->idTeachers);
            $upd->idUser = $newUser->id;

            $upd->save();

            return redirect ('teachers');

        }
        
        return redirect ('users');

    }

    public function userUpdate(Request $request, $idUser)
    {
        $upd = User::find($idUser);
        $upd->name = $request->name;
        $upd->email = $request->email;
        $upd->save();
        return redirect ('users');
    }

    public function personalAdd(Request $request, $idUser)
    {

        $user = User::where('id','=',$idUser)->first();
        $positions = positions::all()->sortBy('name');
        $institutions = institutions::all()->sortBy('name');

        return view('teachers.users.add-personal',['user' => $user,'institutions' => $institutions, 'positions' => $positions]);
    }

    public function personalStore(Request $request) {
        
        $name = $request->name;
        $surname = $request->surname;
        $patronymic = !empty($request->patronymic) ? $request->patronymic : NULL;
        $idPositions = $request->idPositions;
        $idInstitutions = $request->idInstitutions;
        $idUser = $request->idUser;
        $idAutor = Auth::user()->id;
        $idUpdater = Auth::user()->id;
        teachers::create([
          'name' => $name,
          'surname' => $surname,
          'patronymic' => $patronymic,
          'idPositions' => $idPositions,
          'idInstitutions' => $idInstitutions,
          'idUser' => $idUser,
          'idAutor' => Auth::user()->id,
          'idUpdater' => Auth::user()->id,
        ]);

        return redirect ('users');

    }
}

