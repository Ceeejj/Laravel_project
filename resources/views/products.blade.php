<style>
    table tbody tr:nth-child(even) {
        background-color: rgb(57, 77, 71);
        color: white;
    }

    table tbody tr:nth-child(odd) {
        background-color: white;
        color: black;
    }

    table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.1);
        color: black;
    }

    .action-cell {
        text-align: center;
        vertical-align: middle;
    }

    .action-cell a,
    .action-cell form {
        display: inline-block;
        margin: 0 4px;
    }

    .action-button {
        padding: 6px 12px;
        font-size: 14px;
        text-align: center;
        border-radius: 4px;
    }

    .edit-button {
        background-color: #2563eb;
        color: white;
    }

    .edit-button:hover {
        background-color: #1e40af;
    }

    .delete-button {
        background-color: #dc2626;
        color: white;
    }

    .delete-button:hover {
        background-color: #b91c1c;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('TaskTrack') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="table-container">
                    <header class="flex justify-end p-4">
                        <a href="{{ route('product.create') }}"
                            class="flex flex-row gap-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add Task
                        </a>
                    </header>

                    <table class="w-full border border-gray-300 border-collapse">
                        <thead>
                            <tr class="bg-gray-200 uppercase text-sm text-center">
                                <th class="py-3 px-6 border border-gray-300">Image</th>
                                <th class="py-3 px-6 border border-gray-300">Task</th>
                                <th class="py-3 px-6 border border-gray-300">Description</th>
                                <th class="py-3 px-6 border border-gray-300">Category</th>
                                <th class="py-3 px-6 border border-gray-300">Task Date</th>
                                <th class="py-3 px-6 border border-gray-300">Comment</th>
                                <th class="py-3 px-6 border border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="border-b border-gray-300">
                                    <td class="py-3 px-6 border border-gray-300">
                                        <img src="{{ asset('storage/Uploads/Product Images/' . $product->product_image) }}"
                                            class="w-10 h-10 rounded-full">
                                    </td>
                                    <td class="py-3 px-6 border border-gray-300">{{ $product->product_name }}</td>
                                    <td class="py-3 px-6 border border-gray-300">{{ $product->task_description }}</td>
                                    <td class="py-3 px-6 border border-gray-300">{{ $product->category->category_name }}
                                    </td>
                                    <td class="py-3 px-6 border border-gray-300">
                                        {{ $product->task_date ? \Carbon\Carbon::parse($product->task_date)->format('F j, Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <div>
                                            @foreach ($product->comments as $comment)
                                                <p>{{ $comment->created_at }} {{ $comment->comment }}</p>
                                            @endforeach
                                        </div>
                                        <form action="{{ route('product.comment', $product->product_id) }}"
                                            method="POST" class="mt-2">
                                            @csrf
                                            <input type="text" name="comment" placeholder="Add a comment"
                                                class="border border-gray-300 rounded px-2 py-1 w-full center" />
                                            <button type="submit"
                                                class="bg-blue-500 text-white rounded px-2 py-1 mt-1">Submit</button>
                                        </form>
                                    </td>
                                    <td class="py-3 px-6 border border-gray-300 action-cell">
                                        <a title="EDIT" href="{{ route('product.edit', $product->product_id) }}"
                                            class="action-button edit-button">
                                            EDIT
                                        </a>
                                        <form method="POST"
                                            action="{{ route('product.delete', $product->product_id) }}"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="DELETE" class="action-button delete-button"
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

    @if (session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast("{{ session('type') }}", "{{ session('message') }}");
            });
        </script>
    @endif
</x-app-layout>
