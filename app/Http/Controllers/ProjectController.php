<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:projects,name,NULL,id,user_id,' . auth()->id()
                ],
            ], [
                'name.unique' => 'You already have a project with this name.',
                'name.required' => 'Project name is required.',
                'name.max' => 'Project name cannot exceed 255 characters.',
            ]);

            $project = auth()->user()->projects()->create($validated);
            return response()->json($project, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the project.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:projects,name,' . $project->id . ',id,user_id,' . auth()->id()
                ],
            ], [
                'name.unique' => 'You already have a project with this name.',
                'name.required' => 'Project name is required.',
                'name.max' => 'Project name cannot exceed 255 characters.',
            ]);

            $project->update($validated);
            return response()->json($project);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the project.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        try {
            $project->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the project.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
