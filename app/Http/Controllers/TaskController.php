<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }


    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $validatedData = $validator->validated();
        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('images', 'public');
            $validatedData['img'] = $imagePath;
        }
        $validatedData['datetime'] = Carbon::now()->timestamp;
        $task = Task::create($validatedData);

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }


    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "message" => "Validate error",
                "errors" => $validator->messages()
            ])->setStatusCode(422);
        }

        $validatedData = $validator->validated();
        $validatedData['img'] = $task->img;
        if ($request->input('change_img') == "true") {
            $validatedData['img'] = "";
            if ($task->img && Storage::exists($task->img)) {
                Storage::delete($task->img);
            }            
            if ($request->hasFile('img')) {
                $imagePath = $request->file('img')->store('images', 'public');
                $validatedData['img'] = $imagePath;
            }
        }
        $task->update($validatedData);

        return response()->json(['message' => 'Task updated successfully', 'task' => $task]);
    }


    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        
        if (isset($task->img)) {
            Storage::delete($task->img);
        }
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
