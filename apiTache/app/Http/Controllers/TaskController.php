<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $query = $user->tasks();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('deadline')) {
            $query->whereDate('deadline', $request->deadline);
        }

        return TaskResource::collection($query->get());
    }

    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'in:en_cours,termine',
            'deadline' => 'nullable|date',
        ]);

        $task = $user->tasks()->create($request->all());

        return new TaskResource($task);
    }

    public function show(Task $task)
    {
        $this->authorizeTask($task);
        return new TaskResource($task);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $task->update($request->all());
        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        $task->delete();
        return response()->json(null, 204);
    }

    private function authorizeTask(Task $task)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($task->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
    }
}
