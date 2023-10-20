<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center sm:text-left font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ empty($idTeachers) ? route('courses.list') : '../../../courses?fIdTeachers='.$idTeachers }}" class="px-2 py-1 text-sky-800 hover:text-sky-500 hover:underline hover:underline-offset-8">{{ __('Курсы ДПП') }}</a>{{ __('Удаление') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                        <form method="post" action="{{ route('courses.delete.confirm') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{ $data->id }}" />
                            @if(!empty($idTeachers))
                                <input type="hidden" name="fIdTeachers" id="fIdTeachers" value="{{ $idTeachers }}">
                            @endif
                               <table class="table-auto my-3">
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Педагог</td>
                                    <td class="block md:table-cell px-2">
                                        {{ $data->Teacher->surname }} {{ !empty($data->Teacher->name) ? Str::substr($data->Teacher->name,0,1).'.' : '' }} {{ !empty($data->Teacher->patronymic) ? Str::substr($data->Teacher->patronymic,0,1).'.' : '' }} {{ !empty($data->Teacher->idInstitutions) ? '|'.$data->Teacher->institution->name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Полное наименование ОУ,<br /> выдавшего документ</td>
                                    <td class="block md:table-cell px-2">
                                        {{ Arr::exists($data, 'fullName') ? $data->fullName : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Наименование ДПП</td>
                                    <td class="block md:table-cell px-2">
                                        {{ Arr::exists($data, 'progName') ? $data->progName : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Входит в Федеральный реестр</td>
                                    <td class="block md:table-cell px-2">
                                        <div class="flex justify-center"><input id="isFederal" type="checkbox" class="form-check-input appearance-none h-4 w-4 border border-gray-600 rounded-sm bg-white checked:bg-black checked:border-black focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2" name="isFederal" {{ !empty($item->isFederal) ? 'checked' : '' }} disabled /></div>
                                    </td>
                                </tr>
                                @if (!empty($data->idType))
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Тип документа</td>
                                    <td class="block md:table-cell px-2">
                                            {{ $data->courseType->name }}
                                    </td>
                                </tr>
                                @endif
                                @if (!empty($data->idDirections))
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Направление ДПП</td>
                                    <td class="block md:table-cell px-2">
                                        {{ $data->courseDirection->name }}
                                    </td>
                                </tr>
                                @endif
                                @if (!empty($data->dateDoc))
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Дата документа</td>
                                    <td class="block md:table-cell px-2">
                                        {{ date('d.m.Y', strtotime($data->dateDoc))}}
                                    </td>
                                </tr>
                                @endif
                                @if (!empty($data->hours)) 
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Кол-во часов</td>
                                    <td class="block md:table-cell px-2">
                                        {{ $data->hours }}
                                    </td>
                                </tr>
                                @endif
                            </table>
                            <button type="submit" class="border-solid border border-gray-500 rounded bg-red-100 hover:bg-red-200 p-2">Удалить</button>
                            <a href="{{ empty($idTeachers) ? route('courses.list') : '../../../courses?fIdTeachers='.$idTeachers }}" class="border-solid border border-green-500 rounded bg-green-100 hover:bg-green-200 p-2">Отменить</a>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>