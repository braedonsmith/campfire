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
    private function generateKey(string $category): string
    {
        $prefix = match ($category) {
            'Executive Staff' => 'CC',
            'Administration' => 'DA',
            'Chaplain' => 'HC',
            'Curriculum and Plans' => 'XP',
            'Logistics' => 'LG',
            'Operations' => 'OPS',
            'Public Affairs' => 'PA',
            'Safety' => 'SE',
            default => 'GEN'
        };

        $id = KanbanItem::where('category', $category)->count() + 1;

        return "$prefix-$id";
    }

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

        $data = [
            'key' => self::generateKey($validated['category']),
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

    public function update(Request $request, KanbanItem $kanbanItem): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'category' => ['sometimes', 'string', Rule::in('Executive Staff', 'Administration', 'Chaplain', 'Curriculum and Plans', 'Logistics', 'Operations', 'Public Affairs', 'Safety')],
            'priority' => ['sometimes', 'string', Rule::in('P1', 'P2', 'P3', 'P4', 'P5')],
            'status' => ['sometimes', 'string', Rule::in('not started', 'in progress', 'complete')],
            'assignee_capid' => ['sometimes', 'integer', 'gte:100000'],
            'due_by' => ['sometimes', 'string', new Timestamp()]
        ]);

        if (isset($validated['category'])) {
            $validated['key'] = self::generateKey($validated['category']);
        }

        if ($kanbanItem->update($validated)) {
            return response()->json($kanbanItem, 200);
        }

        return response()->json($kanbanItem, 500);
    }
}
