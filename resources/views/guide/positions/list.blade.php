<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Справочник должностей') }}
            <div class="flex sm:inline-block">
            <div class="">
                <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" data-bs-toggle="modal" data-bs-target="#addPosition">Добавить
                </button>
            </div>

            <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="addPosition" tabindex="-1" aria-labelledby="addPosition" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                                Добавить должность
                            </h5>
                            <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
          data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{ route('positions.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-body relative p-4">
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
                                                          " id="name" name="name" required value="{{ Arr::exists($data, 'name') ? $data->name : '' }}"/>
                                    </td>
                                </tr>
                                </table>

                            </div>
                            <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                                <button type="submit" class="border-solid border border-green-500 rounded bg-green-100 hover:bg-green-200 p-2">
                                    Сохранить
                                </button>
                                <button type="button" class="border-solid border border-gray-500 rounded bg-red-100 hover:bg-red-200 p-2"       data-bs-dismiss="modal">
                                    Отменить
                                </button>
                            </div>        
                        </form>

                    </div>
                </div>
            </div>
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    
                    <div class="w-full flex sm:grid sm:grid-cols-2">
                        <div class="flex-1 font-bold mx-5">Название</div>
                        <div class="flex-1 text-center mx-auto"><svg class="h-7 w-7 text-black"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />  <circle cx="12" cy="12" r="3" /></svg></div>
                    </div>
                        @foreach($data as $item)
                        <div class="w-full flex sm:grid sm:grid-cols-2 odd:bg-white even:bg-slate-100 border border-slate-200">
                            <div class="flex-1 font-bold">{{ $item->name }}</div> 
                            <div class="flex flex-1 text-center mx-auto">
                                <x-link-edit :href="route('positions.edit', $item->id)" :title="$item->name.' Редактировать'"></x-link-edit>
                                <x-link-del :href="route('positions.delete', $item->id)" :title="$item->name.' Удалить'"></x-link-del>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>