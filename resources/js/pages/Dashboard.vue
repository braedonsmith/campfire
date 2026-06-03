<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <Card class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <CardHeader>
                    <CardTitle>My Active Tasks</CardTitle>
                </CardHeader>
                <CardContent>
                    <PlaceholderPattern />
                </CardContent>
            </Card>
            <Card class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <CardHeader>
                    <CardTitle>Messages</CardTitle>
                </CardHeader>
                <CardContent>
                    <PlaceholderPattern />
                </CardContent>
            </Card>
            <Card class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <CardHeader>
                    <CardTitle>Today's Safety Message</CardTitle>
                </CardHeader>
                <CardContent>
                    <PlaceholderPattern />
                </CardContent>
            </Card>
        </div>
        <Card class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
            <CardHeader>
                <CardTitle>My Schedule</CardTitle>
            </CardHeader>
            <CardContent>
                <PlaceholderPattern />
            </CardContent>
        </Card>
    </div>
</template>
