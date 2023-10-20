<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Справочник учреждений') }}
            <div class="flex sm:inline-block"><a href="{{ route('institutions.create')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Добавить') }}</a></div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    
                    <div class="w-full sm:grid sm:grid-cols-4">
                        <div class="font-bold mx-5">Наименование</div>
                        <div class="font-bold mx-5">Полное наименование</div>
                        <div class="font-bold mx-5 text-right">Модератор</div>
                        <div class="text-center mx-auto"><svg class="h-7 w-7 text-black"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />  <circle cx="12" cy="12" r="3" /></svg></div>
                    </div>
                        @foreach($data as $item)
                        <div class="w-full sm:grid sm:grid-cols-4 odd:bg-white even:bg-slate-100 border border-slate-200">
                            <div class="font-bold">{{ $item->name }}</div> 
                            <div class="">{{ $item->fullname }}</div>
                            <div class="text-xs text-right">
                                @if (!empty($item->idModerator))
                                {{ $item->user_name }} ({{ $item->email }})
                                @endif
                            </div>  
                            <div class="flex flex-1 text-center mx-auto">
                                <x-link-edit :href="route('institutions.edit', $item->id)" :title="$item->name.' Редактировать'"></x-link-edit>
                                <x-link-del :href="route('institutions.delete', $item->id)" :title="$item->name.' Удалить'"></x-link-del>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>