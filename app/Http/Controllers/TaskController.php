<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks');
    }

    public function getAll()
    {
        return response()->json([
            "tasks" => Task::all()
        ]);
    }

    public function store()
    {
        $this->validate(request(), [
            'description' => 'required'
        ]);

        $task = Task::create([
            'description' => request('description'),
            'completed' => false
        ]);

        return response()->json([
            'message' => 'Task created successfuly',
            'task' => $task
        ]);
    }

    public function update(Task $task)
    {
        $this->validate(request(), [
            'description' => 'required',
            'completed' => 'required|boolean',
        ]);

        $task->update(
            request()->only(['description', 'completed'])
        );

        return response()->json([
            'message' => 'Task updated successfuly',
            'task' => $task
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfuly'
        ]);
    }


}
