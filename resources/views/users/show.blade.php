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

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold mb-6">Users Detail</h3>
                    </div>

                    <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                        <header
                            class="grid grid-cols-6 border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                            <p class="col-span-1 px-6 py-4 border-b border-zinc-200 dark:border-white/10">Item</p>
                            <p class="col-span-5 px-6 py-4 border-b border-zinc-200 dark:border-white/10">Content</p>
                        </header>

                        <section class="grid grid-cols-6 border-b border-neutral-200 bg-white font-medium text-zinc-800 dark:border-white/10">
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Given Name</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $user->given_name }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Family Name</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $user->family_name }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Preferred Name</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $user->preferred_name }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Pronouns</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $user->pronouns }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Email</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $user->email }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Roles</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                        <label class="px-2 bg-neutral-700 text-neutral-200 rounded-full ">{{ $v }}</label>
                                    @endforeach
                                @endif</p>
                        </section>

                        <footer class="grid gid-cols-1 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">
                            <form action="{{ route('users.destroy', $user) }}"
                                  method="POST"
                                  class="flex gap-4">
                                @csrf
                                @method('DELETE')

                                <x-primary-link-button href="{{ route('users.index') }}" class="bg-zinc-800">
                                    Back
                                </x-primary-link-button>
                                <x-primary-link-button href="{{ route('users.edit',$user->id) }}" class="bg-zinc-800">
                                    Edit
                                </x-primary-link-button>
                                <x-secondary-button type="submit" class="bg-zinc-200">
                                    Delete
                                </x-secondary-button>
                            </form>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

