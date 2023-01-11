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
import { reactive, ref } from "vue";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

import moment from "moment";

const post_images = ref([]);

const post_data = useForm({
    title: "",
    content: "",
    photos: []
});

const date_conversion = (value) => {
    if (value) {
        return moment(value).format("MMMM Do YYYY, h:mm:ss a");
    }
};

const only_date_conversion = (value) => {
    if (value) {
        return moment(value).format("MMMM Do YYYY");
    }
};

const date_conversion_from_now = (value) => {
    if (value) {
        return moment(value).fromNow();
    }
};

const post_content = () => {
    if (post_data.title == '' || post_data.content == '') {
        alert("System will not allow empty captions or title, please try again")
    }
    else {
        post_data.post(route("timeline.store"), {
            preserveScroll: true,
            onSuccess: () => {
                alert("Successfully posted");
                post_data.reset()
                var element = document.getElementsByClassName("ql-editor");
                element[0].innerHTML = "";
                post_images.value = [];
                post_data.photos = [];
            },
        });
    }

};

const openFile = () => {
    let hidden = document.getElementById("post_image");
    hidden.click();
    hidden.onchange = (e) => {
        if (post_images.value.length + e.target.files.length > 4) {
            alert("Only 4 images can be selected");
            return;
        } else {
            for (let index = 0; index < e.target.files.length; index++) {
                post_images.value.push(
                    window.URL.createObjectURL(e.target.files[index])
                );
                post_data.photos.push(e.target.files[index]);
            }
        }
    };
};

const remove_image = (key) => {
    post_images.value.splice(key, 1);
    post_data.photos.splice(key, 1);
};
</script>

<template>
    <AppLayout title="Timeline">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- <p class="text-[3vmin] text-bold mb-4">Timeline</p> -->
                <div class="bg-gray-200 p-3 shadow-sm rounded-lg mb-6 mt-4">
                    <p class="text-lg">What's on your mind?</p>
                    <div class="w-full h-[20vmin] flex items-center flex justify-between px-5 mt-2">
                        <a>
                            <img class="rounded-full w-10 h-10 mr-3" :src="
                                usePage().props.value.user.profile_photo_url
                            " alt="" />
                        </a>
                        <div class="w-full">
                            <div class="relative block w-full mt-2 sm:mt-10 md:mt-10">
                                <input v-model="post_data.title"
                                    class="bg-gray-50 max-h-sm border border-gray-300 overflow-hidden text-gray-900 text-sm rounded-lg border-t-1 border-gray-500 focus:ring-blue-500 focus:border-blue-500 block w-full relative p-2.5"
                                    type="text" placeholder="Title" required />
                            </div>
                            <div class="relative w-full mb-5 mt-2">
                                <QuillEditor v-model:content="
                                    post_data.content
                                " theme="snow" toolbar="minimal" id="postEditor" :content="post_data?.content"
                                    contentType="html" class="min-h-[10vmin] max-h-[10vmin] overflow-auto">
                                </QuillEditor>
                            </div>
                        </div>

                    </div>
                    <div class="mt-10 w-full h-10 flex justify-between mt-6 px-3 md:px-10 lg:px-24 xl:px-5">
                        <div class="flex">
                            <button @click="openFile()" class="flex h-full items-center">
                                <svg class="h-12 text-green-500 stroke-current" xmlns="http://www.w3.org/2000/svg"
                                    width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="#b0b0b0"
                                    stroke-width="2" stroke-linecap="square" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <path d="M20.4 14.5L16 10 4 20" />
                                </svg>
                                <span class="text-xs lg:text-md mx-2 font-semibold text-gray-500">Upload Photo
                                </span>
                            </button>
                        </div>
                        <input id="post_image" type="file" class="hidden" accept="image/png, image/gif, image/jpeg"
                            multiple />

                        <!-- <template v-for="image in post_images">
                                        <img class="h-auto" :src="image" />
                                    </template> -->

                        <button @click="post_content()" type="button"
                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                            Post
                            <svg aria-hidden="true" class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div v-if="post_images != null" class="grid mt-2 grid-cols-1 lg:grid-cols-4">
                        <div v-for="(image, key) in post_images" :key="key">
                            <div class="w-auto mt-2 mx-auto lg:max-w-[20vmin] z-30">
                                <div class="shadow-lg bg-white p-3">
                                    <img class="w-full max-h-[40vmin] object-cover" :src="image" />
                                    <ul class="mt-3 flex justify-end flex-wrap">
                                        <li>
                                            <button @click="
                                                remove_image(key)
                                            " class="flex text-gray-400 hover:text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path class="text-red-500" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                <span class="text-red-500">Remove</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-2">
                    <ol class="relative border-l border-gray-200">
                        <li class="mb-10 ml-6" v-for="(post, key) in usePage().props.value
                        .timelines" :key="key">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-blue-200 rounded-full -left-3 ring-8 ring-white">
                                <!-- <svg
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
                                </svg> -->
                                <img class="w-6 h-6 text-blue-600" :src="
                                    post.user
                                        .profile_photo_url
                                " alt="" style="border-radius: 50%" />
                            </span>
                            <h3 class="mb-1 ml-4 text-lg font-semibold text-gray-900">
                                {{ post.title }}
                                <span
                                    class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded ml-4">{{
                                        only_date_conversion(post.created_at)
                                    }}</span>
                                <div class="inline float-right"
                                    v-if="usePage().props.value.user.id == post.user.id || usePage().props.value.user.is_admin">
                                    <button
                                        class="bg-orange-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded ml-3">
                                        edit
                                    </button>
                                    <button
                                        class="bg-red-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded ml-3">
                                        delete
                                    </button>
                                </div>
                            </h3>
                            <time class="block mb-2 ml-4 text-sm font-normal leading-none text-gray-400">Posted on
                                {{
                                    only_date_conversion(post.created_at)
                                }}</time>
                            <p class="text-base font-normal text-gray-500 ml-4 mt-4">
                            <div v-html="post.content"></div>
                            </p>
                            <div class="flex justify-center">
                                <div class="flex gap-1">
                                    <template v-for="(photo, key) in post.photo" :key="key">
                                        <div class="justify-center" v-if="post.photo.length == 1">
                                            <img :src="'/images/posts/' + photo" alt="" class="h-[50vmin] ">
                                        </div>
                                        <div class="flex justify-between mr-4" v-if="post.photo.length == 2">
                                            <img :src="'/images/posts/' + photo" alt="" class="h-[30vmin] ">
                                        </div>
                                        <div class="flex justify-between mr-4" v-if="post.photo.length == 3">
                                            <div>
                                                <img :src="'/images/posts/' + photo" alt="" class="h-[30vmin] ">
                                            </div>
                                        </div>
                                    </template>
                                </div>

                            </div>

                        </li>
                        <div class="text-[4vmin] font-bold text-gray-500 ml-[43%]">
                            End of post
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
