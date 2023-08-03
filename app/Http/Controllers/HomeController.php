<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller {
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) {

        $tasks = Task::query()->orderBy('priority')->get();
        $projects = Project::all();

        return view('pages.home' , ['tasks' => $tasks , 'projects' => $projects]);
    }
}
