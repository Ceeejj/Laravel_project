<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function index()

    {
        $tasks = Task::all();
        $users = User::all();
    
        return view('dashboard', compact('tasks'));
    }


    // store sang new task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|string',
            'task_type' => 'required',
            'assigned_to' => 'required|exists:users,id'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('task_images', 'public');
        }

        Task::create([
            'image' => $imagePath,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'task_type'=> $validated['task_type'],
            'assigned_to'=> $validated['assigned_to'],           

        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function newStore(Request $request) {
        
    }

    public function edit($id)
    {
        $task = Task::findorFail($id);
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function destroy($id)
    {
        $task = Task::findorFail($id);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

}
