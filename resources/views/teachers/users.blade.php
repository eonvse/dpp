<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class='inline-block'>
                {{ __('Пользователи') }}
            </h2>        
            <!-- <div class="flex sm:inline-block">
                <a href="{{ route('teachers.create')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Добавить') }}</a>
            </div> -->
        </div>
    </x-slot>
    <div class="py-7">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold">Модераторы</div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    @foreach($moderators as $item)
                                        <div>
                                            {{ $item->moderatorInstitution->name }}
                                            {{ empty($item->teacher->id) ? '' : ' - '.$item->teacher->surname.' '.$item->teacher->name }}
                                        </div>
                                        <div><span class="font-bold">{{ $item->name }}</span> {{ $item->email }}</div>
                                        <hr class="py-2">
                                    @endforeach  
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold">Пользователи без персональных данных</div>
                            </div>

                            <div class="ml-12">
                                <div class="hidden  sm:block mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    @foreach($usersEmpty as $item)
                                        <div><span class="font-bold">{{ $item->name }}</span> {{ $item->email }}</div>
                                        <hr class="py-2">
                                    @endforeach 
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>