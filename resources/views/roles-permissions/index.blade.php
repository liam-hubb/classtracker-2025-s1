<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles and Permissions Management') }}
        </h2>
    </x-slot>

    @auth
        <x-flash-message :data="session()"/>
    @endauth

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h3 class="text-xl font-bold mb-6">Roles and Permissions</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300 shadow-lg">
                            <thead>
                                <tr class="bg-blue-600 text-white">
                                    <th class="border px-4 py-2">Roles</th>
                                    <th class="border px-4 py-2">Permissions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-50">
                                @foreach ($roles as $role)
                                    <tr class="border">
                                        <td class="border border-gray-300 px-4 py-2 text-blue-500 font-bold">{{ $role->name }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @foreach ($role->permissions as $permission)
                                                <span class="inline-block bg-gray-200 text-gray-800 px-2 py-1 rounded-md text-xs">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h3 class="text-xl font-bold mt-8 mb-4">Assign Role to User</h3>
                    <form method="POST" action="{{ route('roles-permissions.assignRole') }}" class="bg-gray-100 p-4 rounded-lg shadow">
                        @csrf
                        <div class="flex space-x-4">
                            <select name="user" class="border rounded w-1/2 p-2">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name .' '. $user->family_name}}</option>
                                @endforeach
                            </select>
                            <select name="role" class="border rounded w-1/2 p-2">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <x-primary-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Assign Role') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <h3 class="text-xl font-bold mt-8 mb-4">Remove Role from User</h3>
                    <form method="POST" action="{{ route('roles-permissions.removeRole') }}" class="bg-red-100 p-4 rounded-lg shadow">
                        @csrf
                        @method('DELETE')
                        <div class="flex space-x-4">
                            <select name="user_id" class="border rounded w-1/2 p-2">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name .' '. $user->family_name }}</option>
                                @endforeach
                            </select>
                            <select name="role" class="border rounded w-1/2 p-2">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <x-primary-button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Remove Role') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
