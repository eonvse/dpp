<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Персональные данные</h2>
        <p class="mt-1 text-sm text-gray-600">Редактирование своих персональных данных.</p>
        @if (session('status') === 'personal-empty')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 10000)"
            class="text-red-600"
        >Для работы со своими курсами заполните Персональные данные.</p>
        @endif
    </header>

    <form method="post" action="{{ route('profile.update.personal') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="surname" :value="__('Фамилия')" />
            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full" :value="old('surname', $user->teacher->surname ?? '')" required autofocus autocomplete="surname" />
            <x-input-error class="mt-2" :messages="$errors->get('surname')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Имя')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->teacher->name ?? '')" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="patronymic" :value="__('Отчество')" />
            <x-text-input id="patronymic" name="patronymic" type="text" class="mt-1 block w-full" :value="old('patronymic', $user->teacher->patronymic ?? '')" autofocus autocomplete="patronymic" />
            <x-input-error class="mt-2" :messages="$errors->get('patronymic')" />
        </div>
    
        <div>
            <x-input-label for="patronymic" :value="__('Должность')" />
                <select size="1" name="idPositions" id="idPositions" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    <option {{ empty($user->teacher->idPositions) ? 'selected' : '' }} value=0>Без указания</option>
                    @foreach($guides['positions'] as $item)
                        <option value="{{ $item->id }}" {{ !empty($user->teacher->idPositions)&&$item->id==$user->teacher->idPositions ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>    
        </div>
        <div>
            <x-input-label for="idInstitutions" :value="__('Учреждение')" />
                <select size="1" name="idInstitutions" id="idInstitutions" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    <option {{ empty($user->teacher->idInstitutions) ? 'selected' : '' }} value=0>Без указания</option>
                    @foreach($guides['institutions'] as $item)
                        <option value="{{ $item->id }}" {{ !empty($user->teacher->idInstitutions)&&$item->id==$user->teacher->idInstitutions ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>  
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>

            @if (session('status') === 'profile-updated-personal')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >Сохранено.</p>
            @endif
        </div>
    </form>
</section>
