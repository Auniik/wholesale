<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:task-list')->only('index');
        $this->middleware('can:task-create')->only('create', 'store');
        $this->middleware('can:task-update')->only('edit', 'update');
        $this->middleware('can:task-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $tasks = Task::where('company_id', company_id());
        if ($request->filled('startDate') &&  $request->filled('endDate')){
            $tasks->whereBetween('date', [flipDate($request->startDate) ?? date('Y-m-d'), flipDate($request->endDate)?? date('Y-m-d')]);
        }
        if ($request->filled('status')){
            $tasks->where('status', $request->status);
        }

        return view('crm.task.index', [
            'tasks' => $tasks->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crm.task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
        ]);
        Task::create($attributes);
        return back()->withSuccess('Task Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('crm.task.edit', [
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return back()->withSuccess('Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response([
            'check' => true
        ]);
    }
}
