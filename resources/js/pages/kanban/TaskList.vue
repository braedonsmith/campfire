<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { getLocalTimeZone, now } from '@internationalized/date';
import { toTypedSchema } from '@vee-validate/zod';
import { ListPlus } from 'lucide-vue-next';
import { useForm as useVeeForm, Field as VeeField } from 'vee-validate';
import { ref } from 'vue';
import { z } from 'zod';

import KanbanCard from '@/components/KanbanCard.vue';
import KanbanColumn from '@/components/KanbanColumn.vue';
import { Button } from '@/components/ui/button';
import { DatetimePicker } from '@/components/ui/datetime-picker';
import { Field, FieldContent, FieldDescription, FieldError, FieldGroup, FieldLabel } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Sheet, SheetContent, SheetFooter, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Textarea } from '@/components/ui/textarea';
import client from '@/lib/http-client';
import { DraggableChangeEvent, KanbanItem } from '@/types';

type TaskListProps = {
    tasks: KanbanItem[]
};

const props = defineProps<TaskListProps>();

const offices = ['Executive Staff', 'Administration', 'Chaplain', 'Curriculum and Plans', 'Logistics', 'Operations', 'Public Affairs', 'Safety'];
const priorities = ['P1', 'P2', 'P3', 'P4', 'P5'];

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Kanban Board',
                href: '/kanban',
            },
        ],
    },
});

const validationSchema = toTypedSchema(
    z.object({
        title: z.string().nonempty(),
        description: z.string().optional(),
        category: z.enum(offices).optional(),
        priority: z.enum(priorities),
        dueBy: z.iso.datetime()
    })
);

const { handleSubmit, resetForm } = useVeeForm({
    validationSchema,
    initialValues: {
        title: '',
        description: '',
        category: undefined,
        priority: 'P3',
        dueBy: now(getLocalTimeZone()).toAbsoluteString()
    }
});

const onSubmit = handleSubmit(async (data) => {
    const form = {
        title: data.title,
        description: data.description ?? "",
        category: data.category ?? "",
        priority: data.priority,
        dueBy: new Date(data.dueBy).toISOString()
    };

    await client.post('kanban', form)
        .then((res) => notStarted.value.push(res.data))
        .catch((err) => router.flash('toast', `Failed to update Kanban item: ${err}`));

    resetForm();
    isOpen.value = false;
});

const isOpen = ref(false);

const notStarted = ref(props.tasks?.filter((task: KanbanItem) => task.status === 'not started'));
const inProgress = ref(props.tasks?.filter((task: KanbanItem) => task.status === 'in progress'));
const complete = ref(props.tasks?.filter((task: KanbanItem) => task.status === 'complete'));

const handleColumnChange = ({event, status}: DraggableChangeEvent<KanbanItem>) => {
    if (!event.added) {
        return;
    }

    const task = event.added.element;
    task.status = status;

    onTaskMoved(task);
};

const onTaskMoved = async (task: KanbanItem) => {
    await client.patch(`kanban/${task.id}`, { status: task.status })
        //.then((res) => {})
        .catch((err) => router.flash('toast', `Failed to create Kanban item: ${err}`));
}

</script>

<template>
    <Head title="Kanban Board" />

    <Tabs default-value="All">
        <div class="flex justify-between m-4">
            <TabsList>
                <TabsTrigger value="All">All</TabsTrigger>
                <TabsTrigger v-for="office in offices" :value="office">{{ office }}</TabsTrigger>
            </TabsList>
            <Sheet v-model:open="isOpen">
                <SheetTrigger as-child>
                    <Button variant="default">
                        <ListPlus />
                        Add Item
                    </Button>
                </SheetTrigger>
                <SheetContent>
                    <form class="mx-4" @submit="onSubmit">
                        <SheetHeader>
                            <SheetTitle>Add New Task</SheetTitle>
                        </SheetHeader>
                        <FieldGroup>
                            <VeeField v-slot="{ field, errors }" name="title">
                                <Field :data-invalid="!!errors.length">
                                    <FieldLabel for="form-title">Title</FieldLabel>
                                    <Input id="form-title" v-bind="field" autocomplete="off" :aria-invalid="!!errors.length" />
                                    <FieldError v-if="errors.length" :errors="errors" />
                                </Field>
                            </VeeField>
                            <VeeField v-slot="{ field, errors }" name="description">
                                <Field :data-invalid="!!errors.length">
                                    <FieldLabel for="form-description">Description</FieldLabel>
                                    <Textarea id="form-description" v-bind="field" autocomplete="off" :aria-invalid="!!errors.length" as-child />
                                    <FieldError v-if="errors.length" :errors="errors" />
                                </Field>
                            </VeeField>
                            <VeeField v-slot="{ field, errors }" name="category">
                                <Field orientation="responsive" :data-invalid="!!errors.length">
                                    <FieldContent>
                                        <FieldLabel for="form-category">Category</FieldLabel>
                                        <FieldDescription>Select an office to assign the task to.</FieldDescription>
                                        <FieldError v-if="errors.length" :errors="errors" />
                                    </FieldContent>
                                    <Select :name="field.name" :model-value="field.value" @update:model-value="field.onChange">
                                        <SelectTrigger id="form-category" class="min-w-[120px]" :aria-invalid="!!errors.length">
                                            <SelectValue placeholder="Select" />
                                        </SelectTrigger>
                                        <SelectContent position="item-aligned">
                                            <SelectItem v-for="office in offices" :key="office" :value="office">
                                                {{ office }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </Field>
                            </VeeField>
                            <VeeField v-slot="{ field, errors }" name="priority">
                                <Field orientation="responsive" :data-invalid="!!errors.length">
                                    <FieldContent>
                                        <FieldLabel for="form-priority">Priority</FieldLabel>
                                        <FieldDescription>Select P1 for high priority, P5 for low priority.</FieldDescription>
                                        <FieldError v-if="errors.length" :errors="errors" />
                                    </FieldContent>
                                    <Select :name="field.name" :model-value="field.value" @update:model-value="field.onChange">
                                        <SelectTrigger id="form-priority" class="min-w-[120px]" :aria-invalid="!!errors.length">
                                            <SelectValue placeholder="Select" />
                                        </SelectTrigger>
                                        <SelectContent position="item-aligned">
                                            <SelectItem v-for="priority in priorities" :key="priority" :value="priority">
                                                {{ priority }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </Field>
                            </VeeField>
                            <VeeField v-slot="{ field, errors }" name="dueBy">
                                <Field :data-invalid="!!errors.length">
                                    <FieldLabel for="form-due-by">Due By</FieldLabel>
                                    <DatetimePicker id="form-due-by" v-bind="field" :aria-invalid="!!errors.length" />
                                    <FieldError v-if="errors.length" :errors="errors" />
                                </Field>
                            </VeeField>
                        </FieldGroup>
                        <SheetFooter>
                            <div class="flex w-full justify-end gap-2">
                                <Button variant="outline">Cancel</Button>
                                <Button variant="default" type="submit">Submit</Button>
                            </div>
                        </SheetFooter>
                    </form>
                </SheetContent>
            </Sheet>
        </div>
        <TabsContent value="All">
            <div class="flex justify-evenly">
                <KanbanColumn class="w-3/10 min-h-[calc(85dvh)] rounded-md border" title="Not Started" status="not started" v-model="notStarted" @task-moved="handleColumnChange">
                    <template #card="{ task }">
                        <KanbanCard :task="task" />
                    </template>
                </KanbanColumn>
                <KanbanColumn class="w-3/10 min-h-[calc(85dvh)] rounded-md border" title="In Progress" status="in progress" v-model="inProgress" @task-moved="handleColumnChange">
                    <template #card="{ task }">
                        <KanbanCard :task="task" />
                    </template>
                </KanbanColumn>
                <KanbanColumn class="w-3/10 min-h-[calc(85dvh)] rounded-md border" title="Complete" status="complete" v-model="complete" @task-moved="handleColumnChange">
                    <template #card="{ task }">
                        <KanbanCard :task="task" />
                    </template>
                </KanbanColumn>
            </div>
        </TabsContent>
        <TabsContent v-for="office in offices" :value="office">
            <div class="flex justify-evenly">
                <ScrollArea class="w-3/10 min-h-[calc(85dvh)] rounded-md border">
                    <h3 class="m-4 leading-none">Not Started</h3>
                </ScrollArea>
                <ScrollArea class="w-3/10 min-h-[calc(85dvh)] rounded-md border">
                    <h3 class="m-4 leading-none">In Progress</h3>
                </ScrollArea>
                <ScrollArea class="w-3/10 min-h-[calc(85dvh)] rounded-md border">
                    <h3 class="m-4 leading-none">Complete</h3>
                </ScrollArea>
            </div>
        </TabsContent>
    </Tabs>
</template>