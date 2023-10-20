<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Личный кабинет') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="sm:p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                    
                    @include('blocks.dashboard.mobile-menu')

                    @include('blocks.memo.user')

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
