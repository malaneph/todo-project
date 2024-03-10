<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {   
        $date_order = 'asc';
        if($request->has('date_order')) {
            $date_order = $request->date_order;
        }
        if($request->has('status')) {
            $tasks = Task::where('status', $request->status)->orderBy('created_at', $date_order)->get();
        }
        else $tasks = Task::orderBy('created_at', $date_order)->get();

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
