<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ route('welcome') }}">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
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
                <x-input-label for="password" :value="__('Пароль')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Подтверждение пароля')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Согласие на обработку данных-->
            <div class="block mt-4">
                <div class="relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                    <div class="flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalCenteredScrollableLabel">
                            Согласие на обработку персональных данных
                        </h5>
                    </div>
                    <div class="relative p-4">
                        <p class="py-2">Настоящим в соответствии с Федеральным законом № 152-ФЗ «О персональных данных» от 27.07.2006 года Вы подтверждаете свое согласие на обработку персональных данных Управлением образования Администрации города Усть-Илимска и муниципальным казенным учреждением "Центр развития образования" : сбор, систематизацию, накопление, хранение, уточнение (обновление, изменение), использование, передачу. 
                        </p>
                        <p class="py-2">Срок действия согласия является неограниченным.</p> 
                        <p class="py-2">Вы можете в любой момент отозвать настоящее согласие, направив письменное уведомления на адрес: 666683, Иркутская область, город Усть-Илимск, ул. Мечтателей, дом № 28 с пометкой «Отзыв согласия на обработку персональных данных».</p>
                    </div>
                </div>

                <label for="isAgreement" class="inline-flex items-center">
                    <input id="isAgreement" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="isAgreement" value=1 required />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Согласен на обработку персональных данных') }}</span>
                </label>
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Зарегистрированы?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Регистрация') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
