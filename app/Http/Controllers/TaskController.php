<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Load user information and tasks, optimizing filtering.
        $query = Task::with('user');

        // Filter by completion status
        if ($request->filled('completed')) {
            $query->where('is_completed', $request->query('completed'));
        }

        // Filter by search text
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Pagination with default of 10 results per page
        $tasks = $query->paginate($request->get('per_page', 10));

        return response()->json($tasks);
    }

    public function show(Task $task)
    {
        // Load user relationship
        $task->load('user');

        return response()->json($task);
    }

    public function store(Request $request)
    {
        // Input validation
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        // Create the task associated with the authenticated user
        $task = Auth::user()->tasks()->create($validatedData);

        // Load user relationship
        $task->load('user');

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        // Check if the user has permission to update the task
        $this->authorize('update', $task);

        // Input validation, only for submitted fields
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'due_date' => 'sometimes|required|date',
        ]);

        // Update task
        $task->update($validatedData);

        return response()->json($task);
    }

    public function markAsCompleted(Task $task, $complete)
    {
        // Check if the user has permission to update the task
        $this->authorize('update', $task);

        // Mark task as completed or not completed
        $task->update(['is_completed' => (bool) $complete]);

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        // Check if the user has permission to delete the task
        $this->authorize('delete', $task);

        if (Auth::user()->role === 'admin') {
            $task->delete();

            return response()->json(['message' => 'Task deleted successfully']);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
