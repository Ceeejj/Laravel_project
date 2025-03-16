<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUserId = Auth::id();

        $users = User::where('id', '!=', $currentUserId)->where('is_deleted', '0')->get();

        return view('users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate input fields,including the image
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' =>['required', Rules\Password::defaults()],
            'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('profile')) {
            $filenameWithExtension = $request->file('profile')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('profile')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('profile')->storeAs('Uploads/users-profile', $filenameToStore);
            $validated['profile'] = $filenameToStore;
        }        

        $user = User::create($validated);

        if($user) {
            return redirect()->route('users')->with('message', 'User added successfully!');
        } else {
            return redirect()->route('users')->with('message', 'Unable to add user!');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        return view('user-form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return redirect()->route('user.edit')->with('message', 'User not found!');
        }
 
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $id],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' =>['nullable', Rules\Password::defaults()],
            'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('profile')) { 
            $filenameWithExtension = $request->file('profile')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('profile')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('profile')->storeAs('Uploads/users-profile', $filenameToStore);
            $validated['profile'] = $filenameToStore;
        }        

        if($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $UpdateUser = $user->update($validated);

        if($UpdateUser) {
            return redirect()->route('users')->with('message', 'User updated successfully!');
        } else {
            return redirect()->route('user.edit')->with('message', 'Unable to update user!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        $user->is_deleted = 1;

        if($user->save()) {
            return redirect()->route('users')->with('message', 'User deleted successfully!');
        } else {
            return redirect()->route('users')->with('message', 'Unable to delete user!');
        }
    }
}
