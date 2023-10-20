                            <div class="flex items-center">
                                <svg class="h-6 w-6"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="9" cy="7" r="4" />  <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />  <line x1="19" y1="7" x2="19" y2="10" />  <line x1="19" y1="14" x2="19" y2="14.01" /></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold">Пользователи без персональных данных</div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-normal">
                                    <table class="w-full">
                                    @foreach($usersEmpty as $item)
                                    <tr class="border">
                                        <td>
                                            <span class="font-bold">{{ $item->name }}</span> {{ $item->email }} 
                                            <div class="font-semibold  text-sm text-orange-400">
                                                {{ empty($item->moderatorInstitution->id) ? 'Педагог' : 'Модератор-'.$item->moderatorInstitution->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.personal.add', $item->id) }}" title="{{ $item->name.' Добавить данные' }}" class="flex inline-flex h-8 w-8 my-auto mx-1 text-gray-500 hover:text-green-700"><svg class="h-8 w-8"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M14 3v4a1 1 0 0 0 1 1h4" />  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />  <line x1="12" y1="11" x2="12" y2="17" />  <line x1="9" y1="14" x2="15" y2="14" /></svg></a>
                                        </td>
                                     </tr>
                                    @endforeach 
                                    </table>
                                </div>
                            </div>