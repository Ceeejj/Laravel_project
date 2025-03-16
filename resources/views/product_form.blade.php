<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mt-2">
                        <img id="productImagePreview"
                         src="" 
                         alt="" style="max-width: 64px;"/>
                    </div>

                    <form method="POST" action="{{ isset($product) ? route('product.update', $product->product_id) : route('product.store') }}" enctype="multipart/form-data" class="p-4">
                        @csrf
                        @isset($product)
                            @method('PUT')
                        @endisset
                        <div class=" grid grid-cols-1 gap-4 ms:grid-cols-2">
                            <div>
                                <label for="product_image" class="block text-sm font-medium text-gray-700"> Image </label>
                                <input type="file" id="product_image" name="product_image"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="product_name" class="block text-sm font-medium text-gray-700"> Tasks </label>
                                <input type="text" id="product_name" name="product_name" value="{{ isset($product) ? $product->product_name : old('product_name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="task_description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" id="task_description" name="task_description" value="{{ isset($product) ? $product->task_description : old('task_description') }}"
                                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700"> Category </label>
                                <select id="category" name="category"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="" disabled selected>Select a category</option>
                                    @foreach ($categories as $index => $category)
                                        <option value="{{ $category->category_id }}" {{ isset($product) && $product->category_id == $category->category_id ? 'selected' : ''}}>
                                            {{ $index + 1}}. {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="task_date" class="block text-sm font-medium text-gray-700">Task Date</label>
                                <input type="date" id="task_date" name="task_date" 
                                value="{{ isset($product) ? $product->task_date : old('task_date') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>


                        </div>

                        <div class="mt-4 flex justify-end">
                            
                            <a href="{{ route('products')}}"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 
                                hover:bg-indigo-700 focus:outline-none focus:ring-offset-2 focus:ring-indigo-500">
                                 Back
                            </a>
                            <br>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 
                                hover:bg-indigo-700 focus:outline-none focus:ring-offset-2 focus:ring-indigo-500">
                                 {{ isset($product) ? 'SAVE' : 'ADD'}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session('message'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showToast("{{ session('type') }}", "{{ session('message') }}");
        });
    </script>
    @endif
    <script>
        document.getElementById('product_image').addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('productImagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
</x-app-layout>