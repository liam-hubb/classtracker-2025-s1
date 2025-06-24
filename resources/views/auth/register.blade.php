<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="given_name" :value="__('Given Name')" />
            <x-text-input id="given_name" class="block mt-1 w-full" type="text" name="given_name" :value="old('given_name')" required autofocus autocomplete="given_name" />
            <x-input-error :messages="$errors->get('given_name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="family_name" :value="__('Family Name')" />
            <x-text-input id="family_name" class="block mt-1 w-full" type="text" name="family_name" :value="old('family_name')" required autofocus autocomplete="family_name" />
            <x-input-error :messages="$errors->get('family_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="pronouns" :value="__('Pronouns')" />
            <select id="pronouns" name="pronouns" required
                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="" disabled selected>Select your pronouns</option>
                <option value="she/her/hers" {{ old('pronouns') == 'she/her/hers' ? 'selected' : '' }}>she/her/hers</option>
                <option value="he/him/his" {{ old('pronouns') == 'he/him/his' ? 'selected' : '' }}>he/him/his</option>
                <option value="they/them/theirs" {{ old('pronouns') == 'they/them/theirs' ? 'selected' : '' }}>they/them/theirs</option>
            </select>
            <x-input-error :messages="$errors->get('pronouns')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
