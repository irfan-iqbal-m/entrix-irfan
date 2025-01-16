<?php

namespace App\Http\Controllers;

use App\Jobs\SendTaskNotification;
use App\Jobs\SendTaskNotificationJob;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        if(auth()->user()->role === 'Admin'){
            $tasks = Task::with('user')->get();
            return view('task.list', ['tasks' => $tasks]);

        }else{
            $tasks =  Task::where('user_id', auth()->id())->get();
            return view('user-task.list', ['tasks' => $tasks]);

        }
        // $tasks = auth()->user()->role === 'Admin'
        // ? Task::with('user')->get()
        //     : Task::where('user_id', auth()->id())->get();
        
        return view('task.list', ['tasks' => $tasks]);
        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'Admin'){
            $users=User::where('role', 'User')->get();
            return view('task.add', ['users' => $users]);
        }else{
            return redirect('task')->with('error', 'Unauthorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role === 'Admin') {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);
        $validated['due_date'] = \Carbon\Carbon::parse($request->due_date)->format('Y-m-d H:i:s');
        $task = new Task();
        $task->title = $validated['title'];
        $task->description = $validated['description'] ?? '';
        $task->due_date = \Carbon\Carbon::parse($request->due_date)->format('Y-m-d H:i:s');;
        $task->user_id = $validated['user_id'];
        $task->status = $request->status ?? 'pending';
        $task->save();


        if ($task) {
            $message = 'Task successfully added';
            $type = 'success';
        } else {
            $message = 'Oops, something went wrong. Task not saved';
            $type = 'error';
        }

        return redirect('task')->with($type, $message);
        }else{
            
            return redirect('task')->with('error', 'Unauthorized');
        }
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (auth()->user()->role === 'Admin') {
            $task = Task::where([ 'id' => $id])->first();
            $user = User::find($task->user_id);
            return view('task.view', ['task' =>$task, 'user' => $user]);
        }else{
        $userId = Auth::user()->id;
        $user = Auth::user();
        $task = Task::where(['user_id' => $userId, 'id' => $id])->first();
        
        if (!$task) {
            return redirect('task')->with('error', 'Task not found');
        }
        return view('task.view', ['task' => $task,'user'=> $user]);
    }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->user()->role === 'Admin') {
        $userId = Auth::user()->id;
        $users = User::where('role', 'User')->get();

        $task = Task::where(['id' => $id])->first();
        if ($task) {
            return view('task.edit', ['task' => $task, 'users'=> $users]);
        } else {
            return redirect('task')->with('error', 'Task not found');
        }
        } else {
            $user = Auth::user();
            $task = Task::where(['user_id' => $user->id, 'id' => $id])->first();
            return view('user-task.edit', ['task' => $task, 'user' => $user]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if (auth()->user()->role !== 'Admin' && $task->user_id !== auth()->id()) {
            return redirect('task')->with('error', 'Unauthorized.');
        }
        if (auth()->user()->role === 'Admin') {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'due_date' => 'required|date',
                'user_id' => 'required|exists:users,id',
            ]);
            $validated['due_date'] = \Carbon\Carbon::parse($request->due_date)->format('Y-m-d H:i:s');
           
            $task->title = $validated['title'];
            $task->description = $validated['description'] ?? '';
            $task->due_date = \Carbon\Carbon::parse($request->due_date)->format('Y-m-d H:i:s');;
            $task->user_id = $validated['user_id'];
            $task->status = $request->status?? 'pending';
            $task->save();
         

        if ($task) {
            return redirect('task')->with('success', 'Task successfully updated.');
        } else {
            return redirect('task')->with('error', 'Oops something went wrong. Task not updated');
        }
        }elseif($task->user_id == auth()->id()){

            $task->status = $request->status;
            $task->save();
            return redirect('task')->with('success', 'Task successfully updated.');

        }else{
            return redirect('task')->with('error', 'Unauthorized.');
        }
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
      
    if (auth()->user()->role === 'Admin'){
 
        $respStatus = $respMsg = '';
        if (!$task) {
            $respStatus = 'error';
            $respMsg = 'Task not found';
        }
        $taskDelStatus = $task->delete();
        if ($taskDelStatus) {
            $respStatus = 'success';
            $respMsg = 'Task deleted successfully';
        } else {
            $respStatus = 'error';
            $respMsg = 'Oops something went wrong. Task not deleted successfully';
        }}else{
            $respStatus = 'error';
            $respMsg = 'Unauthorized. Task not deleted successfully';
        }
        return redirect('task')->with($respStatus, $respMsg);

    }
}
