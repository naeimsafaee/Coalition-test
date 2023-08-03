<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class UpdateTaskController extends Controller {

    public function showForm($id) {
        $projects = Project::all();

        $task = Task::query()->findOrFail($id);

        return view('pages.tasks.update', ['projects' => $projects , 'task' => $task]);
    }
}
