import type { KanbanItemStatus } from "./models"

export interface DraggableChangeEvent<T> {
    event: {
        added?: {
            element: T
            newIndex: number
        }
        removed?: {
            element: T,
            oldIndex: number
        },
        moved?: {
            element: T,
            oldIndex: number,
            newIndex: number
        }
    },
    status: KanbanItemStatus
};
