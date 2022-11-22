<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SelectInput from "@/Components/SelectInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import FarmCard from "@/Components/FarmCard.vue";
import Icon from "@/Components/Icons.vue";
import Map from "./Map.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps(["farms", "farmers"]);
const form = useForm({
    selected: "all",
});
</script>

<template>
    <AppLayout title="Farms">
        <div class="pb-4">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-2"
                >
                    <div class="grid grid-cols-8 gap-1 p-6">
                        <div class="col-span-2">
                            <InputLabel value="Farms" />
                            <div class="flex gap-1">
                                <SelectInput
                                    class="block w-full"
                                    v-model="form.selected"
                                >
                                    <option value="all">All</option>
                                    <template v-for="farmer in farmers">
                                        <option :value="farmer.id">
                                            {{ farmer.name }}
                                        </option>
                                    </template>
                                </SelectInput>
                                <PrimaryButton class="w-36"
                                    ><span>Add Farm</span></PrimaryButton
                                >
                            </div>
                            <template v-for="farm in [1, 2, 3]">
                                <FarmCard>
                                    <template #actions>
                                        <div class="cursor-pointer">
                                            <Icon icon="delete" />
                                        </div>
                                        <div class="cursor-pointer">
                                            <Icon icon="edit" />
                                        </div>
                                    </template>
                                    <template #content>
                                        <div>Name: Farm 1</div>
                                        <div>Owner: Ajeje</div>
                                        <div>Income: 100</div>
                                        <div>Color:</div></template
                                    >
                                    <template #footer>
                                        <PrimaryButton>Map</PrimaryButton>
                                        <PrimaryButton>Plant</PrimaryButton>
                                    </template>
                                </FarmCard>
                            </template>
                        </div>
                        <div class="col-span-6">
                            <Map />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
