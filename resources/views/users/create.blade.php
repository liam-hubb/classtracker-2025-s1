<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users Management') }}
        </h2>
    </x-slot>

    @auth
        <x-flash-message :data="session()"/>
    @endauth

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h3 class="text-xl font-bold mb-6">Create Users</h3>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger text-red-600">
                            There were some problems with your input.<br><br>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <form action="{{ route('users.store') }}"
                              method="POST"
                              class="flex gap-4">

                            @csrf

                            <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                                <header
                                    class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                                    <p class="col-span-1 px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                        Enter new user's details
                                    </p>
                                </header>

                                <section
                                    class="py-4 px-6 border-b border-neutral-200 bg-gray-100 font-medium text-zinc-800 dark:border-white/10">

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="given_name">
                                            Given Name
                                        </x-input-label>
                                        <x-text-input id="given_name" name="given_name" value="{{ old('given_name') }}"/>
                                        <x-input-error :messages="$errors->get('given_name')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="family_name">
                                            Family Name
                                        </x-input-label>
                                        <x-text-input id="family_name" name="family_name" value="{{ old('family_name') }}"/>
                                        <x-input-error :messages="$errors->get('family_name')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="preferred_name">
                                            Preferred Name
                                        </x-input-label>
                                        <x-text-input id="preferred_name" name="preferred_name" value="{{ old('preferred_name') }}"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="pronouns">
                                            Pronouns
                                        </x-input-label>
                                        <select id="pronouns" name="pronouns" multiple size="3" class="rounded-md shadow-sm border-gray-300">
                                            <option value="she/her/hers">she/her/hers</option>
                                            <option value="he/him/his">he/him/his</option>
                                            <option value="they/them/theirs">they/them/theirs</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('pronouns')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="email">
                                            Email
                                        </x-input-label>
                                        <x-text-input id="email" name="email" value="{{ old('email') }}"/>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="password">
                                            Password
                                        </x-input-label>
                                        <x-text-input type="password" id="password" name="password"/>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="password_confirmation">
                                            Confirm password
                                        </x-input-label>
                                        <x-text-input type="password" id="password_confirmation" name="password_confirmation" />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>

                                </section>

                                <footer
                                    class="flex gap-4 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">

                                    <x-primary-link-button href="{{ route('users.index') }}" class="bg-zinc-800">
                                        Cancel
                                    </x-primary-link-button>

                                    <x-primary-button type="submit" class="bg-zinc-800">
                                        Save
                                    </x-primary-button>
                                </footer>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


