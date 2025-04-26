<?php

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Task;


Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function () {
    return view('index', [
        'tasks' => Task::latest()->paginate()
    ]);
})->name('tasks.index');

//Only for the view the create.blade.php
//Use route view must follow the mother roots (sequence of CRUD)
Route::view('/tasks/create', 'create')->name('tasks.create');

//Edit Data
Route::get('/tasks/{task}/edit', function (Task $task) {

    return view('edit', ['task' => $task]);
})->name('tasks.edit');

//Showing certain Data
Route::get('/tasks/{task}', function (Task $task) {

    return view('show', ['task' => $task]);
})->name('tasks.show');

//Validate and Storing Data
Route::post('/tasks', function(TaskRequest $request){
    // $task = new Task;
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();

    $task = Task::create($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task Created Successfully!');
})->name('tasks.store');

//Validate and updating Data
Route::put('/tasks/{task}', function(Task $task, TaskRequest $request){

    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();

    $task->update($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task Updated Successfully!');
})->name('tasks.update');

//Deleting Data
Route::delete('/tasks/{task}', function(Task $task){
    $task->delete();
    return redirect()->route('tasks.index')->with('success', 'Task Deleted Successfully!');
})->name('tasks.destroy');

//Toggle complete task
Route::put('tasks/{task}/toggle-comple', function(Task $task){

    $task->toggleComplete();
    return redirect()->back()->with('success', 'Task Updated Successfully!');
})->name('tasks.toggleComplete');





