<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return response()->json([
            'tasks' => $tasks
        ]);
    }

    public function add(Request $request){
        $task = new Task;
        $task->description = $request->description;
        $task->status = 'active';
        $task->save();

        return response()->json([
            'task' => $task,
            'status' => 'success'
        ]);
    }

    public function update(Request $request, $id){
        $task = Task::findOrFail($id);
        if($request->has('description')) {
            $task->description = $request->description;
        }
        if($request->has('status')) {
            $task->status = $request->status;
        }

        $task->save();

        return response()->json([
            'task' => $task,
            'status' => 'success'
        ]);
    }

    public function remove($id){
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
