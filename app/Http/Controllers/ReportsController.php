<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;

use App\Models\teachers;
use App\Models\positions;
use App\Models\institutions;

use App\Models\courses;
use App\Models\courseType;
use App\Models\courseDirections;

use App\Exports\TeachersExport;
use App\Exports\CoursesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    //
    private $ItemCountPage = 20; //Количество записей на страницу

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function listTeachers(Request $request)
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
                $fidInstitution = $user->moderatorInstitution->id;
                $data = $data->where('idInstitutions', '=', $user->moderatorInstitution->id);  
            }
        }
 
        $fidInstitution = $request->fidInstitution;
        if (!empty($fidInstitution)) {
            $data = $data->where('idInstitutions', '=', $fidInstitution);
        } 
        $fidPosition = $request->fidPosition;
        if (!empty($fidPosition)) {
            $data = $data->where('idPositions', '=', $fidPosition);
        } 

        $data = $data->orderBy('surname', 'asc')
                    ->orderBy('name','asc')
                    ->orderBy('patronymic','asc')
                    ->paginate($this->ItemCountPage)->withQueryString();

        $positions = positions::all()->sortBy('name');
        if (!empty($user->hasRole('admin'))) { 
            $institutions = institutions::all()->sortBy('name');
        }else{
            $institutions = institutions::where('id','=',$user->moderatorInstitution->id)->get();
        }
        $guides = ['positions'=>$positions,'institutions'=>$institutions ];

        $filter = ['fIdTeachers'=>$fIdTeachers,'teacher'=>$teacher,'fSurname'=>$fSurname,'fidInstitution'=>$fidInstitution,'fidPosition'=>$fidPosition ];

        return view('reports.teachers',['data' => $data, 'filter' => $filter, 'guides' => $guides]);
    }

    public function listCourses(Request $request)
    {

        $data = new courses;
        $user = Auth::user();


        $teacher = '';
        $fIdTeachers = $request->fIdTeachers;
        if (!empty($fIdTeachers)) {
            $data = $data->where('idTeachers', '=', $fIdTeachers);
            $teacher = teachers::where('id','=',$fIdTeachers)->first();
        }            

        $fPositions = $request->fPositions;
        $positionIDs = [];
        if (!empty($fPositions)) {
            $positionIDs = array_map('intval', $fPositions);
        }

        $teachersList = '';
        if (!empty($user->moderatorInstitution->id)) {
            if (count($positionIDs)>0 && empty(in_array(-1, $positionIDs))) {
                $teachersList = DB::table('teachers')->where('idInstitutions','=',$user->moderatorInstitution->id)->WhereIn('idPositions',$positionIDs)->pluck('id')->toArray();    
            }else{
                $teachersList = DB::table('teachers')->where('idInstitutions','=',$user->moderatorInstitution->id)->pluck('id')->toArray();
            }
            $data = $data->whereIn('idTeachers', $teachersList);  
        }
        $fidInstitution = $request->fidInstitution;
        if (!empty($fidInstitution)) {
            if (count($positionIDs)>0 && empty(in_array(-1, $positionIDs))) {
                $teachersList = DB::table('teachers')->where('idInstitutions','=',$fidInstitution)->WhereIn('idPositions',$positionIDs)->pluck('id')->toArray();
            }else{
                $teachersList = DB::table('teachers')->where('idInstitutions','=',$fidInstitution)->pluck('id')->toArray();
            }        
            $data = $data->whereIn('idTeachers', $teachersList);  
        }else{
            if (count($positionIDs)>0  && empty(in_array(-1, $positionIDs))) {
                    $teachersList = DB::table('teachers')->whereIn('idPositions',$positionIDs)->pluck('id')->toArray();
                    $data = $data->whereIn('idTeachers', $teachersList);  
            }
        } 

        $fСourseType = $request->fСourseType;
        if (!empty($fСourseType)) {
            $data = $data->where('idType', '=', $fСourseType);
        }            
        $fIsFederal = $request->fIsFederal;
        if (!empty($fIsFederal)) {
            $data = $data->where('isFederal', '=', $fIsFederal-1);
        } 
        $fCourseDirections = $request->fCourseDirections;
        if (!empty($fCourseDirections)) {
            $data = $data->where('idDirections', '=', $fCourseDirections);
        } 
        $fDateDocStart = $request->fDateDocStart;
        $fDateDocEnd = $request->fDateDocEnd;
        if (!empty($fDateDocStart)) {
            $data = $data->where('dateDoc', '>=', $fDateDocStart);

        }
        if (!empty($fDateDocEnd)) {
            $data = $data->where('dateDoc', '<=', $fDateDocEnd);
        } 
        $fDateUpdStart = $request->fDateUpdStart;
        $fDateUpdEnd = $request->fDateUpdEnd;
        if (!empty($fDateUpdStart)) {
            $data = $data->where('updated_at', '>=', $fDateUpdStart);

        }
        if (!empty($fDateUpdEnd)) {
            $data = $data->where('updated_at', '<=', $fDateUpdEnd);
        } 
        
        $data = $data->orderBy('idType', 'asc')
                     ->orderBy('fullname', 'asc')
                     ->orderBy('progName','asc')
                     ->paginate($this->ItemCountPage)->withQueryString();            

        $positions = positions::all()->sortBy('name');
        if (!empty($user->hasRole('admin'))) { 
            $institutions = institutions::all()->sortBy('name');
        }else{
            $institutions = institutions::where('id','=',$user->moderatorInstitution->id)->get();
        }

        $guides = ['courseType'=>courseType::all()->sortBy('name'),'courseDirections'=>courseDirections::all()->sortBy('name'),'positions'=>$positions,'institutions'=>$institutions];

        $filter = ['fIdTeachers'=>$fIdTeachers,'teacher'=>$teacher,'fСourseType'=>$fСourseType,'fIsFederal'=>$fIsFederal,'fCourseDirections'=>$fCourseDirections,'fDateDocStart'=>$fDateDocStart,'fDateDocEnd'=>$fDateDocEnd,'fDateUpdStart'=>$fDateUpdStart,'fDateUpdEnd'=>$fDateUpdEnd,'fidInstitution'=>$fidInstitution];

        return view('reports.courses',['data' => $data, 'filter' => $filter,'positionIDs' => $positionIDs, 'guides' => $guides]);

    }

    public function exportTeachers(Request $request) 
    {

        return Excel::download(new TeachersExport(
                                                    $request->fSurname ?? '',
                                                    $request->fidInstitution ?? '',
                                                    $request->fidPosition ?? '',
                                                    $request->fidType ?? '',
                                                    $request->fDateDocStart ?? '',
                                                    $request->fDateDocEnd ?? ''
                                                  ), 
                                                  'АИС Мониторинг освоения ДПП - Педагоги '.date('d-m-Y hi').'.xlsx');
    }

    public function exportCourses(Request $request) 
    {

        return Excel::download(new CoursesExport(
                                                    $request->fidInstitution ?? '', 
                                                    $request->positionIDs ?? '', 
                                                    $request->fСourseType ?? '', 
                                                    $request->fIsFederal ?? '', 
                                                    $request->fCourseDirections ?? '', 
                                                    $request->fDateDocStart ?? '', 
                                                    $request->fDateDocEnd ?? '', 
                                                    $request->fDateUpdStart ?? '', 
                                                    $request->fDateUpdEnd ?? ''
                                                  ), 
                                                  'АИС Мониторинг освоения ДПП - Курсы ДПП '.date('d-m-Y hi').'.xlsx');
    }

}

