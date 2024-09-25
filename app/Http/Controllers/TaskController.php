<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        // Filtrar by cumpleted status
        if ($request->has('completed')) {
            $query->where('is_completed', $request->query('completed'));
        }

        // Filtro by input text
        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // pagination results per page, deafult 10 items
        $tasks = $query->paginate(10);

        return response()->json($tasks);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        $task = auth()->user()->tasks()->create($request->all());
        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        // $this->authorize('update', $task); //Policies verification

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'due_date' => 'sometimes|required|date',
        ]);

        $task->update($request->all());
        return response()->json($task);
    }

    public function markAsCompleted(Task $task, $complete)
    {
        // $this->authorize('update', $task); //Policies verification

        $task->is_completed = $complete == 1;
        $task->save();

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        // $this->authorize('delete', $task);
        // Log::info('User Role: ' . auth()->user()->role);
        // Log::info('Task id: ' . $task);
        if (auth()->user()->role == 'admin') {
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully']);
        } else {
            return response()->json(['message' => 'Unauthorized']);
        }
    }

}
