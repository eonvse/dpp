
                            <div class="flex items-center">
                                <svg class="h-8 w-8"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    Модераторы
                                    <div class="flex sm:inline-block">
                                    <div class="">
                                        <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" data-bs-toggle="modal" data-bs-target="#addModerator">Добавить
                                        </button>
                                    </div>

                                    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="addModerator" tabindex="-1" aria-labelledby="addModerator" aria-modal="true" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                                            <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                                                <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                                                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                                                        Добавить модератора
                                                    </h5>
                                                    <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                  data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post" action="{{ route('moderator.add') }}" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="modal-body relative p-4">
                                                        <table class="table-auto my-3">
                                                            <tr>
                                                                <td>Учреждение</td>
                                                                <td>
                                                                   <select size="1" name="id" id="id" class="form-select appearance-none inline-flex w-full px-3 py-1 text-sm font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" required>
                                                                        @foreach($guides['institutions'] as $institution)
                                                                        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                                                                         @endforeach
                                                                    </select>    
                                                                </td>
                                                            </tr>
 
                                                            <tr>
                                                                <td>Модератор</td>
                                                                <td>
                                                                   <select size="1" name="idModerator" id="idModerator" class="form-select appearance-none inline-flex w-full px-3 py-1 text-sm font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" required>
                                                                        @foreach($guides['users'] as $user)
                                                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                                         @endforeach
                                                                    </select>    
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </div>
                                                    <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                                                        <button type="submit" class="border-solid border border-green-500 rounded bg-green-100 hover:bg-green-200 p-2">
                                                            Добавить
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
                                </div>
                           </div>

                            <div class="sm:ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-normal">
                                    <table class="w-full">
                                        @foreach($moderators as $item)
                                        <tr class="border">
                                            <td class="block sm:table-cell">
                                                {{ empty($item->tSurname) ? '' : $item->tSurname.' '.$item->tName }}
                                                <span class="font-bold text-orange-400">{{ $item->iName }}</span>
                                                <p><span class="font-bold">{{ $item->name }}</span> {{ $item->email }}</p>
                                            </td>
                                            <td class="block sm:table-cell">
                                                <a class="flex inline-flex h-8 w-8 my-auto mx-1 text-gray-600 hover:text-green-700" data-bs-toggle="collapse" href="{{ '#collapse'.$item->id }}" role="button" aria-expanded="false" aria-controls="{{ 'collapse'.$item->id }}" title="{{ $item->iName.'. Поменять модератора' }}">
                                                    <svg class="h-8 w-8"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                               <div class="flex inline-flex">
                                                <div class="">
                                                    <button type="button" class="inline-flex items-center text-rose-300 hover:text-rose-600" data-bs-toggle="modal" data-bs-target="{{ '#delModerator'.$item->id }}" title="{{ $item->iName.'. Удалить модератора' }}">
                                                        <svg class="h-8 w-8"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="4" y1="7" x2="20" y2="7" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" />  <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />  <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                    </button>
                                                </div>

                                                <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="{{ 'delModerator'.$item->id }}" tabindex="-1" aria-labelledby="{{ 'delModerator'.$item->id }}" aria-modal="true" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                                                        <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                                                            <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                                                                <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                                                                    Удалить модератора
                                                                </h5>
                                                                <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                              data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="post" action="{{ route('moderator.del') }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="id" id="id" value="{{ $item->iid }}">

                                                                <div class="modal-body relative p-4">
                                                                    <table class="table-auto my-3">
                                                                        <tr>
                                                                            <td>Учреждение</td>
                                                                            <td class="font-bold">
                                                                               {{ $item->iName }}
                                                                            </td>
                                                                        </tr>
             
                                                                        <tr>
                                                                            <td>Модератор</td>
                                                                            <td class="font-bold">
                                                                               {{ $item->name }} ({{ $item->email }})
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                </div>
                                                                <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                                                                    <button type="submit" class="border-solid border border-gray-500 rounded bg-red-100 hover:bg-red-200 p-2">Удалить</button>
                                                                    <button type="button" class="border-solid border border-green-500 rounded bg-green-100 hover:bg-green-200 p-2" data-bs-dismiss="modal">
                                                                        Отменить
                                                                    </button>
                                                                </div>        
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="{{ 'collapse'.$item->id }}">
                                            <td colspan="2" class="text-center text-sm">
                                                <span class="font-bold">Выбрать нового модератора:</span>
                                                <form method="post" action="{{ route('moderator.update') }}" enctype="multipart/form-data" class="flex pb-3">
                                                    @csrf
                                                    <input type="hidden" id="id" name="id" value="{{ $item->iid }}" />
                                                    <input type="hidden" id="oldModerator" name="oldModerator" value="{{ $item->id }}" />
                                                    <select size="1" name="idModerator" id="idModerator" class="form-select appearance-none inline-flex w-full px-3 py-1 text-sm font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                                        @foreach($guides['users'] as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                        @endforeach
                                                    </select>    
                                                    <button type="submit" class="inline-flex border-solid border border-green-500 rounded bg-green-100 hover:bg-green-200 p-1 items-center">Сохранить</button>
                                                    <a class="border-solid border border-gray-500 rounded bg-red-100 hover:bg-red-200 p-2" data-bs-toggle="collapse" href="{{ '#collapse'.$item->id }}" role="button" aria-expanded="false" aria-controls="{{ 'collapse'.$item->id }}">Отменить</a>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach  
                                    </table>
                                </div>
                            </div>

