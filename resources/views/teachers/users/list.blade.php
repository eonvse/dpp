<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class='inline-block'>
                {{ __('Пользователи') }}
                 @include('teachers.users.add-users-form')
            </h2>        
        </div>
    </x-slot>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-2 sm:p-4 bg-white shadow sm:rounded-lg">
                <livewire:control-user /> 
            </div>
        </div>
    </div>



</x-app-layout>