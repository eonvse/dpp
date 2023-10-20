<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center sm:text-left font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('teachers.personal')}}" class="px-2 py-1 text-sky-800 hover:text-sky-500 hover:underline hover:underline-offset-8">{{ __('Персональная информация') }}</a>
            {{ empty($data) ? 'Добавить' : 'Редактировать' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                        <form method="post" action="{{ route('teachers.personal.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="idUser" name="idUser" value="{{ Auth::user()->id }}">
                            <input type="hidden" id="id" name="id" value="{{ !empty($data) ? $data->id : 0 }}" />
                            <table class="table-auto my-3">
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Фамилия</td>
                                    <td class="block md:table-cell px-2">
                                        <input type="text" class="
        form-control
        block
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
      " id="surname" name="surname" value ="{{ Arr::exists($data, 'surname') ? $data->surname : '' }}" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Имя</td>
                                    <td class="block md:table-cell px-2">
                                        <input type="text" class="
        form-control
        block
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
      " id="name" name="name" value="{{ Arr::exists($data, 'name') ? $data->name : '' }}" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Отчество</td>
                                    <td class="block md:table-cell px-2">
                                        <input type="text" class="
        form-control
        block
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
      " id="patronymic" name="patronymic" value="{{ Arr::exists($data, 'patronymic') ? $data->patronymic : '' }}"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Должность</td>
                                    <td class="block md:table-cell px-2">
                                        <select size="1" name="idPositions" id="idPositions" class="form-select appearance-none
      block
      w-full
      px-3
      py-1.5
      text-base
      font-normal
      text-gray-700
      bg-white bg-clip-padding bg-no-repeat
      border border-solid border-gray-300
      rounded
      transition
      ease-in-out
      m-0
      focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                            <option {{ empty($data->idPositions) ? 'selected' : '' }} value=0>Без указания</option>
                                            @foreach($positions as $item)
                                            <option value="{{ $item->id }}" {{ !empty($data->idPositions)&&$item->id==$data->idPositions ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Учреждение</td>
                                    <td class="block md:table-cell px-2">
                                        <select size="1" name="idInstitutions" id="idInstitutions" class="fform-select appearance-none
      block
      w-full
      px-3
      py-1.5
      text-base
      font-normal
      text-gray-700
      bg-white bg-clip-padding bg-no-repeat
      border border-solid border-gray-300
      rounded
      transition
      ease-in-out
      m-0
      focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                            <option {{ empty($data->idInstitutions) ? 'selected' : '' }} value=0>Без указания</option>
                                            @foreach($institutions as $item)
                                            <option value="{{ $item->id }}" {{ !empty($data->idInstitutions)&&$item->id==$data->idInstitutions ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Документ об образовании</td>
                                    <td class="block md:table-cell px-2">
                                        <select size="1" name="idType" id="idType" class="form-select appearance-none
      block
      w-full
      px-3
      py-1.5
      text-base
      font-normal
      text-gray-700
      bg-white bg-clip-padding bg-no-repeat
      border border-solid border-gray-300
      rounded
      transition
      ease-in-out
      m-0
      focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                            <option {{ empty($data->idType) ? 'selected' : '' }} value=0>Без указания</option>
                                            @foreach($types as $item)
                                            <option value="{{ $item->id }}" {{ !empty($data->idType)&&$item->id==$data->idType ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Дата получения</td>
                                    <td class="block md:table-cell px-2">
                                        <input type="date" id="dateDoc" name="dateDoc" value ="{{ Arr::exists($data, 'dateDoc') ? $data->dateDoc : '' }}" class="
        form-control
        block
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
      "/>
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="border-solid border border-green-500 rounded bg-green-100 hover:bg-green-200 p-2">Сохранить</button>
                            <a href="{{ route('teachers.personal') }}" class="border-solid border border-gray-500 rounded bg-red-100 hover:bg-red-200 p-2">Отменить</a>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>