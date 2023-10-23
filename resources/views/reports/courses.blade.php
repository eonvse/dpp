<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class='inline-block'>
                {{ __('Отчет по курсам ДПП.') }}
            </h2>      
        </div>
    </x-slot>
    <div class="text-gray-800 leading-tight block max-w-7xl mx-auto">
        <button type="button" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-base text-gray-700 tracking-widest shadow-sm hover:bg-gray-200 disabled:opacity-25 transition ease-in-out duration-150" data-bs-toggle="modal" data-bs-target="#filterForm">
            Фильтры
        </button>
        <a href="{{ route('report.courses') }}" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-base text-gray-700 tracking-widest shadow-sm hover:bg-rose-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
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
                        @role('admin')
                        <tr>
                            <td class="">Учреждение</td>
                            <td>
                                <select multiple multiselect-max-items="10" name="fInstitutions[]" id="fInstitutions[]" class="form-multiselect block w-full h-min p-1 text-base border border-solid border-gray-300">
                                    <option value=-1 {{ in_array(-1, $institutionIDs) ? 'selected' : '' }}>По всем</option>
                                @foreach($guides['institutions'] as $item)
                                    <option value="{{ $item->id }}" {{ in_array($item->id, $institutionIDs) ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                                </select>  
                            </td>
                        </tr>

                        @endrole
                        <tr>
                            <td class="">Должность</td>
                            <td>
                                <select multiple multiselect-max-items="10" name="fPositions[]" id="fPositions[]" class="form-multiselect block w-full h-min p-1 text-base border border-solid border-gray-300">
                                    <option value=-1 {{ in_array(-1, $positionIDs) ? 'selected' : '' }}>По всем</option>
                                    <option value=0 {{ in_array(0, $positionIDs) ? 'selected' : '' }}>Без должности</option>
                                @foreach($guides['positions'] as $item)
                                    <option value="{{ $item->id }}" {{ in_array($item->id, $positionIDs) ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                                </select>  
                            </td>
                        </tr>

                        <tr>
                            <td class="">Тип ДПП</td>
                            <td>
                                <select size="1" name="fСourseType" id="fСourseType" class="form-control block w-full h-min p-1 text-base border border-solid border-gray-300">
                                    <option {{empty($filter['fСourseType']) ? 'selected' : ''}} value=0>По всем</option>
                                    @foreach($guides['courseType'] as $item)
                                    <option value="{{ $item->id }}" {{$filter['fСourseType']==$item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="">Входит в Фед. реестр</td>
                            <td>
                                <select size="1" name="fIsFederal" id="fIsFederal" class="form-control block w-full h-min p-1 text-base border border-solid border-gray-300">
                                    <option {{empty($filter['fIsFederal']) ? 'selected' : ''}} value="0">По всем</option>
                                    <option value="1" {{$filter['fIsFederal']==1 ? 'selected' : ''}}>Нет</option>
                                    <option value="2" {{$filter['fIsFederal']==2 ? 'selected' : ''}}>Да</option>
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <td class="">Направление ДПП</td>
                            <td>
                                <select multiple multiselect-max-items="10" name="fDirections[]" id="fDirections[]" class="form-multiselect block w-full h-min p-1 text-base border border-solid border-gray-300">
                                    <option value=-1 {{ in_array(-1, $directionIDs) ? 'selected' : '' }}>По всем</option>
                                    <option value=0 {{ in_array(0, $directionIDs) ? 'selected' : '' }}>Без направления</option>
                                @foreach($guides['courseDirections'] as $item)
                                    <option value="{{ $item->id }}" {{ in_array($item->id, $directionIDs) ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                                </select>  
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2" class="">
                                    <div class="">Дата документа</div>
                                </div>
                            </td>
                            <td>
                                <input type="date" class="form-control block w-full h-min p-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="fDateDocStart" name="fDateDocStart" title="Начало периода..." value="{{ $filter['fDateDocStart'] }}"> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="date" class="form-control inline-block w-full h-min p-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="fDateDocEnd" name="fDateDocEnd" title="Конец периода..." value="{{ $filter['fDateDocEnd'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="">
                                    <div class="">Дата заполнения</div>
                                </div>
                            </td>
                            <td>
                                <input type="date" class="form-control block w-full h-min p-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="fDateUpdStart" name="fDateUpdStart" title="Начало периода..." value="{{ $filter['fDateUpdStart'] }}"> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="date" class="form-control inline-block w-full h-min p-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="fDateUpdEnd" name="fDateUpdEnd" title="Конец периода..." value="{{ $filter['fDateUpdEnd'] }}">
                            </td>
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
            <form action="{{ route('export.courses') }}" class="w-full" method="GET">
                <input type="hidden" id="institutionIDs" name="institutionIDs" value="{{ implode(',',$institutionIDs) }}">
                <input type="hidden" id="positionIDs" name="positionIDs" value="{{ implode(',',$positionIDs) }}">
                <input type="hidden" id="fСourseType" name="fСourseType" value="{{ $filter['fСourseType'] }}">
                <input type="hidden" id="fIsFederal" name="fIsFederal" value="{{ $filter['fIsFederal'] }}">
                <input type="hidden" id="directionIDs" name="directionIDs" value="{{ implode(',',$directionIDs) }}">
                <input type="hidden" id="fDateDocStart" name="fDateDocStart" value="{{ $filter['fDateDocStart'] }}"> 
                <input type="hidden" id="fDateDocEnd" name="fDateDocEnd" value="{{ $filter['fDateDocEnd'] }}"> 
                <input type="hidden" id="fDateUpdStart" name="fDateUpdStart" value="{{ $filter['fDateUpdStart'] }}"> 
                <input type="hidden" id="fDateUpdEnd" name="fDateUpdEnd" value="{{ $filter['fDateUpdEnd'] }}"> 
                <button type="submit" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-base text-gray-700 tracking-widest shadow-sm hover:bg-sky-200 disabled:opacity-25 transition ease-in-out duration-150">Excel</button>
            </form>
        </div>
        <div class="text-sm text-sky-800 font-semibold">
            @if(!empty($filter['fIdTeachers'])) 
                {{ $filter['teacher']->surname }} {{ !empty($filter['teacher']->name) ? Str::substr($filter['teacher']->name,0,1).'.' : '' }} {{ !empty($filter['teacher']->patronymic) ? Str::substr($filter['teacher']->patronymic,0,1).'.' : '' }}| 
            @endif

    
            @if (!empty($institutionIDs))
                <span class="font-normal text-gray-500">Учреждения:</span>
                @if (!empty(in_array(-1, $institutionIDs)))
                По всем
                @else
                    @foreach($guides['institutions'] as $item)
                        @if (in_array($item->id,$institutionIDs))
                        {{ $item->name.'.' }}
                        @endif
                    @endforeach
                @endif
            @endif
            
            @if (!empty($positionIDs))
                <span class="font-normal text-gray-500">Должности:</span>
                @if (!empty(in_array(-1, $positionIDs)))
                По всем
                @else
                    @if (!empty(in_array(0, $positionIDs)))
                    Без должности.
                    @endif
                    @foreach($guides['positions'] as $item)
                        @if (in_array($item->id,$positionIDs))
                        {{ $item->name.'.' }}
                        @endif
                    @endforeach
                @endif
            @endif

            @if(!empty($filter['fСourseType'])) 
                <span class="font-normal text-gray-500">Тип ДПП:</span> {{ $guides['courseType']->where('id','=',$filter['fСourseType'])->first()->name }}.
            @endif

            @if(!empty($filter['fIsFederal'])) 
                <span class="font-normal text-gray-500">Входит в Фед. реестр:</span> {{ $filter['fIsFederal']==2 ? 'Да' : 'Нет' }}.
            @endif

            @if (!empty($directionIDs))
                <span class="font-normal text-gray-500">Направление ДПП:</span>
                @if (!empty(in_array(-1, $directionIDs)))
                По всем
                @else
                    @if (!empty(in_array(0, $directionIDs)))
                    Без направления.
                    @endif
                    @foreach($guides['courseDirections'] as $item)
                        @if (in_array($item->id,$directionIDs))
                        {{ $item->name.'.' }}
                        @endif
                    @endforeach
                @endif
            @endif


            @if(!empty($filter['fDateDocStart'])) 
                <span class="font-normal text-gray-500">Дата с:</span> {{ date('d.m.Y', strtotime($filter['fDateDocStart'])) }}.
            @endif

            @if(!empty($filter['fDateDocEnd'])) 
                <span class="font-normal text-gray-500">Дата по:</span> {{ date('d.m.Y', strtotime($filter['fDateDocEnd'])) }}.
            @endif

            @if(!empty($filter['fDateUpdStart'])) 
                <span class="font-normal text-gray-500">Заполнено с:</span> {{ date('d.m.Y', strtotime($filter['fDateUpdStart'])) }}.
            @endif

            @if(!empty($filter['fDateUpdEnd'])) 
                <span class="font-normal text-gray-500">Заполнено по:</span> {{ date('d.m.Y', strtotime($filter['fDateUpdEnd'])) }}.
            @endif

        </div>

    </div>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="max-w-8xl">
                    <table class="w-full ">
                        <thead class="border border-solid bg-gray-800 text-white px-6">
                            <th colspan="3" class="border border-solid">Педагог<br>(ФИО. Учреждение. Должность.)</th>
                            <th class="border border-solid">Тип ДПП</th>
                            <th class="border border-solid">Часов ДПП</th>
                            <th class="border border-solid">Наименование ОУ,<br />выдавшего документ</th>
                            <th class="border border-solid">Входит<br /> в Федеральный реестр</th>
                            <th class="border border-solid">Наименование ДПП</th>
                            <th class="border border-solid">Направление ДПП</th>
                            <th class="border border-solid">Тип/Дата документа</p></th>
                            <th class="border border-solid">Дата заполнения</th>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                        <tr class="border odd:bg-white even:bg-slate-100 hover:bg-gray-100">
                            <td class="border">
                                {{ $item->Teacher->surname }} {{ !empty($item->Teacher->name) ? $item->Teacher->name : '' }} {{ !empty($item->Teacher->patronymic) ? $item->Teacher->patronymic : '' }}
                            </td>
                            <td>
                               {{ !empty($item->Teacher->institution->name) ? $item->Teacher->institution->name : '' }} 
                            </td>
                            <td>
                               {{ !empty($item->Teacher->position->name) ? $item->Teacher->position->name : '' }} 
                            </td>
                            <td class="border">
                                @if (!empty($item->idType))
                                {{ $item->courseType->name }}
                                @endif
                            </td>
                            <td class="border text-center">{{ $item->hours }}</td>
                            <td class="border">{{ $item->fullName }}</td>
                            <td class="border text-center">{{ !empty($item->isFederal) ? 'Да' : 'Нет' }}</td>
                            <td class="border">{{ $item->progName }}</td>
                            <td class="border text-center">
                                @if (!empty($item->courseDirection->name))
                                {{ $item->courseDirection->name }}
                                @endif
                            </td>
                            <td class="border text-center">
                                @if (!empty($item->idTypeDoc))
                                <p>{{ $item->courseTypeDoc->name }}</p>
                                @endif 
                                @if (!empty($item->dateDoc))
                                <p>{{ date('d.m.Y', strtotime($item->dateDoc)) }}</p>
                                @endif
                            </td>
                            <td class="border text-center">
                                {{ date('d.m.Y', strtotime($item->updated_at))}}
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