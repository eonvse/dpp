<?php

namespace App\Exports;

use App\Models\teachers;
use App\Models\positions;
use App\Models\institutions;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeachersExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    * 
    */

    private $fSurname,$fidInstitution,$fidPosition;

    public function __construct(string $fSurname,string $fidInstitution,string $fidPosition) 
    {

        $this->fSurname         = $fSurname;
        $this->fidInstitution   = $fidInstitution;
        $this->fidPosition      = $fidPosition;
    }

    public function view(): View
    {
        $data = new teachers;
        $filter = array();

        if (!empty($this->fSurname)) {
            $data = $data->where('surname', 'like', '%'.$this->fSurname.'%');
            $filter[] = 'Фамилия содержит: "'.$this->fSurname.'"';
        } 
        if (!empty($this->fidInstitution)) {
            $data = $data->where('idInstitutions', '=', $this->fidInstitution);
            $filter[] = 'Учреждение: '.institutions::where('id','=',$this->fidInstitution)->first()->name;
        }elseif (!empty(Auth::user()->moderatorInstitution->id)) {
            $data = $data->where('idInstitutions', '=', Auth::user()->moderatorInstitution->id);
        } 
        if (!empty($this->fidPosition)) {
            $data = $data->where('idPositions', '=', $this->fidPosition);
            $filter[] = 'Должность: '.positions::where('id','=',$this->fidPosition)->first()->name;
        } 

        $data = $data->orderBy('surname', 'asc')
                    ->orderBy('name','asc')
                    ->orderBy('patronymic','asc')
                    ->get();



        return view('reports.export.teachers',['data' => $data, 'filter' => $filter]);

    }
}
