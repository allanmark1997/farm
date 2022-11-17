<template>
    <div class="not-prose relative bg-slate-50 rounded-xl border">
        <div class="shadow-sm mb-12">
            <table class="border-collapse table-fixed w-full text-sm">
                <thead>
                    <tr class="text-left bg-slate-50 text-xs font-strong">
                        <slot name="header"></slot>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <slot name="body"></slot>
                </tbody>
            </table>
        </div>
    </div>
</template>
