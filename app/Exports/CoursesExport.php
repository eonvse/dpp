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

    private $institutionIDs,$positionIDs,$fСourseType, $fIsFederal, $directionIDs, $fDateDocStart, $fDateDocEnd, $fDateUpdStart, $fDateUpdEnd;

    public function __construct(string $institutionIDs,string $positionIDs,string $fСourseType,string $fIsFederal,string $directionIDs,string $fDateDocStart,string $fDateDocEnd,string $fDateUpdStart, string $fDateUpdEnd) 
    {

        $this->institutionIDs   = $institutionIDs;
        $this->positionIDs      = $positionIDs;
        $this->fСourseType      = $fСourseType;
        $this->fIsFederal       = $fIsFederal;
        $this->directionIDs     = $directionIDs;
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
        $institutionIDs = [];
        if (strlen($this->institutionIDs)>0) {
            $institutionIDs = explode(',', $this->institutionIDs);
        }
        $directionIDs = [];
        if (strlen($this->directionIDs)>0) {
            $directionIDs = explode(',', $this->directionIDs);
        }

        if ($user->hasRole('admin')){

            $teachersList = DB::table('teachers');
            if (count($positionIDs)>0 && empty(in_array(-1, $positionIDs))) {
                $teachersList = $teachersList->WhereIn('idPositions',$positionIDs);
                $filter[] = 'Должности: '.implode(',',positions::whereIn('id',$positionIDs)->pluck('name')->toArray()); 
                if (!empty(in_array(0, $positionIDs))) $filter[] = "без должности";   
            }
            if (count($institutionIDs)>0 && empty(in_array(-1, $institutionIDs))) {
                $teachersList = $teachersList->WhereIn('idInstitutions',$institutionIDs);
                $filter[] = 'Учреждения: '.implode(',',institutions::whereIn('id',$institutionIDs)->pluck('name')->toArray()); 
    
            }

            $teachersList = $teachersList->pluck('id')->toArray();
            $data = $data->whereIn('idTeachers', $teachersList);  



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
        if (count($directionIDs)>0 && empty(in_array(-1, $directionIDs))) {
            $data = $data->WhereIn('idDirections',$directionIDs);
            $filter[] = 'Направления ДПП: '.implode(',',courseDirections::whereIn('id',$directionIDs)->pluck('name')->toArray()); 
            if (!empty(in_array(0, $directionIDs))) $filter[] = "Без направления";   
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

