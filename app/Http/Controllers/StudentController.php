<?php

namespace App\Http\Controllers;

use domain\Facades\StudentFacade;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends ParentController
{

    public function index()
    {
        return Inertia::render('Student/index');
    }

    public function store(Request $request)
    {
        return StudentFacade::store($request);
    }

    public function list()
    {
        $tasks = StudentFacade::all();
        return response()->json($tasks);
    }


    public function edit(Request $request)
    {
        $response['task'] = StudentFacade::get($request['task_id']);
        return view('pages.student.edit')->with($response);
    }

    public function update(Request $request, $task_id)
    {
        return StudentFacade::update($request, $task_id);
    }

    public function delete($id)
    {
        return StudentFacade::delete($id);
    }

    public function status($id)
    {
        return StudentFacade::status($id);
    }

    public function get($id)
    {
        $task = StudentFacade::get($id);
        return response()->json($task);
    }
}
