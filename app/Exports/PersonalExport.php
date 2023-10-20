<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    * 
    */

    public function view(): View
    {
        $data = Auth::user()->teacher; 

        return view('teachers.personal.export',['data' => $data]);

    }
}
