<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(session("message"))
                    <p>{{ session("message") }}</p>
                @endif
                <div class="p-6 text-gray-900">
                    <div class="table-container">
                        <header class="flex justify-end p-4">
                            <a href="{{ route('user.create') }}" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-blue-600 transition duration-300">
                                + New User
                            </a>
                        </header>

                        <table class="table-auto w-full text-left border-collapse text-center">
                            <thead>
                                <tr class="bg-gray-200"> 
                                <th class="px-4 py-2 border border-gray-300">Profile</th>
                                <th class="px-4 py-2 border border-gray-300">Name</th>
                                <th class="px-4 py-2 border border-gray-300">Email</th>
                                <th class="px-4 py-2 border border-gray-300">Date Created</th>
                                <th class="px-4 py-2 border border-gray-300 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr class="bg-white hover:bg-green-100">
                                    <td class="px-4 py-2 border border-gray-300">
                                        <img src="{{  $user->profile ? asset('storage/Uploads/users-profile/' . $user->profile) : asset('storage/Uploads/users-profile/user.jpg') }}" alt="User Profile" class="w-10 h-10 rounded-full">
                                    </td>
                                    <td class="py-3 px-6 border">{{ $user->name }}</td>
                                    <td class="py-3 px-6 border">{{ $user->email }}</td>
                                    <td class="py-3 px-6 border">{{ $user->created_at->format('F j, Y') }}</td>
                                    <td class="space-x-2 border border-gray-300 text-center">
                                        <a href="{{ route('user.edit', $user->id) }}" class="bg-green-500 text-white font-bold py-2 px-4 rounded">
                                            EDIT
                                        </a>
                                    <form action="{{ route('user.delete', $user->id ) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                                type="submit"
                                                title="DELETE"
                                                class="bg-red-500 text-white py-1 px-4 rounded hover:bg-red-600 transition duration-300"
                                                onclick="return confirm('Are you sure you want to delete this product?');">
                                                DELETE
                                        </button>
                                    </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>