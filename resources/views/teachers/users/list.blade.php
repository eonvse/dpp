<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class='inline-block'>
                {{ __('Пользователи') }}
                 @include('teachers.users.add-users-form')
            </h2>        
        </div>
    </x-slot>
    <div class="py-7">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl">
                    <div class="grid grid-cols-1 sm:grid-cols-2 sm:divide-x">
                         <div class="p-6">
                           @include('teachers.users.moderators')
                       </div>
                        <div class="p-6">
                           @include('teachers.users.emptyUsers')
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>