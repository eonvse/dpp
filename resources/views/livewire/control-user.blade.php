<div>
    <div class="m-3 grid grid-cols-2 space-x-2">
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
    @if ($typeView==2)
    <div class="">
        <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" data-bs-toggle="modal" data-bs-target="#addModerator">Добавить модератора
        </button>
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
    @endif
    <div class="grid grid-cols-1 items-center">

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
            </div>
            <div class="p-1">...</div>
        </div>
        
        @foreach ($users as $user)
        <div class="grid grid-cols-5 border hover:bg-gray-200">
            <div class="border-r p-1">{{ $user->name }}</div>
            <div class="border-r p-1">{{ $user->email }}</div>
            <div class="border-r p-1 text-sm">
                @if (!empty($user->tId))
                    {{ $user->tSurname ?? '' }} {{ $user->tName ?? '' }} {{ $user->tPatronymic ?? '' }}
                @else
                    <span class="text-red-500">Данных нет</span>
                @endif    
            </div>
            <div class="border-r p-1 text-sm">
                @if (!empty($user->iId))
                    <span class="text-orange-400 font-bold">{{ $user->iName }}</span>
                @endif    
            </div>
            <div class="p-1">...</div>
        </div>
        @endforeach
    
    </div>
    {{ $users->links() }}


</div>
