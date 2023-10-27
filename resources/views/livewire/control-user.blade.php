<div>
    <div class="m-3 grid grid-cols-2 space-x-2 items-center">
        <div>Режим отображения
            <select class="form-control block w-full h-min p-1 text-base border border-solid border-gray-300" wire:model = "typeView">
                <option value="1">Все пользователи</option>
                <option value="2">Модераторы</option>
                <option value="3">Без персональных данных</option>
            </select>
        </div>
        <div class="">
            Поиск по email
            <div class="flex">
                <input class="form-control block w-full h-min p-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text" wire:model.live="search" />
                @if (!empty($search))
                    <x-cancel-icon wire:click="$set('search', '')" title="Отменить" />
                @endif
            </div>  
        </div>

    </div>

    <div class="grid grid-cols-1 items-center" >

        <div class="grid grid-cols-5 font-bold ">
            <div class="p-1">
                <x-link-head scope="col" 
                    sortable 
                    wire:click="sortBy('name')" 
                    :direction="$sortField === 'name' ? $sortDirection : null">Логин</x-link-head> 
            </div>
            <div class="p-1">
                <x-link-head scope="col" 
                    sortable 
                    wire:click="sortBy('email')" 
                    :direction="$sortField === 'email' ? $sortDirection : null">email</x-link-head> 

            </div>
            <div class="p-1">                
                <x-link-head scope="col" 
                    sortable 
                    wire:click="sortBy('tSurname')" 
                    :direction="$sortField === 'tSurname' ? $sortDirection : null">ФИО</x-link-head>
            </div>
            <div class="p-1 flex">Модератор
                <x-link-head class="ml-3" scope="col" 
                    sortable 
                    wire:click="sortBy('iName')" 
                    :direction="$sortField === 'iName' ? $sortDirection : null">учреждения</x-link-head>
                            <div class="flex">
        <x-button.icon-plus data-bs-toggle="modal" data-bs-target="#addModerator" title="Добавить модератора" />
    </div>
    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="addModerator" tabindex="-1" aria-labelledby="addModerator" aria-modal="true" role="dialog">       
        <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
            <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Добавить модератора
                    </h5>
                    <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                  data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('moderator.add') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body relative p-4">
                        <table class="table-auto my-3">
                            <tr>
                                <td>Учреждение</td>
                                <td>
                                   <select size="1" name="id" id="id" class="form-select appearance-none inline-flex w-full px-3 py-1 text-sm font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" required>
                                        @foreach($guides['institutions'] as $institution)
                                        <option value="{{ $institution['id'] }}">{{ $institution['name'] }}</option>
                                        @endforeach
                                    </select>    
                                </td>
                            </tr>
                            <tr>
                                <td>Модератор</td>
                                <td>
                                   <select size="1" name="idModerator" id="idModerator" class="form-select appearance-none inline-flex w-full px-3 py-1 text-sm font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" required>
                                    @foreach($guides['users'] as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['name'] }} ({{ $user['email'] }})</option>
                                    @endforeach
                                    </select>    
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <button type="submit" class="border-solid border border-green-500 rounded bg-green-100 hover:bg-green-200 p-2">
                            Добавить
                        </button>
                        <button type="button" class="border-solid border border-gray-500 rounded bg-red-100 hover:bg-red-200 p-2"       data-bs-dismiss="modal">
                            Отменить
                        </button>
                    </div>        
                </form>
            </div>
        </div>
    </div>

            </div>
            <div class="text-center mx-auto text-gray-700">
                <svg class="h-6 w-6"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />  <circle cx="12" cy="12" r="3" /></svg>
            </div>
        </div>
        
        @forelse ($users as $user)
        <div class="grid grid-cols-5 border hover:bg-gray-200">
            <div class="border-r p-1">{{ $user->name }}</div>
            <div class="border-r p-1">{{ $user->email }}</div>
            <div class="border-r p-1 text-sm">
                @if (!empty($user->tId))
                    <a href="teachers?fSurname={{ $user->tSurname }}" class="hover:underline"> {{ $user->tSurname ?? '' }}</a> {{ $user->tName ?? '' }} {{ $user->tPatronymic ?? '' }}
                    @if ($user->max_role==3)
                        <span class="text-indigo-800 font-bold text-xs">(Администратор)</span>
                    @endif
                @else
                    @if ($user->max_role==3)
                        <span class="text-indigo-800 font-bold">Администратор</span>
                    @else
                        <div class="flex items-center">
                            <div class="text-red-500 grow">Данных нет</div>
                            <x-button.icon-plus wire:click="AddPersonalForUser({{ $user->id }})" title="Добавить персональные данные" />
                        </div>
                    @endif
                @endif    
            </div>
            <div class="border-r p-1 text-xs flex">
                @if (!empty($user->iId))
                    <span class="text-orange-400 font-bold grow">{{ $user->iName }}</span>
                    <div class="flex items-center">
                        <x-button.icon-edit wire:click="showEditInstModer({{ $user->iId }},'{{ $user->iName }}',{{ $user->id }},'{{ $user->name }}','{{ $user->email }}')" title="Поменять модератора"/>
                        <x-button.icon-del wire:click="showDeleteModerator({{ $user->iId }})" title="Удалить из модераторов"/>
                    </div>
                @endif    
            </div>
            <div class="p-1 flex items-center mx-auto">
                @if ($user->max_role!=3)
                <x-button.icon-pass wire:click="showModalPassword({{ $user->id }},'{{ $user->name }}','{{ $user->email }}')"  title="Новый пароль" />
                @endif
                <x-button.icon-edit wire:click="showModalEditUser({{ $user->id }})" title="Редактировать логин, email" />
                @if ($user->max_role!=3 && empty($user->tId))
                <x-button.icon-del wire:click="showDeleteUser({{ $user->id }})" title="Удалить пользователя" />
                @endif
            </div>
        </div>
        @empty
            <div class="text-xl text-center p-5 border text-neutral-600">Пользователи не найдены</div>
        @endforelse
    
    </div>
    {{ $users->links() }}

<x-modal-wire.dialog wire:model.defer="showDelModerator" type="warn" maxWidth="md">
    <x-slot name="title">
        <span class="grow">Удалить модератора</span><x-button.icon-cancel @click="show = false" wire:click="cancelDelModerator" class="text-gray-700 hover:text-white dark:hover:text-white" />
    </x-slot>
    <x-slot name="content">
        <div class="flex-col space-y-2">
            <x-input.label class="text-lg font-medium">Вы действительно хотите удалить модератора? 
                <div class="text-red-600 shadow p-1">Учреждения {{ $delModerator['name'] }}</div>
            </x-input.label>
            <x-button.secondary @click="show = false" wire:click="cancelDelModerator">{{ __('Отменить') }}</x-button.secondary>
            <x-button.danger wire:click="destroyModerator({{ $delModerator['id'] }})">{{ __('Удалить')}}</x-button.danger>
        </div>                            
    </x-slot>
</x-modal-wire.dialog>

<x-modal-wire.dialog wire:model.defer="showEditModerator" maxWidth="md">
        <x-slot name="title"><span class="grow">{{ __('Поменять модератора') }}</span><x-button.icon-cancel @click="show = false" wire:click="cancelEditModerator" class="text-gray-700 hover:text-white" /></x-slot>
        <x-slot name="content">
            <div class="text-lg">Заменить модератора учреждения <div>{{ $editModerator['iName'] ?? '' }}</div></div>
            <div class="text-lg font-bold">c {{ $editModerator['uName'] ?? '' }} ({{ $editModerator['uEmail'] ?? '' }}) на</div>
            <form method="post" action="{{ route('moderator.update') }}" class="flex-col space-y-2">                                                 
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $editModerator['iId'] }}" />
                <input type="hidden" id="oldModerator" name="oldModerator" value="{{ $editModerator['uId'] }}" />
                <div><x-input.select-user  class="inline-block my-2" :items="$guides['users']" name="idModerator" id="idModerator" required /></div>  
                <x-button.create type="submit">{{ __('Сохранить') }}</x-button.create>
                <x-button.secondary @click="show = false" wire:click="cancelEditModerator">{{ __('Отмена') }}</x-button.secondary>
            </form>
        </x-slot>
</x-modal-wire.dialog>

<x-modal-wire.dialog wire:model.defer="showNewPassword" maxWidth="md">
        <x-slot name="title"><span class="grow">{{ __('Поменять пароль') }}</span><x-button.icon-cancel @click="show = false" wire:click="canselModalPassword" class="text-gray-700 hover:text-white" /></x-slot>
        <x-slot name="content">
            <div class="text-lg">Установить новый пароль пользователю</div>
            <div class="text-lg font-bold">{{ $newPasswordUser['uName'] ?? '' }} ({{ $newPasswordUser['uEmail'] ?? '' }})</div>
            <form wire:submit="savePassword" class="flex-col space-y-2"> 
                <x-input.text wire:model="newPassword" required />
                 @error('newPassword') <div class="text-red-800">{{ $message }}</div> 
                 @else <x-button.create type="submit">{{ __('Сохранить') }}</x-button.create>
                 @enderror
                <x-button.secondary @click="show = false" wire:click="canselModalPassword">{{ __('Отмена') }}</x-button.secondary>
            </form>
        </x-slot>
</x-modal-wire.dialog>

<x-modal-wire.dialog wire:model.defer="showEditUser" maxWidth="md">
        <x-slot name="title"><span class="grow">{{ __('Редактировать логин, email') }}</span><x-button.icon-cancel @click="show = false" wire:click="cancelEditUser" class="text-gray-700 hover:text-white" /></x-slot>
        <x-slot name="content">
            <form action="{{ route('user.update',['idUser'=>$editUser->id ?? 0]) }}" method="POST" class="flex-col space-y-2"> 
                @csrf
                <x-input.text wire:model="editUser.name" id="name" name="name" required />
                 @error('editUser.name') <div class="text-red-800">{{ $message }}</div>@enderror
                <x-input.text wire:model="editUser.email" id="email" name="email" required />
                 @error('editUser.email') <div class="text-red-800">{{ $message }}</div>@enderror
                <x-button.create type="submit">{{ __('Сохранить') }}</x-button.create>
                <x-button.secondary @click="show = false" wire:click="cancelEditUser">{{ __('Отмена') }}</x-button.secondary>
            </form>
        </x-slot>
</x-modal-wire.dialog>

<x-modal-wire.dialog wire:model.defer="showDelUser" type="warn" maxWidth="md">
    <x-slot name="title">
        <span class="grow">Удалить пользователя</span><x-button.icon-cancel @click="show = false" wire:click="cancelDelUser" class="text-gray-700 hover:text-white dark:hover:text-white" />
    </x-slot>
    <x-slot name="content">
        <div class="flex-col space-y-2">
            <x-input.label class="text-lg font-medium">Вы действительно хотите удалить пользователя? 
                <div class="text-red-600 shadow p-1">{{ $delUser['name'] }} <span class="text-gray-500">({{ $delUser['email'] }})</span></div>
            </x-input.label>
            <x-button.secondary @click="show = false" wire:click="cancelDelUser">{{ __('Отменить') }}</x-button.secondary>
            <x-button.danger wire:click="destroyUser({{ $delUser['id'] }})">{{ __('Удалить')}}</x-button.danger>
        </div>                            
    </x-slot>
</x-modal-wire.dialog>

</div>
