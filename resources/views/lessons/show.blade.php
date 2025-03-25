<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lessons Management') }}
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
                        <h3 class="text-xl font-bold mb-6">Lesson Detail</h3>
                    </div>

                    <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                        <header
                            class="grid grid-cols-6 border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                            <p class="col-span-1 px-6 py-4 border-b border-zinc-200 dark:border-white/10">Item</p>
                            <p class="col-span-5 px-6 py-4 border-b border-zinc-200 dark:border-white/10">Content</p>
                        </header>

                        <section class="grid grid-cols-6 border-b border-neutral-200 bg-white font-medium text-zinc-800 dark:border-white/10">
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Name</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $lesson->name }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Cluster ID</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $lesson->cluster_id}}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Course ID</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $lesson->course_id }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Lecture</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $lesson->users->first()?->given_name ?? '#' }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Start Date</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $lesson->start_date }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">End Date</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $lesson->end_date }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Start Time</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{$lesson->weekday}} {{ $lesson->start_time }} </p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Duration</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $lesson->duration }} Hours </p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">In Class Group</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                @foreach ($lesson->users as $user)
                                    <span class="inline-block bg-gray-200 text-gray-800 px-2 py-1 rounded-md text-xs">{{ $user->given_name .' '. $user->family_name}}</span>
                                @endforeach
                            </p>
                        </section>

                        <footer class="grid gid-cols-1 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">
                            <form action="{{ route('users.destroy', $lesson) }}"
                                  method="POST"
                                  class="flex gap-4">
                                @csrf
                                @method('DELETE')

                                <x-primary-link-button href="{{ route('lessons.index') }}" class="bg-zinc-800">
                                    Back
                                </x-primary-link-button>
                                <x-primary-link-button href="{{ route('lessons.edit',$lesson->id) }}" class="bg-zinc-800">
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

