<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center sm:text-left font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('courses.personal')}}" class="px-2 py-1 text-sky-800 hover:text-sky-500 hover:underline hover:underline-offset-8">{{ __('Мои курсы') }}</a>{{ __('Добавить') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                        <form method="post" action="{{ route('courses.personal.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="idTeachers" id="idTeachers" value="{{ $idTeachers }}">
                               <table class="table-auto my-3">
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Полное наименование ОУ,<br /> выдавшего документ</td>
                                    <td class="block md:table-cell px-2">
                                        <!-- <textarea class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="fullName" name="fullName" rows="2"required></textarea>-->
                                        <input list="fullNameList" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="fullName" name="fullName" autocomplete="off" required>
                                        <datalist id="fullNameList" class="w-full">
                                            @foreach($nameList as $item)
                                            <option value="{{ $item->fullName }}" class="w-full"></option>
                                            @endforeach
                                        </datalist>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Наименование ДПП</td>
                                    <td class="block md:table-cell px-2">
                                        <textarea class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="progName" name="progName" rows="2"required></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Входит в Федеральный реестр</td>
                                    <td class="block md:table-cell px-2">
                                        <input id="isFederal" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="isFederal" value="1">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Тип ДПП</td>
                                    <td class="block md:table-cell px-2">
                                        <select size="1" name="idType" id="idType" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                            <option selected value=0>Без указания</option>
                                            @foreach($types as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Тип документа</td>
                                    <td class="block md:table-cell px-2">
                                        <select size="1" name="idTypeDoc" id="idTypeDoc" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                            <option {{ empty($data->idTypeDoc) ? 'selected' : '' }} value=0>Без указания</option>
                                            @foreach($typeDoc as $item)
                                            <option {{ !empty($data->idTypeDoc) && $data->idTypeDoc==$item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Направление ДПП</td>
                                    <td class="block md:table-cell px-2">
                                        <select size="1" name="idDirections" id="idDirections" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                            <option selected value=0>Без указания</option>
                                            @foreach($directions as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Дата документа</td>
                                    <td class="block md:table-cell px-2">
                                        <input type="date" id="dateDoc" name="dateDoc" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Кол-во часов</td>
                                    <td class="block md:table-cell px-2">
                                        <input type="number" id="hours" name="hours" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="border-solid border border-green-500 rounded bg-green-100 hover:bg-green-200 p-2">Добавить</button>
                            <a href="{{ route('courses.personal') }}" class="border-solid border border-gray-500 rounded bg-red-100 hover:bg-red-200 p-2">Отменить</a>
                        </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>