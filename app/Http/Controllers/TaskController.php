<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->tasks()->with('project');

        if ($request->has('project_id') && $request->project_id !== 'all') {
            $query->where('project_id', $request->project_id);
        }

        $tasks = $query->orderBy('priority')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'project_id' => 'nullable|exists:projects,id',
            ], [
                'name.required' => 'Task name is required.',
                'name.max' => 'Task name cannot exceed 255 characters.',
                'project_id.exists' => 'The selected project does not exist.',
            ]);

            $maxPriority = auth()->user()->tasks()
                ->when($request->project_id, fn($q) => $q->where('project_id', $request->project_id))
                ->max('priority') ?? 0;

            $task = auth()->user()->tasks()->create([
                ...$validated,
                'priority' => $maxPriority + 1,
            ]);

            return response()->json($task->load('project'), 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the task.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'project_id' => 'nullable|exists:projects,id',
            ], [
                'name.required' => 'Task name is required.',
                'name.max' => 'Task name cannot exceed 255 characters.',
                'project_id.exists' => 'The selected project does not exist.',
            ]);

            $task->update($validated);
            return response()->json($task->load('project'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the task.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        try {
            $task->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the task.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|exists:tasks,id',
            'tasks.*.priority' => 'required|integer',
        ]);

        foreach ($validated['tasks'] as $taskData) {
            Task::where('id', $taskData['id'])
                ->where('user_id', auth()->id())
                ->update(['priority' => $taskData['priority']]);
        }

        return response()->json(['message' => 'Tasks reordered successfully']);
    }
}
