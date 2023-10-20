<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class='inline-block'>
                {{ __('Педагоги') }}
                @role('moderator')
                    @if(!empty(Auth::user()->moderatorInstitution->id))
                        {{ Auth::user()->moderatorInstitution->name }}
                    @endif
                @endrole
                @if(!empty($filter['fIdTeachers'])) 
                ({{ $filter['teacher']->surname }} {{ !empty($filter['teacher']->name) ? Str::substr($filter['teacher']->name,0,1).'.' : '' }} {{ !empty($filter['teacher']->patronymic) ? Str::substr($filter['teacher']->patronymic,0,1).'.' : '' }})
                @endif
            </h2>        
            <div class="flex sm:inline-block">
                <a href="{{ route('teachers.create')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Добавить') }}</a>
            </div>
        </div>
    </x-slot>
    <div class="text-gray-800 leading-tight block max-w-7xl mx-auto my-2">
        <form class="inline-block text-xs w-full" method="GET">
            <div class="font-bold inline-block text-sm">Фильтры:</div>
            @role('admin')
            <div class="block sm:inline-block ">
                <label for="fidInstitution" class="">Учреждение</label>
                <select size="1" name="fidInstitution" id="fidInstitution" class="h-min p-1 text-xs border border-solid border-gray-300">
                    <option {{empty($filter['fidInstitution']) ? 'selected' : ''}} value=0>По всем</option>
                    @foreach($guides['institutions'] as $item)
                    <option value="{{ $item->id }}" {{$filter['fidInstitution']==$item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                    @endforeach
                </select> |   
            </div>
            @endrole
            <div class="block sm:inline-block ">
                <label for="fSurname" class="">Фамилия</label>
                <input type="text" class="h-min p-1 text-xs font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="fSurname" name="fSurname" placeholder="Укажите фамилию (часть)..." value="{{ $filter['fSurname'] }}"> | 
            </div>
            <div class="block sm:inline-block ">
                <label for="fidPosition" class="">Должность</label>
                <select size="1" name="fidPosition" id="fidPosition" class="h-min p-1 text-xs border border-solid border-gray-300">
                    <option {{empty($filter['fidPosition']) ? 'selected' : ''}} value=0>По всем</option>
                    @foreach($guides['positions'] as $item)
                    <option value="{{ $item->id }}" {{$filter['fidPosition']==$item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                    @endforeach
                </select> |  
            </div>
            <div>            
                <button type="submit" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">Применить</button>
                <a href="{{ route('teachers.list') }}" class="block text-center sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">Сбросить</a> 
            </div>
        </form>
    </div>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="font-bold text-gray-600">
                                <td colspan="2" class="block sm:table-cell"><span class="hover:text-sky-500">@sortablelink('surname','Фамилия')</span>
                                 <span class="hover:text-sky-500">@sortablelink('name','Имя')</span> 
                                 Отчество</td>
                                <td colspan="2" class="block sm:table-cell">
                                    @role('admin') 
                                        @if (empty($filter['fidInstitution'])) 
                                        Учреждение.
                                        @endif
                                    @endrole     
                                    @sortablelink('position.name','Должность')</td>
                                <td colspan="2" class="text-center block sm:table-cell">Кол-во курсов<br>(ч.)</td>
                                <td class="block text-xs sm:table-cell">Уч. запись (Email)
                                    <div class="sm:text-right">
                                        Модератор
                                        <span class="w-full pr-2 text-right text-orange-600 text-normal">
                                            &bull;
                                        </span>
                                    </div>
                                </td>
                                <td class="text-right block text-xs sm:table-cell">Автор/Редактор</td>
                                <td class="text-center block sm:table-cell">
                                    <svg class="h-7 w-7 text-black mx-auto"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />  <circle cx="12" cy="12" r="3" /></svg>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr class="odd:bg-white even:bg-slate-100 hover:bg-gray-100 border border-slate-200">
                                <td colspan="2" class="text-base block sm:table-cell">
                                    <span class="font-bold mr-2">{{ $item->surname }}</span>
                                    <span class="font-normal">{{ $item->name }} {{ $item->patronymic }}</span>
                                </td>
                                <td colspan="2" class="block sm:table-cell">
                                    @role('admin')
                                    @if (!empty($item->idInstitutions) && empty($filter['fidInstitution']))
                                        {{ $item->institution->name }}.
                                    @endif
                                    @endrole
                                    @if (!empty($item->idPositions))
                                        {{ $item->position->name }}
                                    @endif
                                </td>
                                <td class="text-center block sm:table-cell">{{ $item->courses->count('id') }} <span class="text-gray-600"><br>({{ $item->courses->sum('hours') }} ч.)</span></td>
                                <td class="items-center block sm:table-cell">
                                    <div class="flex justify-center">
                                        <x-link-add-course :href="'./courses/create?fIdTeachers='.$item->id" :title="$item->surname.': Добавить курс ДПП'"></x-link-add-course>
                                        <x-link-list-course :href="'./courses?fIdTeachers='.$item->id" :title="$item->surname.': Список курсов ДПП'"></x-link-list-course>
                                    </div>
                                </td>
                                <td class="flex justify-center text-center text-xs">
                                    @if (!empty($item->idUser))
                                    <div class="font-bold">{{ $item->User->name }}<br><span class="font-normal">{{ $item->User->email }}</span></div>
                                        @if (!empty($item->user->moderatorInstitution->id))
                                    <div title="{{ 'Модератор - '.$item->user->moderatorInstitution->name }}" class="w-full pr-2 text-right text-orange-600 text-2xl cursor-pointer">
                                    &bull;
                                    </div>
                                        @endif
                                    @else
                                    <div class="flex justify-center">
                                        <a href="users/add?teachers={{ $item->id }}">
                                            <svg class="h-8 w-8 text-gray-500 hover:text-green-600"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                            </svg>
                                        </a>
                                    </div>                           
                                    @endif
                                </td>
                                <td class="text-xs text-right block sm:table-cell">
                                    @if (!empty($item->idAutor))
                                        {{ $item->Autor->name }} 
                                        @if ($item->idAutor != $item->idUpdater)
                                        / {{ $item->Updater->name }}
                                        @endif
                                    @endif
                                </td>
                                <td class="block sm:table-cell">
                                    <div class="flex justify-center mx-auto">
                                        <x-link-edit :href="route('teachers.edit', $item->id)" :title="$item->surname.' Редактировать'"></x-link-edit>
                                        <x-link-del :href="route('teachers.delete', $item->id)" :title="$item->surname.' Удалить'"></x-link-del>
                                    </div>
                                </td>
                            </tr>
                            @endforeach                            
                        </tbody>
                    </table>
                    <div>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-link-top></x-link-top>
</x-app-layout>