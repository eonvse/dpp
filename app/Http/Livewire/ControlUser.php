<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\Models\teachers;
use App\Models\User;
use App\Models\institutions;



class ControlUser extends Component
{
    use WithPagination;   
    
    public $search, $sortField, $sortDirection;
    public $typeView;
    public $guides;

    public function mount()
    {
        $this->search = $this->sortField = $this->sortDirection = '';
        $this->typeView = 1;
        $this->updateData();
    }

    public function updateData()
    {
        $users = DB::table('controlUser')
            ->select('id', 'name', 'email')
            ->whereNotNull('tId')
            ->whereNull('iId')
            ->orderBy('name')
            ->get()->toArray();
        $institutions = institutions::whereNull('idModerator')->get()->sortBy('name')->toArray();
        $this->guides = ['users'=>$users,'institutions'=>$institutions];
    }

    public function sortBy($field)
    {

        $this->sortDirection = $this->sortField === $field
                            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
                            : 'asc';

        $this->sortField = $field;

        $this->resetPage();
        
    }

    private function indexWire($data)
    {   

        $users = DB::table('controlUser')
            ->select('id', 'name', 'email', 'iId', 'iName', 'tId', 'tSurname', 'tName', 'tPatronymic');

        if ($data['typeView'] == 2 ) $users = $users->whereNotNull('iId');
        if ($data['typeView'] == 3 ) $users = $users->whereNull('tId');

        if (!empty($data['sortField'])) $users=$users->orderBy($data['sortField'],$data['sortDirection']);
        else $users = $users->orderBy('name');

        if(!empty($data['search'])){
           $users->Where('email','like',"%".$data['search']."%");
        }


        return $users;
    }

    public function updated($property)
    {
        // $property: The name of the current property that was updated
 
       if ($property === 'typeView') {
    
        $this->search = $this->sortField = $this->sortDirection = '';
        $this->resetPage();
    
        }
       
       if ($property === 'search') {
    
        $this->resetPage();
    
        }

    }

    public function render()
    {

        $data = array(
            'typeView'=>$this->typeView,
            'sortField'=> $this->sortField,
            'sortDirection'=> $this->sortDirection,
            'search'=> $this->search
        );

        $users = $this->indexWire($data);        
        
        return view('livewire.control-user',[
                            'users'=>$users->paginate(20)
                        ]);
    }
}
