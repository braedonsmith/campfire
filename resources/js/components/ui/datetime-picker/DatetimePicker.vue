<script setup lang="ts">
import { computed, ref, Ref, watch } from 'vue';
import { Label } from '../label';
import { Popover, PopoverContent, PopoverTrigger } from '../popover';
import { Button } from '../button';
import { ChevronDownIcon } from 'lucide-vue-next';
import { Calendar } from '../calendar';
import { Input } from '../input';
import { type DateValue, getLocalTimeZone, now, today, toZoned } from '@internationalized/date';

const props = defineProps<{
    modelValue?: string | null
}>();

const date = ref(today(getLocalTimeZone())) as Ref<DateValue>;
const open = ref(false);

const timezone = getLocalTimeZone();
const nowTime = now(timezone);

const time = ref(`${String(nowTime.hour).padStart(2, '0')}:${String(nowTime.minute).padStart(2, '0')}:${String(nowTime.second).padStart(2, '0')}`);

const iso = computed(() => {
    if (!date.value || !time.value) {
        return null;
    }

    const [hour, minute, second] = time.value.split(':').map(Number);

    const zoned = toZoned(date.value, timezone).set({
        hour,
        minute,
        second: second ?? 0,
        millisecond: 0
    });

    return zoned.toAbsoluteString();
});

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | null): void
}>();

watch(iso, (value) => {
    emit('update:modelValue', value);
});

watch(
  () => props.modelValue,
  (val) => {
    if (!val) {
        return;
    }

    const d = new Date(val);

    date.value = today(timezone); // fallback
    date.value = {
      calendar: date.value.calendar,
      era: date.value.era,
      year: d.getFullYear(),
      month: d.getMonth() + 1,
      day: d.getDate()
    } as DateValue;

    time.value = `${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}:${String(d.getSeconds()).padStart(2, '0')}`;
  },
  { immediate: true }
);

</script>

<template>
    <div class="flex gap-4">
        <div class="flex flex-col gap-3">
            <Label for="date-picker" class="px-1">Date</Label>
            <Popover v-model:open="open">
                <PopoverTrigger as-child>
                    <Button variant="outline" id="date-picker" class="justify-between font-normal">
                        {{ date ? date.toDate(getLocalTimeZone()).toLocaleDateString() : 'Pick a date' }}
                        <ChevronDownIcon />
                    </Button>
                </PopoverTrigger>
                <PopoverContent class="w-auto overflow-hidden p-0" align="start">
                    <Calendar mode="single" :model-value="date" layout="month-and-year" @update:model-value="(value) => {
                        if (value) {
                            date = value
                            open = false
                        }
                    }" />
                </PopoverContent>
            </Popover>
        </div>
        <div class="flex flex-col gap-3">
            <Label for="time-picker" class="px-1">Time</Label>
            <Input type="time" id="time-picker" step="1" v-model="time" class="bg-background appearance-none [&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none" />
        </div>
    </div>
</template>