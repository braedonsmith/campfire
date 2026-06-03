<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Heading from '@/components/Heading.vue';
import { Table, TableBody, TableCaption, TableCell, TableRow } from '@/components/ui/table';
import { edit } from '@/routes/profile';

type Props = {
    mustVerifyEmail: boolean;
    status?: string;
};

defineProps<Props>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Profile settings',
                href: edit(),
            },
        ],
    },
});

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <Head title="Profile settings" />

    <h1 class="sr-only">Profile settings</h1>

    <div class="flex flex-col space-y-6">
        <Heading
            variant="small"
            title="Profile information"
        />

        <Table>
            <TableCaption>This information is controlled by eServices. If any of this information appears wrong, contact the Administrative Office for support.</TableCaption>
            <TableBody>
                <TableRow>
                    <TableCell>CAPID</TableCell>
                    <TableCell>{{ user.capid.toString() }}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>Name</TableCell>
                    <TableCell>{{ user.first_name + ' ' + user.last_name }}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>Rank</TableCell>
                    <TableCell>{{ user.rank }}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>Email Address</TableCell>
                    <TableCell>{{ user.email }}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>Home Unit</TableCell>
                    <TableCell>{{ user.home_unit }}</TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
    <p>Last updated: {{ new Date(user.updated_at).toString() }}</p>
</template>
