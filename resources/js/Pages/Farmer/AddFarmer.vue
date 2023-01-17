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
import { reactive } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
</script>

<template>
    <AppLayout title="Farms">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <PrimaryButton class="my-2 bg-green-600" @click="showModal()"
                    >Save</PrimaryButton
                >
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <div>2x2 picture taken within 6 months</div>
                    <div class="flex m-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="text"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Surname</label
                            >
                            <input
                                type="text"
                                name="text"
                                id="Surname"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Surname"
                                required=""
                            />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="First Name"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >First Name</label
                            >
                            <input
                                type="text"
                                name="first_name"
                                id="first_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="First Name"
                                required=""
                            />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Middle Name"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Middle Name</label
                            >
                            <input
                                type="text"
                                name="middle_name"
                                id="middle_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Middle Name"
                                required=""
                            />
                        </div>
                        <div class="w-1/4">
                            <label
                                for="Extension Name"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Extension Name</label
                            >
                            <input
                                type="text"
                                name="extension_name"
                                id="extension_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Extension Name"
                                required=""
                            />
                        </div>
                    </div>

                    <hr />
                    <div class="flex mt-4 m-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="Extension Name"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Extension Name</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Mobile Number"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Mobile Number</label
                            >
                            <input
                                type="text"
                                name="mobile_number"
                                id="mobile_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Mobile Number"
                                required=""
                            />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Date of Birth"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Date of Birth</label
                            >
                            <input
                                type="date"
                                name="date_of_birth"
                                id="date_of_birth"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Date of Birth"
                                required=""
                            />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Place of Birth"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Place of Birth</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                    </div>
                    <hr />
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="Region"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Region</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Province"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Province</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Municipality/City"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Municipality/City</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="Baranggay"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Baranggay</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Street"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Street</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="House/Lot"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >House/Lot</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                    </div>
                    <hr />
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="Status"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Status</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Single</option>
                                <option value="1">Widowed</option>
                                <option value="2">Maried</option>
                                <option value="3">Separated</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Religion"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Religion</label
                            >
                            <input
                                type="text"
                                name="religion"
                                id="religion"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Religion"
                                required=""
                            />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Name of spouse if married"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Name of spouse if married</label
                            >
                            <input
                                type="text"
                                name="spouse"
                                id="spouse"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Name of spouse if married"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="flex m-2 mt-2">
                        <div class="mr-2 w-full">
                            <label
                                for="Mother's Maiden Name"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Mother's Maiden Name</label
                            >
                            <input
                                type="text"
                                name="mother"
                                id="mother"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Mother's Maiden Name"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="Household head?"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Household head?</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="If no, name of household head"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >If no, name of household head</label
                            >
                            <input
                                type="text"
                                name="household_head"
                                id="household_head"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="If no, name of household head"
                                required=""
                            />
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="Relationship"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Relationship</label
                            >
                            <input
                                type="text"
                                name="relationship"
                                id="relationship"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Relationship"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="flex mt-2 m-2">
                        <div class="mr-2 w-1/2">
                            <label
                                for="Number of living household members"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Number of living household members</label
                            >
                            <input
                                type="number"
                                name="household_total_members"
                                id="household_total_members"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Number of living household members
Number of living household members"
                                required=""
                            />
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="Number of Male"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Number of Male</label
                            >
                            <input
                                type="number"
                                name="household_male_members"
                                id="household_male_members"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Number of Male"
                                required=""
                            />
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="Number of Female"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Number of Female</label
                            >
                            <input
                                type="number"
                                name="household_female_members"
                                id="household_female_members"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Number of Female"
                                required=""
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
