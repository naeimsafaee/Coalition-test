<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class CreateTaskController extends Controller {

    public function showForm() {
        $projects = Project::all();
        return view('pages.tasks.create' , ['projects' => $projects]);
    }


}
