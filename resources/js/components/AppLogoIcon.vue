<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 148.705 148.705"
        :class="className"
        v-bind="$attrs"
    >
        <g style="display:inline" transform="translate(-54 -61.42)">
            <path style="opacity:1;fill:#75391c;stroke:#fff;stroke-width:1;stroke-linecap:round;stroke-dasharray:none;stroke-opacity:1" d="m162.584 189.657-63.567-27.66c-10.091.19-12.72 9.865-7.098 16.909l64.089 29.226c-8.727-7.997-1.525-18.8 6.576-18.475z"/>
            <ellipse style="opacity:1;fill:#75391c;stroke:#fff;stroke-width:1;stroke-linecap:round;stroke-dasharray:none;stroke-opacity:1" cx="223.481" cy="123.837" rx="7.881" ry="9.812" transform="rotate(22.258)"/>
        </g>
        <g transform="translate(-54 -61.42)">
            <ellipse style="opacity:1;fill:#75391c;stroke:#fff;stroke-width:1.07781;stroke-linecap:round;stroke-dasharray:none;stroke-opacity:1" cx="51.174" cy="216.053" rx="8.155" ry="9.877" transform="rotate(-12.544)"/>
            <path style="opacity:1;fill:#75391c;stroke:#fff;stroke-width:1;stroke-linecap:round;stroke-dasharray:none;stroke-opacity:1" d="m92.44 190.91 65.551-30.062c10.922 1.44 11.807 10.153 8.246 16.91l-63.984 30.27c8.275-11.442-2.153-20.881-9.812-17.119z"/>
            <path style="opacity:.64;fill:#75391c;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-dasharray:none;stroke-opacity:1" d="m105.488 198.529 16.805-7.828m5.741-2.714 9.081-4.071"/>
        </g>
        <g style="opacity:1">
            <path style="opacity:1;fill:#ff7f2a;stroke:#fff;stroke-width:1;stroke-linecap:round;stroke-dasharray:none;stroke-opacity:1" d="M161.227 105.945c-2.7 5.787-7.39 9.87-13.987 12.317 6.881-20.419-.977-39.112-20.25-56.47 1.663 3.897 1.068 22.705-14.926 36.637-18.724 16.311-18.62 59.337 16.805 59.497 40.25.18 39.863-39.746 32.358-51.981z" transform="translate(-54 -61.42)"/>
            <path style="opacity:1;fill:#ff0;stroke:none;stroke-width:1;stroke-linecap:round;stroke-dasharray:none;stroke-opacity:1" d="M133.097 110.903c-7.094 7.403-14.49 14.626-10.177 28.547l-7.411-5.74c-1.307.412-4.862 20.404 5.13 22.779 5.774 1.373 11.985 1.072 17.523.163 8.619-1.415 12.321-16.473 3.076-24.456-5.41-4.672-9.888-18.122-8.141-21.293" transform="translate(-54 -61.42)"/>
        </g>
    </svg>
</template>
