<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class='inline-block'>
                {{ __('Отчет по педагогам.') }}
                <span class="text-sm">
                    @if(!empty($filter['fIdTeachers'])) 
                    {{ $filter['teacher']->surname }} {{ !empty($filter['teacher']->name) ? Str::substr($filter['teacher']->name,0,1).'.' : '' }} {{ !empty($filter['teacher']->patronymic) ? Str::substr($filter['teacher']->patronymic,0,1).'.' : '' }}| 
                    @endif

                    @if(!empty($filter['fidInstitution'])) 
                    <span class="italic">Учреждение:</span> {{ $guides['institutions']->where('id','=',$filter['fidInstitution'])->first()->name }}.
                    @endif

                    @if(!empty($filter['fSurname'])) 
                    <span class="italic">Фамилия содержит:</span> "{{ $filter['fSurname'] }}".
                    @endif

                    @if(!empty($filter['fidPosition'])) 
                    <span class="italic">Должность:</span> {{ $guides['positions']->where('id','=',$filter['fidPosition'])->first()->name }}.
                    @endif
                </span>
            </h2>        
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <button type="button" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-base text-gray-700 tracking-widest shadow-sm hover:bg-gray-200 disabled:opacity-25 transition ease-in-out duration-150" data-bs-toggle="modal" data-bs-target="#filterForm">
            Фильтры
        </button>
        <a href="{{ route('report.teachers') }}" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-base text-gray-700 tracking-widest shadow-sm hover:bg-rose-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            Сбросить
        </a> 

        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="filterForm" tabindex="-1" aria-labelledby="filterForm" aria-modal="true" role="dialog">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable relative w-auto pointer-events-none">
            <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
              <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalCenteredScrollableLabel">
                  Фильтры
                </h5>
                <button type="button"
                  class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                  data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body relative p-4">
                <form class="text-base w-full" method="GET">
                    <table class="w-full">
                        <tr>
                            <td class="text-right">Учреждение</td>
                            <td>
                                <select size="1" name="fidInstitution" id="fidInstitution" class="form-control block w-full h-min p-1 text-base border border-solid border-gray-300">
                                    <option {{empty($filter['fidInstitution']) ? 'selected' : ''}} value=0>По всем</option>
                                    @foreach($guides['institutions'] as $item)
                                    <option value="{{ $item->id }}" {{$filter['fidInstitution']==$item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">Фамилия</td>
                            <td><input type="text" class="form-control block w-full h-min p-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="fSurname" name="fSurname" placeholder="Укажите фамилию (часть)..." value="{{ $filter['fSurname'] }}"></td>
                        </tr>
                        <tr>
                            <td class="text-right">Должность</td>
                            <td><select size="1" name="fidPosition" id="fidPosition" class="form-control block w-full h-min p-1 text-base border border-solid border-gray-300">
                            <option {{empty($filter['fidPosition']) ? 'selected' : ''}} value=0>По всем</option>
                            @foreach($guides['positions'] as $item)
                            <option value="{{ $item->id }}" {{$filter['fidPosition']==$item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                            @endforeach
                        </select></td>
                        </tr>
                    </table>
                    <div>
                        <button type="submit" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-base text-gray-700 tracking-widest shadow-sm hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Применить
                        </button>
                        <button type="button" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-base text-gray-700 tracking-widest shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" data-bs-dismiss="modal">
                            Закрыть
                        </button>                  
                    </div>
                </form>

              </div>
            </div>
          </div>
        </div>
        <div class="sm:w-auto sm:flex sm:inline-flex sm:items-center">
            <form action="{{ route('export.teachers') }}" class="w-full" method="GET">
                <input type="hidden" id="fSurname" name="fSurname" value="{{ $filter['fSurname'] }}">
                <input type="hidden" id="fidInstitution" name="fidInstitution" value="{{ $filter['fidInstitution'] }}"> 
                <input type="hidden" id="fidPosition" name="fidPosition" value="{{ $filter['fidPosition'] }}"> 
                <button type="submit" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-base text-gray-700 tracking-widest shadow-sm hover:bg-sky-200 disabled:opacity-25 transition ease-in-out duration-150">Excel</button>
            </form>
        </div>



    </div>


    <div class="py-2">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-8xl">
                    <table class="w-full ">
                        <thead class="border border-solid bg-gray-800 text-white px-6">
                            <th class="border border-solid">Фамилия</th>
                            <th class="border border-solid">Имя</th>
                            <th class="border border-solid">Отчество</th>
                            <th class="border border-solid">Должность</th>
                            <th class="border border-solid">Место работы</th>
                            <th colspan="2" class="border border-solid">Всего курсов (часов)</th>
                            <th colspan="2" class="border border-solid">Курсов в Фед. реестре (часов)</th>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                        <tr class="border odd:bg-white even:bg-slate-100 hover:bg-gray-100">
                            <td class="border">{{ $item->surname }}</td>
                            <td class="border">{{ $item->name }}</td>
                            <td class="border">{{ $item->patronymic }}</td>
                            <td class="border">
                                @if (!empty($item->idPositions))
                                {{ $item->position->name }}
                                @endif
                            </td>
                            <td class="border">
                                @if (!empty($item->idInstitutions))
                                {{ $item->institution->fullname }}
                                @endif
                            </td>
                            <td class="border text-center">{{ $item->courses->count('id') }}</td>
                            <td class="border text-center">{{ $item->courses->sum('hours') }}</td>
                            <td class="border text-center">{{ $item->courses->sum('isFederal') }}</td>
                            <td class="border text-center">{{ $item->courses->where('isFederal','>','0')->sum('hours')}}</td>
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