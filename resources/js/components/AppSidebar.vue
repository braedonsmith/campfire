<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { CalendarClock, Car, Contact, LayoutGrid, ListTodo, RadioTower, UserPen, Users, Wheat } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Org Chart',
        href: '',
        icon: Contact
    },
    {
        title: 'Kanban Board',
        href: '',
        icon: ListTodo
    },
    {
        title: 'Headcounts',
        href: '',
        icon: Users
    },
    {
        title: 'User Management',
        href: '',
        icon: UserPen,
    },
    {
        title: 'Schedule Management',
        href: '',
        icon: CalendarClock
    },
    {
        title: 'Radio Management',
        href: '',
        icon: RadioTower
    },
    {
        title: 'Vehicle Management',
        href: '',
        icon: Car
    }
];

const footerNavItems: NavItem[] = [
    {
        title: 'Encampment Website \u2197',
        href: 'https://kswg.cap.gov/encampment',
        icon: Wheat,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
