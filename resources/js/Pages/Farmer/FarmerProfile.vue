<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import Pagination from "@/Components/Pagination.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
// import formPDF from "../../../../storage/Form.pdf";
import Icon from "@/Components/Icons.vue";
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import moment from "moment";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps(["farmer"]);
</script>
<template>
    <AppLayout title="Farmer">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 pb-12 mt-2"
                >
                    Profile
                </div>
            </div>
        </div>
    </AppLayout>
</template>
