<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">Classtracker</h2>
        </div>
    </x-slot>

    @auth
        <x-flash-message :data="session()" />
    @endauth

    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-6 px-8 text-center rounded-lg shadow-md">
        <h1 class="text-3xl font-bold">Welcome to Classtracker!</h1>
        <p class="mt-2 text-lg">Manage your courses, assignments, and deadlines easily.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-6 py-8">

        <div class="p-6 bg-white shadow-lg rounded-lg text-center border border-gray-200">
            <h3 class="text-lg font-semibold">📚 My Courses</h3>
            <p class="text-gray-600">Browse enrolled courses</p>
            <a href="{{ auth()->check() ? route('course') : route('login') }}"
               class="block mt-2 text-blue-500 hover:underline">
                View Courses →
            </a>
        </div>

        <div class="p-6 bg-white shadow-lg rounded-lg text-center border border-gray-200">
            <h3 class="text-lg font-semibold">📝 Assignments</h3>
            <p class="text-gray-600">Check upcoming deadlines</p>
            <a href="{{route('static.home')}}" class="block mt-2 text-blue-500 hover:underline">Go to Assignments →</a>
        </div>

        <div class="p-6 bg-white shadow-lg rounded-lg text-center border border-gray-200">
            <h3 class="text-lg font-semibold">📢 Announcements</h3>
            <p class="text-gray-600">Stay updated with class news</p>
            <a href="{{route('static.home')}}" class="block mt-2 text-blue-500 hover:underline">Read Announcements →</a>
        </div>
    </div>

    <div class="mt-8 px-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-900 p-4 rounded-lg shadow-md">
        <p class="font-bold">📢 Reminder:</p>
        <p>Mid-term exams are coming up! Check your schedule for details.</p>
    </div>
</x-app-layout>
