<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Sheet, SheetContent, SheetFooter, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { User } from '@/types';
import { useForm, Head } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm as useVeeForm, Field as VeeField } from 'vee-validate';
import { ListPlus } from 'lucide-vue-next';
import { z } from 'zod';
import { Field, FieldContent, FieldDescription, FieldError, FieldGroup, FieldLabel } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { ref } from 'vue';
import { DatetimePicker } from '@/components/ui/datetime-picker';
import { getLocalTimeZone, now } from '@internationalized/date';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { ScrollArea } from '@/components/ui/scroll-area';

const props = defineProps(['tasks']);

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

function formatName(member?: User) {
    if (!member) {
        return "Unassigned";
    }

    return `${member.rank} ${member.first_name} ${member.last_name}`;
}

const validationSchema = toTypedSchema(
    z.object({
        title: z.string().nonempty(),
        description: z.string().optional(),
        category: z.string().optional(),
        priority: z.enum(['P1', 'P2', 'P3', 'P4', 'P5']),
        dueBy: z.iso.datetime()
    })
);

const { handleSubmit, resetForm } = useVeeForm({
    validationSchema,
    initialValues: {
        title: '',
        description: '',
        category: '',
        priority: 'P3',
        dueBy: now(getLocalTimeZone()).toAbsoluteString()
    }
});

const form = useForm({
    title: '',
    description: '',
    category: '',
    priority: 'P3',
    dueBy: ''
});

const onSubmit = handleSubmit((data) => {
    console.log(JSON.stringify(data)); // DEBUG

    form.title = data.title;
    form.description = data.description ?? "";
    form.category = data.category ?? "";
    form.priority = data.priority;
    form.dueBy = data.dueBy;

    form.post('', {
        onError: (serverErrors) => {
            // TODO
            console.log(JSON.stringify(serverErrors));
        }
    });

    resetForm();
});

const offices = ['Executive Staff', 'Administration', 'Chaplain', 'Curriculum and Plans', 'Logistics', 'Operations', 'Public Affairs', 'Safety'];

const priorities = ['P1', 'P2', 'P3', 'P4', 'P5'];

const isOpen = ref(false);

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

    <div class="flex w-full justify-end">
        
    </div>
</template>