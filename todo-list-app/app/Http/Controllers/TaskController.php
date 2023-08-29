<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;


/*
TaskController with all the operations CRUD (create, read, update, delete).


endpoints with:
-> error handling
-> validation of the data (e.g. for post)
*/


class TaskController extends Controller
{

    // GET method: fetch all the tasks;
    public function index()
    {
        return response()->json(Task::all());
    }


    // POST: creation of a new task;
    public function store(Request $request)
    {
        //if data is not valid we catch an exception. Both fields are required.
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'status' => 'required|in:pending,completed'
            ]);
    
            return response()->json(Task::create($validatedData), 201);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 400);
        }
    }

    // GET method: fetch task by id;
    public function show($id)
    {

        // Error when the id is not valid (doesn't exist);
        try {
            return response()->json(['task' => Task::findOrFail($id)], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found.'], 404);
        }
    }


    // PUT method: update/modify a field of the task (example when we need to change the status)
    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            /*
            sometimes: field will be validated only if exists in the request data;
            required: if present it must be non null;
            max: 255 char for title; or either pending/completed;
            */
            $validated = $request->validate([
                'title' => 'sometimes|required|max:255',
                'status' => 'sometimes|required|in:pending,completed'
            ]);

            $task->update($validated);
            return response()->json($task);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found.'], 404);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 400);
        }
    }

    // DELETE
    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found.'], 404);
        }
    }
}
