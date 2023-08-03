<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $tasks = Task::all();
        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request) {
        $task = Task::query()->create([
            'name' => $request->name,
            'project_id' => $request->project_id,
            'priority' => $request->priority,
        ]);

        return response()->json(["task" => new TaskResource($task)], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task) {
        return response()->json(["task" => new TaskResource($task)]);
    }

    public function reorder(Request $request) {

        $priorityArray = $request->input('order');

        if (!is_array($priorityArray)) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        foreach($priorityArray as $item) {

            $task = Task::query()->findOrFail($item["task_id"]);

            $task->priority = $item["index"];
            $task->save();
        }

        return response()->json(['message' => 'Task priorities updated successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task) {

        DB::transaction(function() use ($request, $task) {
            Task::query()->where('priority', '>=', $request->priority)
                ->update(['priority' => DB::raw('priority + 1')]);

            $task->update([
                'name' => $request->name,
                'project_id' => $request->project_id,
                'priority' => $request->priority,
            ]);
        });

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task) {
        $task->delete();
        return response()->json([
            "message" => "Task deleted successfully"
        ]);
    }
}
