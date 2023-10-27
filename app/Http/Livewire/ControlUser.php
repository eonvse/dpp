<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\Models\teachers;
use App\Models\User;
use App\Models\institutions;

use Illuminate\Support\Facades\Hash;



class ControlUser extends Component
{
    use WithPagination;   
    
    public $search, $sortField, $sortDirection;
    public $typeView;
    public $guides;

    public $showDelModerator, $delModerator;
    public $showEditModerator, $editModerator, $newModeratorId;

    public $showNewPassword, $newPassword, $newPasswordUser;

    public $showEditUser, $editUser;
    
    protected $rules = [
        'newPassword' => 'regex:/^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)/',
        'editUser.id' =>'required',
        'editUser.name' =>'required',
        'editUser.email' =>'required|email',
    ];

    protected $messages = [
        'newPassword.regex' => 'Пароль должен быть не менее 8 символов, содержать цифры и латинские символы',
    ];
    
    protected $listeners = ['refresh-me' => '$refresh'];   
    
    public function mount()
    {
        $this->search = $this->sortField = $this->sortDirection = '';
        $this->typeView = 1;
        $users = DB::table('controlUser')
            ->select('id')
            ->whereNotNull('tId')
            ->whereNull('iId')
            ->pluck('id')->toArray();
        $institutions = institutions::whereNull('idModerator')->get()->sortBy('name')->toArray();
        $noModeratorUsers = User::whereIn('id',$users)->get()->sortBy('name')->toArray();
        $this->guides = ['users'=>$noModeratorUsers,'institutions'=>$institutions];

        $this->showDelModerator = false;
        $this->delModerator = array('id'=>null, 'name'=>null);

        $this->showEditModerator = false;
        $this->editModerator = array('iId'=>null,'iName'=>null,'uId'=>null,'uName'=>null,'uEmail'=>null);
        $this->newModeratorId = 0;

        $this->showNewPassword = false;
        $this->newPasswordUser = array('uId'=>null,'uName'=>null,'uEmail'=>null);
        $this->newPassword = '';
    
        $this->showEditUser = false;
        $this->editUser = null;
        
        $this->showDelUser = false;
        $this->delUser = array('id'=>null, 'name'=>null, 'email'=>null);

    }



/*-----------------------------------------------------
-------------УПРАВЛЕНИЕ МОДЕРАТОРАМИ-------------------
-------------------------------------------------------*/

    public function showDeleteModerator($iId)
    {
        $this->delModerator = institutions::find($iId);
        $this->showDelModerator = true;
    }

    public function cancelDelModerator() {

        $this->delModerator = array('id'=>null, 'name'=>null);
        $this->showDelModerator = false;
    }

    public function destroyModerator($iId)
    {
        $upd = institutions::find($iId);
        $idModerator = $upd->idModerator;
        $upd->idModerator = NULL;

        $upd->save();

        $user = User::where('id',$idModerator)->first();
        $user->syncRoles('teacher');
        
        $this->updateData(); 
        $this->cancelDelModerator();
    }

    public function showEditInstModer($iId,$iName,$id,$name,$email)
    {

        $this->showEditModerator = true;
        $this->editModerator = array('iId'=>$iId,'iName'=>$iName,'uId'=>$id,'uName'=>$name,'uEmail'=>$email);

    }

    public function cancelEditModerator() {

        $this->showEditModerator = false;
        $this->editModerator = array('iId'=>null,'iName'=>null,'uId'=>null,'uName'=>null,'uEmail'=>null);
        $this->newModeratorId = 0;
    }

    public function store()
    {
        if (empty($this->newModeratorId)) return;
        $upd = institutions::find($this->editModerator['iId']);
        $idOldModerator = $upd->idModerator;
        $upd->idModerator = $this->newModeratorId;

        $upd->save();

        $user = User::where('id',$this->newModeratorId)->first();
        $user->syncRoles('moderator');
        $user = User::where('id',$idOldModerator)->first();
        $user->syncRoles('teacher');
        
        return redirect('users');

    }

/*-----------------------------------------------------
-------------Персональная информация-------------------
-------------------------------------------------------*/

public function AddPersonalForUser($uId)
{
    return redirect('/users/personal/add/'.$uId);
}

/*-----------------------------------------------------
-------------Замена пароля-----------------------------
-------------------------------------------------------*/
    
    public function showModalPassword($uId,$uName,$uEmail)
    {
        $this->showNewPassword = true;
        $this->newPasswordUser = array('uId'=>$uId,'uName'=>$uName,'uEmail'=>$uEmail);
    }

    public function canselModalPassword() {
        $this->showNewPassword = false;
        $this->newPasswordUser = array('uId'=>null,'uName'=>null,'uEmail'=>null);
        $this->newPassword = '';
        $this->resetValidation('newPassword');
        $this->resetErrorBag('newPassword');
    }

    public function savePassword()
    {
        if (!empty($this->newPassword)) {
            $user = User::find($this->newPasswordUser['uId']);
            $user->password = Hash::make($this->newPassword);
            $user->save();
        }
        $this->canselModalPassword();
    }

/*-----------------------------------------------------
-------------Редактирование логина и email-------------
-------------------------------------------------------*/
    
    public function showModalEditUser($uId)
    {
        $this->showEditUser = true;
        $this->editUser = User::find($uId);
    }

    public function cancelEditUser() {
        $this->showEditUser = false;
        $this->editUser = null;
    }

/*-----------------------------------------------------
-------------УДАЛЕНИЕ ПОЛЬЗОВАТЕЛЯ---------------------
-------------------------------------------------------*/

    public function showDeleteUser($id)
    {
        $this->delUser = User::find($id);
        $this->showDelUser = true;
    }

    public function cancelDelUser() {

        $this->showDelUser = false;
        $this->delUser = array('id'=>null, 'name'=>null, 'email'=>null);
    }

    public function destroyUser($id)
    {
        $this->delUser->delete();
        $this->updateData(); 
        $this->cancelDelUser();
    }


/*-----------------------------------------------------
-------------RENDER + users->paginate()----------------
-------------------------------------------------------*/
    public function updateData()
    {
        $users = DB::table('controlUser')
            ->select('id')
            ->whereNotNull('tId')
            ->whereNull('iId')
            ->pluck('id')->toArray();
        $institutions = institutions::whereNull('idModerator')->get()->sortBy('name')->toArray();
        $noModeratorUsers = User::whereIn('id',$users)->get()->sortBy('name')->toArray();
        $this->guides = ['users'=>$noModeratorUsers,'institutions'=>$institutions];
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
            ->select('id', 'name', 'email', 'iId', 'iName', 'tId', 'tSurname', 'tName', 'tPatronymic','max_role');

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

       if ($property === 'newPassword') {
    
        $this->validateOnly($property);
    
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

        $this->updateData();
        
        return view('livewire.control-user',[
                            'users'=>$users->paginate(20),
                        ]);
    }
}
