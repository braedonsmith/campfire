<script setup lang="ts">
import draggable from 'vuedraggable';
import { ClassValue } from 'vue';

import { DraggableChangeEvent, KanbanItem } from '@/types';
import { ScrollArea } from './ui/scroll-area';
import KanbanCard from './KanbanCard.vue';

type KanbanColumnProps = {
    class: ClassValue,
    title: string,
    status: string
};

const items = defineModel({
    type: Array<KanbanItem>,
    required: true
});

const props = defineProps<KanbanColumnProps>();

const emit = defineEmits(['task-moved']);
</script>

<template>
    <ScrollArea :class="props.class">
        <h3 class="m-4 leading-none">{{ title }}</h3>
        <draggable v-model="items" item-key="id" group="kanban" @change="(event: DraggableChangeEvent<KanbanItem>) => emit('task-moved', { event, status })">
            <template #item="{ element }">
                <KanbanCard :task="element" />
            </template>
        </draggable>
    </ScrollArea>
</template>