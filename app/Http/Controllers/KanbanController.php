<?php

namespace App\Http\Controllers;

use App\Models\KanbanItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class KanbanController extends Controller
{
    public function listTasks(): Response
    {
        return Inertia::render('kanban/TaskList', [
            'tasks' => KanbanItem::with('assignee')->get()
        ]);
    }

    public function store(Request $request): Response
    {
        $task = new KanbanItem;

        $code = match ($request->category) {
            'Executive Staff' => 'CC',
            'Administration' => 'DA',
            'Chaplain' => 'HC',
            'Curriculum and Plans' => 'XP',
            'Logistics' => 'LG',
            'Operations' => 'OPS',
            'Public Affairs' => 'PA',
            'Safety' => 'SE'
        };

        $key = KanbanItem::all()->count() + 1;

        $task->key = "$code-$key";
        $task->title = $request->title;
        $task->description = $request->description;
        $task->category = $request->category;
        $task->priority = $request->priority;
        $task->status = 'not started';
        $task->creator_capid = intval($request->session()->get('capid'));
        $task->due_by = $request->dueBy;

        $task->save();

        return Inertia::render('kanban/TaskList', [
            'tasks' => KanbanItem::with('assignee')->get()
        ]);
    }
}
