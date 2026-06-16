<script setup lang="ts">
import { formatName, formatRelativeTime, formatTimestamp } from '@/lib/format';
import { KanbanItem } from '@/types';

type KanbanCardProps = {
    task: KanbanItem
}

const props = defineProps<KanbanCardProps>();

const getItemColors = (priority: string) => {
    switch (priority) {
        case 'P1':
            return 'border-red-700 bg-red-300/30 dark:bg-red-950/30';
        case 'P2':
            return 'border-orange-500 bg-orange-300/30 dark:bg-orange-950/30';
        default:
        case 'P3':
            return 'border-yellow-500 bg-yellow-200/30 dark:bg-yellow-950/30';
        case 'P4':
            return 'border-green-700 bg-green-200/30 dark:bg-green-950/30';
        case 'P5':
            return 'border-blue-700 bg-blue-300/30 dark:bg-blue-950/30';
    }
};

const getTextColors = (priority: string) => {
    switch (priority) {
        case 'P1':
            return 'text-red-700';
        case 'P2':
            return 'text-orange-500';
        default:
        case 'P3':
            return 'text-yellow-500';
        case 'P4':
            return 'text-green-700';
        case 'P5':
            return 'text-blue-700';
    }
};
</script>

<template>
    <div :class="[
        'border rounded-md flex flex-col m-2 p-2',
        getItemColors(task.priority)
    ]">
        <span class="mb-2"><strong>{{ task.key }}</strong> &MediumSpace; {{ task.title }} &MediumSpace; <strong :class="[getTextColors(task.priority)]">{{ task.priority }}</strong></span>
        <table>
            <tr>
                <td>Creator</td>
                <td>{{ formatName(task.creator) }}</td>
            </tr>
            <tr>
                <td>Assignee</td>
                <td>{{ task.assignee ? formatName(task.assignee) : 'Not Assigned' }}</td>
            </tr>
            <tr>
                <td>Due By</td>
                <td>{{ formatTimestamp(task.due_by) }} ({{ formatRelativeTime(task.due_by) }})</td>
            </tr>
        </table>
    </div>
</template>