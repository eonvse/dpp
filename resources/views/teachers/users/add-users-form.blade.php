            <div class="flex sm:inline-block">
            <div class="">
                <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" data-bs-toggle="modal" data-bs-target="#addUsers">Добавить
                </button>
            </div>

            <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="addUsers" tabindex="-1" aria-labelledby="addUsers" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                                Добавить пользователя
                            </h5>
                            <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
          data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{ route('users.add') }}" enctype="multipart/form-data">
                            @csrf

                        <div class="modal-body relative p-4">
                           <div>
                                <x-input-label for="name" :value="__('Логин (имя)')" />

                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />

                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />

                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="addPassword" :value="__('Пароль')" />

                                <x-text-input id="addPassword" class="block mt-1 w-full"
                                                type="text"
                                                name="addPassword"
                                                value="q1w2e3r4"
                                                required />

                                <x-input-error :messages="$errors->get('addPassword')" class="mt-2" />
                            </div>

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
