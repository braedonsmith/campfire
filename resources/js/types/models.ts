import type { User } from './auth';

export type KanbanItemPriority = 'P5' | 'P4' | 'P3' | 'P2' | 'P1';
export type KanbanItemStatus = 'not started' | 'in progress' | 'complete';

export type KanbanItem = {
    id: number
    key: string,
    title: string,
    description: string,
    category?: string,
    priority: KanbanItemPriority,
    status: KanbanItemStatus,
    assignee?: User,
    creator: User,
    due_by: string
    created_at: string,
    updated_at: string
};
