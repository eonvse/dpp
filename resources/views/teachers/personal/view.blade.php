<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class='inline-block'>{{ __('Персональные данные') }}</h2>        
            <div class="flex sm:inline-block">
                <a href="{{ route('teachers.personal.edit')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ empty($data) ? 'Добавить' : 'Редактировать' }}</a>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (!empty($data))
                    <table class="table-auto my-3">
                        <tr>
                            <td class="block md:table-cell italic font-light px-2">Фамилия</td>
                            <td class="block md:table-cell px-2 font-bold">
                                {{ $data->surname }}
                            </td>
                        </tr>
                        <tr>
                            <td class="block md:table-cell italic font-light px-2">Имя</td>
                            <td class="block md:table-cell px-2 font-bold">
                                {{ $data->name  }}
                            </td>
                        </tr>
                        <tr>
                            <td class="block md:table-cell italic font-light px-2">Отчество</td>
                            <td class="block md:table-cell px-2 font-bold">
                                {{ $data->patronymic }}
                            </td>
                        </tr>
                        <tr>
                            <td class="block md:table-cell italic font-light px-2">Должность</td>
                            <td class="block md:table-cell px-2 font-bold">
                                {{ !empty($data->position->name) ? $data->position->name : '' }}  
                            </td>
                        </tr>
                        <tr>
                            <td class="block md:table-cell italic font-light px-2">Учреждение</td>
                            <td class="block md:table-cell px-2 font-bold">
                                {{ !empty($data->institution->name) ? $data->institution->name : '' }}  
                            </td>
                        </tr>
                        <tr>
                            <td class="block md:table-cell italic font-light px-2">Документ об образовании</td>
                            <td class="block md:table-cell px-2 font-bold">
                                {{ !empty($data->document->name) ? $data->document->name : '' }}  
                            </td>
                        </tr>
                        <tr>
                            <td class="block md:table-cell italic font-light px-2">Дата получения</td>
                            <td class="block md:table-cell px-2 font-bold">
                                {{ !empty($data->dateDoc) ? date('d.m.Y', strtotime($data->dateDoc)) : '' }}
                            </td>
                        </tr>
                    </table>
                    <div>
                        <a href="{{ route('courses.personal') }}" class="block text-center sm:flex sm:inline-flex sm:items-center px-4 py-2 my-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Мои курсы</a>
                        <div class="sm:w-auto sm:flex sm:inline-flex sm:items-center">
                            <form action="{{ route('export.personal') }}" class="w-full" method="GET">
                                <button type="submit" class="w-full block text-center sm:w-auto sm:flex sm:inline-flex sm:items-center px-4 py-2 my-2 bg-white border border-gray-300 rounded-md font-semibold text-xs uppercase text-gray-700 tracking-widest shadow-sm hover:bg-sky-200 disabled:opacity-25 transition ease-in-out duration-150">Excel</button>
                            </form>
                        </div>
                    </div>
                    <div class="italic font-light">Всего курсов: <span class="not-italic font-bold">{{ $data->courses->count('id') }}</span>. Общее количество часов: <span class="not-italic font-bold">{{ $data->courses->sum('hours') }}</span></div>
                    <div class="italic font-light">Из них, входящих в Федеральный реестр: <span class="not-italic font-bold">{{ $data->courses->sum('isFederal') }}</span>. (<span class="not-italic font-bold">{{ $data->courses->where('isFederal','>','0')->sum('hours')}}</span> ч.)</div>
                    <div class="my-2 ml-5 italic font-light">Последние 5 внесённых курсов.</div>
                    <div class="sm:grid sm:grid-cols-4">
                        @if ($data->courses->count('id')>0)
                        <div class="hidden sm:block italic font-light">Наименование ОУ</div>
                        <div class="hidden sm:block italic font-light">Наименование ДПП</div>
                        <div class="hidden sm:block italic font-light">Дата получения</div>
                        <div class="hidden sm:block italic font-light">Часов</div>
                        @foreach($data->courses()->latest()->take(5)->get() as $item)
                        <div><span class="inline-block pr-3 text-xs sm:hidden">Наименование ОУ</span>{{ $item->fullName}}</div>
                        <div><span class="inline-block pr-3 text-xs sm:hidden">Наименование ДПП</span>{{ $item->progName}}</div>
                        <div><span class="inline-block pr-3 text-xs sm:hidden">Дата получения</span>{{ !empty($item->dateDoc) ? date('d.m.Y', strtotime($item->dateDoc)) : ''}}</div>
                        <div><span class="inline-block pr-3 text-xs sm:hidden">Часов</span>{{ !empty($item->hours) ? $item->hours : ''}}</div>
                        @endforeach
                        @endif
                    </div>
                    @else 
                    <div>Информация отсутствует</div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</x-app-layout>