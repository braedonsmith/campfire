<?php

namespace App\Http\Controllers;

use App\Models\KanbanItem;
use App\Rules\Timestamp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class KanbanController extends Controller
{
    public function listPage(): Response
    {
        return Inertia::render('kanban/TaskList', [
            'tasks' => KanbanItem::with(['assignee', 'creator'])->get()
        ]);
    }

    public function getAll(): JsonResponse
    {
        return response()->json(KanbanItem::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'category' => ['string', Rule::in('Executive Staff', 'Administration', 'Chaplain', 'Curriculum and Plans', 'Logistics', 'Operations', 'Public Affairs', 'Safety')],
            'priority' => ['required', 'string', Rule::in('P1', 'P2', 'P3', 'P4', 'P5')],
            'dueBy' => ['required', 'string', new Timestamp()]
        ]);

        $code = match ($validated['category']) {
            'Executive Staff' => 'CC',
            'Administration' => 'DA',
            'Chaplain' => 'HC',
            'Curriculum and Plans' => 'XP',
            'Logistics' => 'LG',
            'Operations' => 'OPS',
            'Public Affairs' => 'PA',
            'Safety' => 'SE'
        };

        // TODO get the count of items matching category to allow for sequential assignment
        $key = KanbanItem::all()->count() + 1;

        $data = [
            'key' => "$code-$key",
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'status'=> 'not started',
            'creator_capid' => auth()->user()['capid'],
            'due_by' => $validated['dueBy'],
        ];

        $task = KanbanItem::create($data);

        return response()->json($task, 201);
    }
}
