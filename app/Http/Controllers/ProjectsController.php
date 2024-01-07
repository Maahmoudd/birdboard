<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Projects::all();
        return view('index', ['projects' => $projects]);
    }

    public function store()
    {
        $attributes = request()->validate(['title' => 'required', 'description' => 'required']);
        Projects::create($attributes);
        return redirect('/projects');
    }
}
