<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center sm:text-left font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('courseTypes.list')}}" class="px-2 py-1 text-sky-800 hover:text-sky-500 hover:underline hover:underline-offset-8">{{ __('Типы ДПП') }}</a>
            {{ __('Добавить') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                        <form method="post" action="{{ route('courseTypes.store') }}" enctype="multipart/form-data">
                            @csrf
                               <table class="table-auto my-3">
                                <tr>
                                    <td class="block md:table-cell italic font-light px-2">Название</td>
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
      " id="name" name="name" required/>
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="border-solid border border-green-500 rounded bg-green-100 hover:bg-green-200 p-2">Добавить</button>
                            <a href="{{ route('courseTypes.list') }}" class="border-solid border border-gray-500 rounded bg-red-100 hover:bg-red-200 p-2">Отменить</a>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>