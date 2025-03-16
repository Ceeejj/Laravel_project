<x-app-layout>
    <div class="flex flex-col w-full h-screen bg-gray-800 text-white">
        <div class="flex items-center justify-between h-16 border-b border-gray-700 px-4">
            <h1 class="text-lg font-bold">Tasks</h1>
            <button 
                id="addTaskButton" 
                class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Task
            </button>
        </div>

        <div class="flex h-full">

        <nav class="w-1/4 bg-gray-900 p-4 border-r border-gray-700">
                <ul>
                    <li class="mb-4">
                        <a href="#" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">
                            <span>My Tasks</span>
                        </a>
                    </li>
                    <hr class="border-gray-700 mb-4">

                    <li class="mb-4">
                        <a href="#" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">
                            <span>Team Tasks</span>
                        </a>
                    </li>
                    <hr class="border-gray-700 mb-4">

                    <li>
                        <a href="#" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">
                            <span>Progress</span>
                        </a>
                    </li>
                    <hr class="border-gray-700 mt-4">
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="w-3/4 p-6">
                <table class="w-full border border-gray-300 border-collapse">
                    <thead>
                        <tr class="bg-gray-700 text-white uppercase text-sm text-center">
                            <th class="py-3 px-6 border border-gray-300">Image</th>
                            <th class="py-3 px-6 border border-gray-300">Task</th>
                            <th class="py-3 px-6 border border-gray-300">Task Description</th>
                            <th class="py-3 px-6 border border-gray-300">Assigned To</th>
                            <th class="py-3 px-6 border border-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr class="bg-gray-800 border-b border-gray-700 text-center">
                            <td class="py-3 px-6 border border-gray-300">
                                <img src="{{ $task->image ? asset('storage/' . $task->image) : 'https://via.placeholder.com/40' }}" class="w-10 h-10 rounded-full" alt="Task Image">
                            </td>
                            <td class="py-3 px-6 border border-gray-300">{{ $task->task_title }}</td>
                            <td class="py-3 px-6 border border-gray-300">{{ $task->task_description }}</td>
                            <td class="py-3 px-6 border border-gray-300">{{ $task->assignedTo->name ?? 'Not Assigned' }}</td>
                            <td class="py-3 px-6 border border-gray-300">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:text-blue-700 font-bold mr-2">Edit</a>
                                <form method="POST" action="{{ route('tasks.delete', $task->id) }}" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="text-red-500 hover:text-red-700 font-bold"
                                        onclick="return confirm('Are you sure you want to delete this task?');">
                                        Delete
                                    </button>
                                </form>
                                <a href="#" class="text-green-500 hover:text-green-700 font-bold ml-2">Update</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Task Form Modal -->
    <div 
        id="taskFormModal" 
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="task-form-container bg-white rounded-lg shadow-lg p-8 w-full max-w-lg">
            <div class="form-header flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Add New Task</h2>
                <button 
                    id="closeModalButton" 
                    class="text-gray-500 hover:text-gray-800 font-bold text-lg">&times;</button>
            </div>
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <label for="image" class="block font-bold text-gray-700 mb-2">Image</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>

                <div class="form-group mb-4">
                    <label for="title" class="block font-bold text-gray-700 mb-2">Title</label>
                    <input type="text" class="form-control w-full py-2" id="title" name="title" required>
                </div>

                <div class="form-group mb-4">
                    <label for="description" class="block font-bold text-gray-700 mb-2">Description</label>
                    <textarea class="form-control w-full py-2" id="description" name="description" rows="3" required></textarea>
                </div>

                <div class="form-group mb-4">
                    <label for="date" class="block font-bold text-gray-700 mb-2">Date</label>
                    <input type="date" class="form-control w-full py-2" id="date" name="date" required>
                </div>

                <div class="form-group mb-4">
                    <label for="task_type" class="block font-bold text-gray-700 mb-2">Task Type</label>
                    <select class="form-control w-full py-2" id="task_type" name="task_type" required>
                        <option value="">Select Task Type</option>
                        <option value="personal">My Task</option>
                        <option value="collaborative">Collaborative Task</option>
                        <option value="team">Team Task</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Save Task
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        const addTaskButton = document.getElementById('addTaskButton');
        const taskFormModal = document.getElementById('taskFormModal');
        const closeModalButton = document.getElementById('closeModalButton');


        addTaskButton.addEventListener('click', () => {
            taskFormModal.classList.remove('hidden');
        });


        closeModalButton.addEventListener('click', () => {
            taskFormModal.classList.add('hidden');
        });

        window.addEventListener('click', (e) => {
            if (e.target === taskFormModal) {
                taskFormModal.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
