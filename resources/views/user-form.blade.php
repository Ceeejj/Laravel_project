<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
        @if(session("message"))
            <p>{{ session("message") }}</p>
        @endif
    </x-slot>

    <form method="POST" action="{{ isset($user) ? route('user.update', $user->id) : route('user.store')}}" enctype="multipart/form-data">
        @csrf
        @isset($user)
            @method('PUT')
        @endisset
        <div class="py-12 ">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8 ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                    <div class="p-6 text-gray-900">
                        <div class="table-container">
                                <div
                                <h6>Profile </h6> <br>
                                <input type="file" name="profile" id="profile"> <br>
                                <div> <br>
                                    <label for="name">Name</label> <br>
                                    <input class="font-semibold py-2 px-4 rounded-lg w-full" type="text" id="name" name="name"value="{{ old('name') ?: (isset($user) ? $user->name : '') }}"
                                    >
                                </div>
                                <div>
                                    <label for="email">Email</label> <br>
                                    <input class="rounded-lg w-full " type="email" id="email" name="email" value="{{ old('email') ?: (isset($user) ? $user->email : '') }}">
                                </div>
                                <div>
                                    <label for="password">Password</label> <br>
                                    <input class="rounded-lg w-full" type="password" id="password" name="password">
                                </div>
                                <div>
                                    <label for="confirm_password">Confirm Password</label> <br>
                                    <input class="rounded-lg w-full" type="password" id="confirm_password" name="confirm_password">
                                </div> <br>
                                <div class="flex justify-end space-x-4">
                                    <a href="{{ route('users')}}" class="text-white bg-gray-800 font-semibold rounded-lg px-4 py-2" type="button">Back</a>
                                    <button class="text-white bg-green-800 font-semibold rounded-lg px-4 py-2">{{ isset($user) ? 'SAVE' : 'ADD' }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>