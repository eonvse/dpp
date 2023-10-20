<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class='inline-block'>
                {{ __('Курсы ДПП') }}
                @if(!empty($filter['fIdTeachers'])) 
                ({{ $filter['teacher']->surname }} {{ !empty($filter['teacher']->name) ? Str::substr($filter['teacher']->name,0,1).'.' : '' }} {{ !empty($filter['teacher']->patronymic) ? Str::substr($filter['teacher']->patronymic,0,1).'.' : '' }})
                @endif
            </h2>      
            <div class="flex sm:inline-block">
                <a href="{{ !empty($filter['fIdTeachers']) ? './courses/create?fIdTeachers='.$filter['fIdTeachers'] : route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ 'Добавить' }}</a>
            </div>
        </div>
    </x-slot>
    <div 
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 800)"
        class="fixed inset-auto flex justify-center items-center space-x-2">
      <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full text-sky-800" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div class="text-gray-800 leading-tight block max-w-7xl mx-auto my-2">
        <button type="button" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-base text-gray-700 tracking-widest shadow-sm hover:bg-gray-200 disabled:opacity-25 transition ease-in-out duration-150" data-bs-toggle="modal" data-bs-target="#filterForm">
            Фильтры
        </button>
        <a href="{{ route('courses.list') }}" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1 my-2 bg-white border border-gray-300 rounded-md font-semibold text-base text-gray-700 tracking-widest shadow-sm hover:bg-rose-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
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
                            <td><select size="1" name="fCourseDirections" id="fCourseDirections" class="form-control block w-full h-min p-1 text-base border border-solid border-gray-300">
                            <option {{empty($filter['fCourseDirections']) ? 'selected' : ''}} value=0>По всем</option>
                            @foreach($guides['courseDirections'] as $item)
                            <option value="{{ $item->id }}" {{$filter['fCourseDirections']==$item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                            @endforeach
                        </select></td>
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
        <div class="text-sm text-sky-800 font-semibold">
            @if(!empty($filter['fIdTeachers'])) 
                {{ $filter['teacher']->surname }} {{ !empty($filter['teacher']->name) ? Str::substr($filter['teacher']->name,0,1).'.' : '' }} {{ !empty($filter['teacher']->patronymic) ? Str::substr($filter['teacher']->patronymic,0,1).'.' : '' }}| 
            @endif

            @if(!empty($filter['fСourseType'])) 
                <span class="font-normal text-gray-500">Тип ДПП:</span> {{ $guides['courseType']->where('id','=',$filter['fСourseType'])->first()->name }}.
            @endif

            @if(!empty($filter['fIsFederal'])) 
                <span class="font-normal text-gray-500">Входит в Фед. реестр:</span> {{ $filter['fIsFederal']==2 ? 'Да' : 'Нет' }}.
            @endif

            @if(!empty($filter['fCourseDirections'])) 
                <span class="font-normal text-gray-500">Направление ДПП:</span> {{ $guides['courseDirections']->where('id','=',$filter['fCourseDirections'])->first()->name }}.
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
    <div class="py-3">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="max-w-8xl">
                    <div class="text-sm text-gray-600 w-full sm:grid sm:grid-cols-12">
                        <div class="font-bold"><span class="hover:text-sky-500">@sortablelink('fullName','Наименование ОУ')</span></div>
                        <div class="col-span-4 font-bold">
                            <span class="hover:text-sky-500">@sortablelink('progName','Наименование ДПП')</span><br>
                            <span class="hover:text-sky-500">@sortablelink('courseType.name','Тип ДПП')</span> - 
                            <span class="hover:text-sky-500">@sortablelink('courseDirection.name','Направление ДПП')</span>
                        </div>
                        <div class="font-bold text-center">Фед. реестр</div>
                        <div class="font-bold text-center">
                            <span class="hover:text-sky-500">@sortablelink('courseTypeDoc.name','Тип документа')</span><br>
                            <span class="hover:text-sky-500">@sortablelink('dateDoc','Дата получения')</span></div>
                        <div class="font-bold text-center">Часов</div>
                        <div class="col-span-2 font-bold">Педагог
                            <!--<span class="hover:text-sky-500">
                                @sortablelink('Teacher.surname','Педагог')
                            </span>-->
                        </div>
                        <div class="text-xs font-bold text-right">Автор/Редактор<br>
                            <span class="hover:text-sky-500">@sortablelink('updated_at','Дата заполнения')</span></div>
                        <div class="text-center mx-auto"><svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />  <circle cx="12" cy="12" r="3" /></svg></div>
                    </div>
                    @foreach($data as $item)
                    <div class="text-xs w-full sm:grid sm:grid-cols-12 odd:bg-white even:bg-slate-100 border border-slate-200">
                        <div class=""><span title="{{ $item->fullName }}">{{ Str::substr($item->fullName,0,50) }}</span></div> 
                        <div class="col-span-4"><span class="text-sm font-semibold">{{ $item->progName }}</span><br>
                            <div class="">
                                @if (!empty($item->idType))
                                    {{ $item->courseType->name }}
                                @endif                                
                                @if (!empty($item->idDirections))
                                    - {{ $item->courseDirection->name }}
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-center"> 
                            <div class=""><input id="isFederal" type="checkbox" class="form-check-input appearance-none h-4 w-4 border border-gray-600 rounded-sm bg-white checked:bg-black checked:border-black focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2" name="isFederal" {{ !empty($item->isFederal) ? 'checked' : '' }} disabled /></div>
                        </div>
                        <div class="text-center">
                            @if (!empty($item->idTypeDoc))
                                {{ $item->courseTypeDoc->name }}
                            @endif 
                            @if (!empty($item->dateDoc))
                                <br>{{ date('d.m.Y', strtotime($item->dateDoc))}}
                            @endif
                        </div>
                        <div class="text-center">
                            @if (!empty($item->hours))
                                {{ $item->hours }}
                            @endif
                        </div>                            
                        <div class="col-span-2">
                            <form method="get" action="{{ route('teachers.list') }}" enctype="multipart/form-data">
                            @csrf
                                <input type="hidden" name="fIdTeachers" id="fIdTeachers" value="{{ $item->Teacher->id }}" />
                                <button type="submit" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-2 py-1  bg-white font-semibold text-xs tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">{{ $item->Teacher->surname }} {{ !empty($item->Teacher->name) ? Str::substr($item->Teacher->name,0,1).'.' : '' }} {{ !empty($item->Teacher->patronymic) ? Str::substr($item->Teacher->patronymic,0,1).'.' : '' }}</button>
                            </form>
                            <span>{{ !empty($item->Teacher->position->name) ? $item->Teacher->position->name : '' }} 
                                @role('admin')
                                {{ !empty($item->Teacher->institution->name) ? $item->Teacher->institution->name : '' }}
                                @endrole
                            </span>
                                
                        </div> 
                        <div class="text-xs text-right">
                            @if (!empty($item->idAutor))
                                {{ $item->Autor->name ?? '' }} 
                                @if ($item->idAutor != $item->idUpdater)
                                /<br> {{ $item->Updater->name ?? '' }}
                                @endif
                                <br> {{ date('d.m.Y', strtotime($item->updated_at))}}
                            @endif
                        </div>
                        <div class="flex flex-1 text-center mx-auto">
                        @if(empty($filter['fIdTeachers']))
                            <x-link-edit :href="route('courses.edit', [$item->id, 0])" :title="'Редактировать '.$item->progName"></x-link-edit>
                            <x-link-del :href="route('courses.delete', [$item->id,0])" :title="'Удалить '.$item->progName"></x-link-del>
                        @else
                            <x-link-edit :href="route('courses.edit', ['id'=>$item->id, 'idTeachers'=>$item->idTeachers])" :title="'Редактировать '.$item->progName"></x-link-edit>
                            <x-link-del :href="route('courses.delete', ['id'=>$item->id, 'idTeachers'=>$item->idTeachers])" :title="'Удалить '.$item->progName"></x-link-del>
                        @endif
                        </div>
                    </div>
                    @endforeach
                    <div>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-link-top></x-link-top>
</x-app-layout>