@props['id','head']
    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}" aria-modal="true" role="dialog">       
        <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
            <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        {{ $head }}
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
                                        <option value="{{ $institution['id'] }}">{{ $institution['name'] }}</option>
                                        @endforeach
                                    </select>    
                                </td>
                            </tr>
                            <tr>
                                <td>Модератор</td>
                                <td>
                                   <select size="1" name="idModerator" id="idModerator" class="form-select appearance-none inline-flex w-full px-3 py-1 text-sm font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" required>
                                    @foreach($guides['users'] as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['name'] }} ({{ $user['email'] }})</option>
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
