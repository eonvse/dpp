<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Models\teachers;

use App\Models\User;

use App\Models\courses;
use App\Models\courseType;
use App\Models\courseDirections;
use App\Models\typeDocs;

class CoursesController extends Controller
{
    //
    private $ItemCountPage = 20; //Количество записей на страницу

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function personal(Request $request)
    {

        if (empty(Auth::user()->teacher)) {
            return Redirect::route('profile.edit')->with('status', 'personal-empty');
        }else{
            $data = Auth::user()->teacher->courses();
            $fСourseType = $request->fСourseType;
            if (!empty($fСourseType)) {
                $data = $data->where('idType', '=', $fСourseType);
            }            
            $fDocType = $request->fDocType;
            if (!empty($fDocType)) {
                $data = $data->where('idTypeDoc', '=', $fDocType);
            }            
            $fIsFederal = $request->fIsFederal;
            if (!empty($fIsFederal)) {
                $data = $data->where('isFederal', '=', $fIsFederal-1);
            } 
            $fDateDocStart = $request->fDateDocStart;
            $fDateDocEnd = $request->fDateDocEnd;
            if (!empty($fDateDocStart)) {
                $data = $data->where('dateDoc', '>=', $fDateDocStart);

            }
            if (!empty($fDateDocEnd)) {
                $data = $data->where('dateDoc', '<=', $fDateDocEnd);
            } 
            $fCourseDirections = $request->fCourseDirections;
            if (!empty($fCourseDirections)) {
                $data = $data->where('idDirections', '=', $fCourseDirections);
            } 
            $fDateUpdStart = $request->fDateUpdStart;
            $fDateUpdEnd = $request->fDateUpdEnd;
            if (!empty($fDateUpdStart)) {
                $data = $data->where('updated_at', '>=', $fDateUpdStart);
            }
            if (!empty($fDateUpdEnd)) {
                $data = $data->where('updated_at', '<=', $fDateUpdEnd);
            } 
                
            $data = $data->sortable(['fullName'])
                         ->paginate($this->ItemCountPage)->withQueryString();            

            $guides = ['courseType'=>courseType::all()->sortBy('name'),'courseDirections'=>courseDirections::all()->sortBy('name'), 'docType'=>typeDocs::all()->sortBy('name')];

            $filter = ['fСourseType'=>$fСourseType,'fIsFederal'=>$fIsFederal,'fDateDocStart'=>$fDateDocStart,'fDateDocEnd'=>$fDateDocEnd,'fCourseDirections'=>$fCourseDirections,'fDateUpdStart'=>$fDateUpdStart,'fDateUpdEnd'=>$fDateUpdEnd, 'fDocType'=>$fDocType];

            return view('courses.personal.view',['data' => $data, 'filter' => $filter, 'guides' => $guides]);
        }

    }

    public function personalCreate()
    {
        $idTeachers = Auth::user()->teacher->id;
        $directions = courseDirections::all()->sortBy('name');
        $types = courseType::all()->sortBy('name');
        $typeDoc = typeDocs::all()->sortBy('name');
        $nameList = courses::select('fullName')->where('idTeachers','=',$idTeachers)->distinct()->get();

        return view('courses.personal.create', ['idTeachers' => $idTeachers,
                                                'directions' => $directions,
                                                'types' => $types,
                                                'typeDoc' => $typeDoc,
                                                'nameList' => $nameList]);
    }

    public function personalStore(Request $request)
    {
        
        if (empty($request->id))
            courses::create([
              'fullName' => $request->fullName,
              'progName' => $request->progName,
              'hours' => !empty($request->hours) ? $request->hours : 0,
              'isFederal' => !empty($request->isFederal) ? $request->isFederal : 0,
              'idDirections' => !empty($request->idDirections) ? $request->idDirections : 0,
              'idType' => !empty($request->idType) ? $request->idType : 0,
              'idTypeDoc' => !empty($request->idTypeDoc) ? $request->idTypeDoc : 0,
              'dateDoc' => !empty($request->dateDoc) ? $request->dateDoc : NULL,
              'idTeachers' => $request->idTeachers,
              'idAutor' => Auth::user()->id,
              'idUpdater' => Auth::user()->id,
            ]);
        else {
            
            $data = $request->all();
            $upd = courses::find($request->id);
            $upd->fullName = $request->fullName;
            $upd->progName = $request->progName;
            $upd->hours = !empty($request->hours) ? $request->hours : 0;
            $upd->isFederal = !empty($request->isFederal) ? $request->isFederal : 0;
            $upd->idDirections = !empty($request->idDirections) ? $request->idDirections : 0;
            $upd->idType = !empty($request->idType) ? $request->idType : 0;
            $upd->idTypeDoc = !empty($request->idTypeDoc) ? $request->idTypeDoc : 0;
            $upd->dateDoc = !empty($request->dateDoc) ? $request->dateDoc : NULL;
            $upd->idTeachers = $request->idTeachers;
            $upd->idUpdater = Auth::user()->id;

            $upd->save();
        }
        return redirect('/personal/courses/');
    }

    public function personalEdit(Request $request, $id)
    {
        $data =[];
        if ($id>0) {
            $data = courses::where('id', $id)->first();
        }

        $directions = courseDirections::all()->sortBy('name');
        $types = courseType::all()->sortBy('name');
        $typeDoc = typeDocs::all()->sortBy('name');

        return view('courses.personal.edit',   ['data' => $data, 
                                        'directions' => $directions,
                                        'types' => $types,
                                        'typeDoc' => $typeDoc]);
        //
    }

    public function personalDel(Request $request, $id)
    {
        $data =[];
        if ($id>0) $data = courses::where('id', $id)->first();
        
        return view('courses.personal.delete', ['data' => $data]);
        //
    }

    public function personalDelConfirm(Request $request)
    {
        $del = courses::find($request->id);
        $del->delete();

        return redirect('/personal/courses');        
    }

    public function list(Request $request)
    {

        $data = new courses;
        $user = Auth::user();
        $teacher = '';

        $fIdTeachers = $request->fIdTeachers;
        if (!empty($fIdTeachers)) {
            $data = $data->where('idTeachers', '=', $fIdTeachers);
            $teacher = teachers::where('id','=',$fIdTeachers)->first();
        } 
        $teachersList = '';
        if (!empty($user->moderatorInstitution->id)) {
               $teachersList = DB::table('teachers')->where('idInstitutions','=',$user->moderatorInstitution->id)->pluck('id')->toArray();
               $data = $data->whereIn('idTeachers', $teachersList);  
        }

        $fСourseType = $request->fСourseType;
        if (!empty($fСourseType)) {
            $data = $data->where('idType', '=', $fСourseType);
        }            
        $fDocType = $request->fDocType;
        if (!empty($fDocType)) {
            $data = $data->where('idTypeDoc', '=', $fDocType);
        }            
        $fIsFederal = $request->fIsFederal;
        if (!empty($fIsFederal)) {
            $data = $data->where('isFederal', '=', $fIsFederal-1);
        } 
        $fDateDocStart = $request->fDateDocStart;
        $fDateDocEnd = $request->fDateDocEnd;
        if (!empty($fDateDocStart)) {
            $data = $data->where('dateDoc', '>=', $fDateDocStart);
        }
        if (!empty($fDateDocEnd)) {
            $data = $data->where('dateDoc', '<=', $fDateDocEnd);
        } 
        $fCourseDirections = $request->fCourseDirections;
        if (!empty($fCourseDirections)) {
            $data = $data->where('idDirections', '=', $fCourseDirections);
        }
        $fDateUpdStart = $request->fDateUpdStart;
        $fDateUpdEnd = $request->fDateUpdEnd;
        if (!empty($fDateUpdStart)) {
            $data = $data->where('updated_at', '>=', $fDateUpdStart);
        }
        if (!empty($fDateUpdEnd)) {
            $data = $data->where('updated_at', '<=', $fDateUpdEnd);
        } 
        
        $data = $data->sortable(['fullName'])
                     ->paginate($this->ItemCountPage)->withQueryString();            

        $guides = ['courseType'=>courseType::all()->sortBy('name'),'courseDirections'=>courseDirections::all()->sortBy('name'), 'docType'=>typeDocs::all()->sortBy('name')];

        $filter = ['fIdTeachers'=>$fIdTeachers,'teacher'=>$teacher,'fСourseType'=>$fСourseType,'fIsFederal'=>$fIsFederal,'fDateDocStart'=>$fDateDocStart,'fDateDocEnd'=>$fDateDocEnd,'fCourseDirections'=>$fCourseDirections,'fDateUpdStart'=>$fDateUpdStart,'fDateUpdEnd'=>$fDateUpdEnd, 'fDocType'=>$fDocType ];

        return view('courses.list',['data' => $data, 'filter' => $filter, 'guides' => $guides]);

    }

    public function create(Request $request)
    {
        $fIdTeachers= empty($request->fIdTeachers) ? '' : $request->fIdTeachers;

        if (!empty($fIdTeachers)){
            $teachers = teachers::where('id', $fIdTeachers)->first();
        }elseif (!empty(Auth::user()->moderatorInstitution->id)) {
            $teachersList = DB::table('teachers')->where('idInstitutions','=',Auth::user()->moderatorInstitution->id)->pluck('id')->toArray();
            $teachers = teachers::whereIn('id', $teachersList)->get()->sortBy('surname')->sortBy('name')->sortBy('patronymic'); 
        }else{
            $teachers = teachers::all()->sortBy('surname')->sortBy('name')->sortBy('patronymic');
        } 
        
        $directions = courseDirections::all()->sortBy('name');
        $types = courseType::all()->sortBy('name');
        $typeDoc = typeDocs::all()->sortBy('name');
        $nameList = courses::select('fullName')->distinct()->get();

        return view('courses.create', ['teachers' => $teachers,
                                                'directions' => $directions,
                                                'types' => $types,
                                                'typeDoc' => $typeDoc,
                                                'nameList' => $nameList,
                                                'fIdTeachers' => $fIdTeachers
                                            ]);
    }

    public function store(Request $request)
    {
        
        if (empty($request->id))
            courses::create([
              'fullName' => $request->fullName,
              'progName' => $request->progName,
              'hours' => !empty($request->hours) ? $request->hours : 0,
              'isFederal' => !empty($request->isFederal) ? $request->isFederal : 0,
              'idDirections' => !empty($request->idDirections) ? $request->idDirections : 0,
              'idType' => !empty($request->idType) ? $request->idType : 0,
              'idTypeDoc' => !empty($request->idTypeDoc) ? $request->idTypeDoc : 0,
              'dateDoc' => !empty($request->dateDoc) ? $request->dateDoc : NULL,
              'idTeachers' => $request->idTeachers,
              'idAutor' => Auth::user()->id,
              'idUpdater' => Auth::user()->id,
            ]);
        else {
            
            $data = $request->all();
            $upd = courses::find($request->id);
            $upd->fullName = $request->fullName;
            $upd->progName = $request->progName;
            $upd->hours = !empty($request->hours) ? $request->hours : 0;
            $upd->isFederal = !empty($request->isFederal) ? $request->isFederal : 0;
            $upd->idDirections = !empty($request->idDirections) ? $request->idDirections : 0;
            $upd->idType = !empty($request->idType) ? $request->idType : 0;
            $upd->idTypeDoc = !empty($request->idTypeDoc) ? $request->idTypeDoc : 0;
            $upd->dateDoc = !empty($request->dateDoc) ? $request->dateDoc : NULL;
            $upd->idTeachers = $request->idTeachers;
            $upd->idUpdater = Auth::user()->id;

            $upd->save();
        }
        
        if (empty($request->fIdTeachers)) return redirect('/courses/');
        else return redirect('/courses?fIdTeachers='.$request->fIdTeachers);
    }

    public function edit(Request $request, $id, $idTeachers)
    {
        $data =[];
        if ($id>0) {
            $data = courses::where('id', $id)->first();
        }

        if (!empty($fIdTeachers)){
            $teachers = teachers::where('id', $fIdTeachers)->first();
        }elseif (!empty(Auth::user()->moderatorInstitution->id)) {
            $teachersList = DB::table('teachers')->where('idInstitutions','=',Auth::user()->moderatorInstitution->id)->pluck('id')->toArray();
            $teachers = teachers::whereIn('id', $teachersList)->get()->sortBy('surname')->sortBy('name')->sortBy('patronymic'); 
        }else{
            $teachers = teachers::all()->sortBy('surname')->sortBy('name')->sortBy('patronymic');
        } 

        $directions = courseDirections::all()->sortBy('name');
        $types = courseType::all()->sortBy('name');
        $typeDoc = typeDocs::all()->sortBy('name');

        return view('courses.edit',   ['data' => $data,
                                        'teachers' => $teachers,
                                        'directions' => $directions,
                                        'types' => $types,
                                        'typeDoc' => $typeDoc,
                                        'idTeachers'=>$idTeachers]);
        //
    }

    public function delete(Request $request, $id, $idTeachers)
    {
        $data =[];
        if ($id>0) $data = courses::where('id', $id)->first();
        
        return view('courses.delete', ['data' => $data,
                                        'idTeachers'=>$idTeachers]);
        //
    }

    public function deleteConfirm(Request $request)
    {
        $del = courses::find($request->id);

        $del->delete();
        
        if (empty($request->fIdTeachers)) return redirect('/courses');
        else return redirect('/courses?fIdTeachers='.$request->fIdTeachers);
      
    }

    public function memo_user()
    {
        return view('memo.user');        
    }

    public function memo_moderator()
    { 
        return view('memo.moderator');        
    }

}
