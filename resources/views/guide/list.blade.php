<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Справочники') }}</h2>
            <div class="">
                <span class="block text-center">
                    <hr />
                    {{ __('Педагоги')}}
                    <hr />
                </span>
                <a href="{{ route('positions.list')}}" class="block text-center m-3 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Должности') }}</a>
                <a href="{{ route('institutions.list')}}" class="block text-center m-3 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Учреждения') }}</a>
                <span class="block text-center">
                    <hr />
                    {{ __('Курсы ДПП')}}
                    <hr />
                </span>

                <a href="{{ route('directions.list')}}" class="block text-center m-3 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Направления ДПП') }}</a>
                <a href="{{ route('courseTypes.list')}}" class="block text-center m-3 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Типы ДПП') }}</a>
            </div>
    </x-slot>
</x-app-layout>