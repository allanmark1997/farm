<template>
    <div class="bg-slate-50 border-white shadow-lg rounded-lg my-2 p-2">
        <div class="flex flex-row-reverse gap-3">
            <slot name="actions"></slot>
        </div>
        <div class="w-full">
            <slot name="content"></slot>
        </div>
        <div
            v-if="$slots.footer"
            class="flex flex-row justify-end px-2 py-2 bg-gray-100 text-right gap-1"
        >
            <slot name="footer" />
        </div>
    </div>
</template>
