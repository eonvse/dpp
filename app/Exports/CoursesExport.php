<?php

namespace App\Exports;

use App\Models\courses;
use App\Models\courseType;
use App\Models\courseDirections;

use App\Models\institutions;
use App\Models\positions;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
//use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoursesExport implements FromView//, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    * 
    */

    private $fidInstitution,$positionIDs,$fСourseType, $fIsFederal, $fCourseDirections, $fDateDocStart, $fDateDocEnd, $fDateUpdStart, $fDateUpdEnd;

    public function __construct(string $fidInstitution,string $positionIDs,string $fСourseType,string $fIsFederal,string $fCourseDirections,string $fDateDocStart,string $fDateDocEnd,string $fDateUpdStart, string $fDateUpdEnd) 
    {

        $this->fidInstitution   = $fidInstitution;
        $this->positionIDs      = $positionIDs;
        $this->fСourseType      = $fСourseType;
        $this->fIsFederal       = $fIsFederal;
        $this->fCourseDirections= $fCourseDirections;
        $this->fDateDocStart    = $fDateDocStart;
        $this->fDateDocEnd      = $fDateDocEnd;
        $this->fDateUpdStart    = $fDateUpdStart;
        $this->fDateUpdEnd      = $fDateUpdEnd;
    }

    public function view(): View
    {
        $data = new courses;
        $filter = array();
        $user = Auth::user();

        $positionIDs = [];
        if (strlen($this->positionIDs)>0) {
            $positionIDs = explode(',', $this->positionIDs);
        }

        if ($user->hasRole('admin')){
            $fidInstitution = $this->fidInstitution;
            if (!empty($fidInstitution)) {
                $filter[] = 'Учреждение: '.institutions::where('id','=',$fidInstitution)->first()->name;
                if (count($positionIDs)>0 && empty(in_array(-1, $positionIDs))) {
                    $teachersList = DB::table('teachers')->where('idInstitutions','=',$fidInstitution)->WhereIn('idPositions',$positionIDs)->pluck('id')->toArray();
                    $filter[] = 'Должности: '.implode(',',positions::whereIn('id',$positionIDs)->pluck('name')->toArray());
                    if (!empty(in_array(0, $positionIDs))) $filter[] = "без должности";

                }else{
                    $teachersList = DB::table('teachers')->where('idInstitutions','=',$fidInstitution)->pluck('id')->toArray();
                }        
                $data = $data->whereIn('idTeachers', $teachersList);

            }else{
                if (count($positionIDs)>0  && empty(in_array(-1, $positionIDs))) {
                        $teachersList = DB::table('teachers')->whereIn('idPositions',$positionIDs)->pluck('id')->toArray();
                        $data = $data->whereIn('idTeachers', $teachersList);  
                        $filter[] = 'Должности: '.implode(',',positions::whereIn('id',$positionIDs)->pluck('name')->toArray());
                        if (!empty(in_array(0, $positionIDs))) $filter[] = "без должности";
                }
            } 
        } else {
        if (!empty($user->moderatorInstitution->id)) {
            if (count($positionIDs)>0 && empty(in_array(-1, $positionIDs))) {
                $teachersList = DB::table('teachers')->where('idInstitutions','=',$user->moderatorInstitution->id)->WhereIn('idPositions',$positionIDs)->pluck('id')->toArray();    
                $filter[] = 'Должности: '.implode(',',positions::whereIn('id',$positionIDs)->pluck('name')->toArray());
                if (!empty(in_array(0, $positionIDs))) $filter[] = "без должности";
            }else{                
                $teachersList = DB::table('teachers')->where('idInstitutions','=',$user->moderatorInstitution->id)->pluck('id')->toArray();
            }
            $data = $data->whereIn('idTeachers', $teachersList);  
        }
        }

        if (!empty($this->fСourseType)) {
            $data = $data->where('idType', '=', $this->fСourseType);
            $filter[] = 'Тип ДПП: '.courseType::where('id','=',$this->fСourseType)->first()->name;
        }            

        if (!empty($this->fIsFederal)) {
            $data = $data->where('isFederal', '=', $this->fIsFederal-1);
            $isFederalText = $this->fIsFederal==2 ? 'Да' : 'Нет';
            $filter[] = 'Входит в Фед. реестр: '.$isFederalText;
        } 
        if (!empty($this->fCourseDirections)) {
            $data = $data->where('idDirections', '=', $this->fCourseDirections);
            $filter[] = 'Направление ДПП: '.courseDirections::where('id','=',$this->fCourseDirections)->first()->name;
        } 
        if (!empty($this->fDateDocStart)) {
            $data = $data->where('dateDoc', '>=', $this->fDateDocStart);
            $filter[] = 'Дата с: '.date('d.m.Y', strtotime($this->fDateDocStart));
        }
        if (!empty($this->fDateDocEnd)) {
            $data = $data->where('dateDoc', '<=', $this->fDateDocEnd);
            $filter[] = 'Дата по: '.date('d.m.Y', strtotime($this->fDateDocEnd));
        } 
        if (!empty($this->fDateUpdStart)) {
            $data = $data->where('updated_at', '>=', $this->fDateUpdStart);
            $filter[] = 'Заполнено с: '.date('d.m.Y', strtotime($this->fDateUpdStart));
        }
        if (!empty($this->fDateUpdEnd)) {
            $data = $data->where('updated_at', '<=', $this->fDateUpdEnd);
            $filter[] = 'Заполнено по: '.date('d.m.Y', strtotime($this->fDateUpdEnd));
        } 
        
        $data = $data->orderBy('idType', 'asc')
                     ->orderBy('fullname', 'asc')
                     ->orderBy('progName','asc')
                     ->get();            

        return view('reports.export.courses',['data' => $data, 'filter' => $filter ]);

    }
}

