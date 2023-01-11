<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Icon from "@/Components/Icons.vue";
import { reactive } from "vue";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

import moment from "moment";
</script>

<template>
    <AppLayout title="Timeline">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- <p class="text-[3vmin] text-bold mb-4">Timeline</p> -->
                <div class="bg-gray-200 p-3 shadow-sm rounded-lg mb-6 mt-4">
                    <p class="text-lg">What's on your mind?</p>
                    <div
                        class="w-full h-16 flex items-center flex justify-between px-5"
                    >
                        <a>
                            <img
                                class="rounded-full w-10 h-10 mr-3"
                                :src="
                                    usePage().props.value.user.profile_photo_url
                                "
                                alt=""
                            />
                        </a>

                        <div class="flex w-full items-center">
                            <div class="relative w-full mb-5 mt-10">
                                <textarea
                                    id="postEditor"
                                    class="bg-gray-50 max-h-sm border border-gray-300 overflow-hidden text-gray-900 text-sm rounded-lg border-t-1 border-gray-500 focus:ring-blue-500 focus:border-blue-500 block w-full relative p-2.5"
                                    contentType="html"
                                >
                                </textarea>
                                <!-- <QuillEditor
                                                v-model:content="
                                                    post_data.content
                                                "
                                                theme="snow"
                                                toolbar="minimal"
                                                id="postEditor"
                                                :content="post_data?.content"
                                                contentType="html"
                                            ></QuillEditor> -->
                            </div>
                        </div>
                    </div>
                    <div
                        class="w-full h-10 flex justify-between mt-6 px-3 md:px-10 lg:px-24 xl:px-5"
                    >
                        <div class="flex">
                            <button class="flex h-full items-center">
                                <svg
                                    class="h-12 text-green-500 stroke-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="27"
                                    height="27"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#b0b0b0"
                                    stroke-width="2"
                                    stroke-linecap="square"
                                    stroke-linejoin="round"
                                >
                                    <rect
                                        x="3"
                                        y="3"
                                        width="18"
                                        height="18"
                                        rx="2"
                                    />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <path d="M20.4 14.5L16 10 4 20" />
                                </svg>
                                <span
                                    class="text-xs lg:text-md mx-2 font-semibold text-gray-500"
                                    >Upload Photo
                                </span>
                            </button>
                        </div>
                        <input
                            id="post_image"
                            type="file"
                            class="hidden"
                            accept="image/png, image/gif, image/jpeg"
                            multiple
                        />

                        <!-- <template v-for="image in post_images">
                                        <img class="h-auto" :src="image" />
                                    </template> -->

                        <button
                            type="button"
                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
                        >
                            Post
                            <svg
                                aria-hidden="true"
                                class="ml-2 -mr-1 w-5 h-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-2"
                >
                    <ol class="relative border-l border-gray-200">
                        <li class="mb-10 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-blue-200 rounded-full -left-3 ring-8 ring-white"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-3 h-3 text-blue-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </span>
                            <h3
                                class="flex items-center mb-1 text-lg font-semibold text-gray-900"
                            >
                                Flowbite Application UI v2.0.0
                                <span
                                    class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded ml-3"
                                    >Latest</span
                                >
                            </h3>
                            <time
                                class="block mb-2 text-sm font-normal leading-none text-gray-400"
                                >Posted on January 13th, 2022</time
                            >
                            <p class="mb-4 text-base font-normal text-gray-500">
                                Get access to over 20+ pages including a
                                dashboard layout, charts, kanban board,
                                calendar, and pre-order E-commerce & Marketing
                                pages.
                            </p>
                            <a
                                href="#"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200 focus:text-blue-700"
                                ><svg
                                    class="w-4 h-4 mr-2"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                Download ZIP</a
                            >
                        </li>
                        <li class="mb-10 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-blue-200 rounded-full -left-3 ring-8 ring-white"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-3 h-3 text-blue-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </span>
                            <h3
                                class="mb-1 text-lg font-semibold text-gray-900"
                            >
                                Flowbite Figma v1.3.0
                                <span
                                    class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded ml-3"
                                    >Latest</span
                                >
                            </h3>
                            <time
                                class="block mb-2 text-sm font-normal leading-none text-gray-400"
                                >Released on December 7th, 2021</time
                            >
                            <p class="text-base font-normal text-gray-500">
                                All of the pages and components are first
                                designed in Figma and we keep a parity between
                                the two versions even as we update the project.
                            </p>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
