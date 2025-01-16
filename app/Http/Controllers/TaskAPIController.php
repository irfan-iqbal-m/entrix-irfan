<?php

namespace App\Http\Controllers;

use App\Jobs\SendTaskNotification;
use App\Jobs\SendTaskNotificationJob;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskAPIController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('TaskManagementApp')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'Admin') {
            $tasks = Task::all();
        } else {
            $tasks = Task::where('user_id', $user->id)->get();
        }

        return response()->json($tasks);
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

       if (Auth::user()->role === 'User' && $request->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

  
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        if (Auth::user()->role !== 'Admin' && $task->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->update($request->only('status'));
        return response()->json($task);
    }

    
    public function destroy(Task $task)
    {
        if (Auth::user()->role === 'Admin' || $task->user_id === Auth::id()) {
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully']);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
