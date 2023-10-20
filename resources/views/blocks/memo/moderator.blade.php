                    <div class="border-t border-gray-200 sm:border-none flex items-center">
                        <svg class="h-8 w-8 text-gray-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <div class="ml-4 text-lg leading-7 font-semibold">Памятка для модератора</div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-800 dark:text-gray-400 text-lg">
                            <div class="accordion" id="accordionMemo">
                                <div class="accordion-item bg-white border border-gray-200">
                                    <h2 class="accordion-header mb-0" id="memo_user">
                                        <button class="accordion-button collapsed relative flex items-center w-full py-4 px-5 text-base text-gray-800 text-left bg-white border-0 rounded-none transition focus:outline-none font-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#memoUser" aria-expanded="true" aria-controls="memoUser">
                                            Личные курсы и профиль
                                        </button>
                                    </h2>
                                    <div id="memoUser" class="accordion-collapse collapse" aria-labelledby="memo_user">
                                        <div class="accordion-body py-4 px-5">
                                            @include('blocks.memo.user')
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item bg-white border border-gray-200">
                                    <h2 class="accordion-header mb-0" id="memo_teachers">
                                        <button class="accordion-button collapsed relative flex items-center w-full py-4 px-5 text-base text-gray-800 text-left bg-white border-0 rounded-none transition focus:outline-none font-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#memoTeashers" aria-expanded="false" aria-controls="memoTeashers">
                                            Управление списком педагогов
                                        </button>
                                    </h2>
                                    <div id="memoTeashers" class="accordion-collapse collapse" aria-labelledby="memo_teachers">
                                        <div class="accordion-body py-4 px-5">
                                            <p class="font-semibold p-3 text-center">Возможности управления списком педагогов</p>
                                            <img src="{{ asset('img/modTeachers02.png') }}" class="my-5">
                                            <ol class="list-decimal px-10">
                                                <li>Добавить нового педагога</li>
                                                <li>Применить к списку фильтры, указанные в строке «Фильтры»</li>
                                                <li>Сбросить все фильтры </li>
                                                <li>Добавить курс по педагогу</li>
                                                <li>Показать все курсы педагога</li>
                                                <li>Добавить учетные данные для входа (email, пароль, логин)</li>
                                                <li>Редактировать персональные данные педагога</li>
                                                <li>Удалить педагога</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item bg-white border border-gray-200">
                                    <h2 class="accordion-header mb-0" id="memo_courses">
                                        <button class="accordion-button collapsed relative flex items-center w-full py-4 px-5 text-base text-gray-800 text-left bg-white border-0 rounded-none transition focus:outline-none font-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#memoCourses" aria-expanded="false" aria-controls="memoCourses">
                                            Управление списком курсов ДПП
                                        </button>
                                    </h2>
                                    <div id="memoCourses" class="accordion-collapse collapse" aria-labelledby="memo_courses">
                                        <div class="accordion-body py-4 px-5">
                                            <p class="font-semibold p-3 text-center">Возможности управления списком курсов ДПП</p>
                                            <img src="{{ asset('img/modCourses02.png') }}" class="my-5">
                                            <ol class="list-decimal px-10">
                                                <li>Добавить новый курс ДПП</li>
                                                <li>Применить к списку фильтры, указанные в строке «Фильтры»</li>
                                                <li>Сбросить все фильтры (показать весь список курсов ДПП при режиме просмотра курсов по педагогу)</li>
                                                <li>Полное наименование ОУ при наведении указателя мыши. По умолчанию в столбце отображается 50 символов наименования.</li>
                                                <li>Открыть информацию по педагогу</li>
                                                <li>Редактировать курс ДПП</li>
                                                <li>Удалить курс ДПП</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item bg-white border border-gray-200">
                                    <h2 class="accordion-header mb-0" id="memo_reports">
                                        <button class="accordion-button collapsed relative flex items-center w-full py-4 px-5 text-base text-gray-800 text-left bg-white border-0 rounded-none transition focus:outline-none font-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#memoReports" aria-expanded="false" aria-controls="memoReports">
                                            Работа с отчетами
                                        </button>
                                    </h2>
                                    <div id="memoReports" class="accordion-collapse collapse" aria-labelledby="memo_reports">
                                        <div class="accordion-body py-4 px-5">
                                            <p class="font-semibold p-3 text-center">Возможности отчетов</p>
                                            <img src="{{ asset('img/modReports01.png') }}" class="my-5">
                                            <ol class="list-decimal px-10">
                                                <li>Открыть окно с настройками фильтров для текущей таблицы</li>
                                                <li>Сбросить все фильтры</li>
                                                <li>Выгрузить таблицу в Excel (с учетом применённых фильтров)</li>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <a href="#" id="back2Top" title="Вернуться к началу" class="fixed bottom-1 right-1"><svg class="h-8 w-8 text-gray-500 border border-gray-400 hover:border-sky-800 rounded hover:bg-gray-200 hover:text-sky-800"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="6 15 12 9 18 15" /></svg></a>
