<script setup>
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import formImg from "../../assets/farm.jpg";
import formPDF from "../../../storage/Form.pdf";

import moment from "moment";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    // timelines: String,
});

const only_date_conversion = (value) => {
    if (value) {
        return moment(value).format("MMMM Do YYYY");
    }
};

const downloadItem = (url) => {
    axios({
        method: "get",
        url,
        responseType: "arraybuffer",
    })
        .then((response) => {
            forceFileDownload(response, "Registration Form.pdf");
        })
        .catch((e) => console.log(e + " error occured"));
};
const forceFileDownload = (response, title) => {
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", title);
    document.body.appendChild(link);
    link.click();
};
const SendResume = () => {
    var yourMessage = "Your Message:";
    var subject = "Subject: ";
    var mail =
        "mailto:" +
        "maolantapan@gmail.com" +
        "?subject=" +
        subject +
        "&body=" +
        yourMessage;

    window = window.open(mail, "emailWindow");
};
</script>
<style>
.strokeme {
    color: white;
    text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000,
        1px 1px 0 #000;
}
</style>

<template>
    <Head title="Welcome" />

    <div class="relative bg-slate-100">
        <div
            v-if="canLogin"
            class="hidden fixed top-0 right-0 px-6 py-4 sm:block z-20"
        >
            <Link
                v-if="$page.props.user"
                :href="route('timeline.index')"
                class="text-sm text-blue-700 underline"
                >Timeline</Link
            >

            <template v-else>
                <a
                    @click="downloadItem(formPDF)"
                    class="text-md text-white strokeme mr-3 cursor-pointer"
                    >Registration form (download here)</a
                >

                <Link
                    :href="route('login')"
                    class="text-md text-white underline strokeme"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 underline"
                    >Register</Link
                >
            </template>
        </div>
        <div class="relative">
            <div
                class="text-white text-[4vmin] font-bold relative bg-hero bg-no-repeat bg-cover bg-center h-[55vh] flex flex-col justify-center items-center strokeme"
                style="
                    background-image: url('./images/background/background.png');
                    background-size: 100%;
                    /* background-image: url('http://[::1]:5173/resources/assets/farm.jpg'); */
                    /* background-image: url('https://images.unsplash.com/photo-1444858291040-58f756a3bdd6?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1678&q=80'); */
                "
            >
                <div>Growing strong, from the ground up.</div>
                <div>Nurturing the land, nourishing the soul.</div>
                <div>From seed to harvest, we cultivate success.</div>
            </div>
        </div>
        <div class="bg-slate-100 py-4">
            <div class="grid grid-cols-8 mx-6 gap-4">
                <div
                    class="mt-6 col-span-4 text-center italic font-bold font-mono"
                >
                    "THE LGU OF LANTAPAN SHALL PROVIDE ATMOSPHERE ENSURING
                    SUSTAINABLE QUALITY HIGH VALUED CROPS PRODUCTION BY
                    ENHANCING MARKETTING ACCESS AND ADOPTING ATRRACTIVE
                    INVESTMENT POLICIES THAT ESTABLISHES A DYNAMIC PARTNERSHIP
                    WITH MULTI-STAKEHOLDERS AND FACILITATE ADEQUATE DELIVERY OF
                    BASIC SERVICES."
                    <br />
                    - Mission
                </div>
                <div
                    class="mt-6 col-span-4 text-center italic font-bold font-mono"
                >
                    "WE ENVISIONED LANTAPAN AS THE PRIME VEGETABLES BASKET OF
                    BUKIDNON, WITH A DEVELOPED AGRI-BASED INDUSTRY THROUGH
                    RESPONSIVE LOCAL GOVERNANCE WHERE SELF-RELIANT PEOPLE ENJOY
                    THE FULL LIFE IN A GOD-CENTERED COMMUNITY & HEALTHY
                    ENVIRONMENT, IN A PPRESERVED CULTURE."
                    <br />
                    - Vission
                </div>
            </div>
        </div>
        <hr />
        <div class="bg-slate-100 py-4">
            <div
                class="flex justify-center items-center font-bold text-4xl font-black text-gray-900 pb-6 mt-6"
            >
                Events
            </div>
            <div class="grid grid-cols-8 mx-6 gap-4">
                <div
                    :class="
                        usePage().props.value.events.length == 1
                            ? 'col-span-8'
                            : 'col-span-4'
                    "
                    v-for="(events, index) in usePage().props.value.events"
                    :key="index"
                >
                    <a
                        class="flex bg-white border rounded-lg shadow-md md:flex-row md:max-w-[100%] h-[100%]"
                    >
                        <img
                            class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg"
                            :src="
                                events.photo == 0
                                    ? '/images/logo/logoL.png'
                                    : '/images/events/' + events.photo[0]
                            "
                            alt=""
                        />
                        <div class="flex flex-col justify-between p-4">
                            <h5
                                class="mb-2 text-2xl font-bold tracking-tight text-gray-900"
                            >
                                {{ events.title }}
                            </h5>
                            <small
                                >Posted on
                                {{
                                    only_date_conversion(events.created_at)
                                }}</small
                            >

                            <p
                                class="mb-3 mt-4 font-normal text-gray-700 indent-8"
                            >
                                <span v-html="events.content"></span>
                            </p>
                            <div class="justify-between">
                                <small class="mr-4"
                                    >From:
                                    {{
                                        only_date_conversion(events.started_at)
                                    }}</small
                                >
                                <small
                                    >To:
                                    {{
                                        only_date_conversion(events.ended_at)
                                    }}</small
                                >
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <hr />
        <div class="bg-slate-100 py-4">
            <div
                class="flex justify-center items-center font-bold text-4xl font-black text-gray-900 pb-6 mt-6"
            >
                Objectives
            </div>
            <div class="flex justify-center items-center mx-14">
                <div class="border py-4 px-12 rounded-lg shadow-lg">
                    "Accurate mapping of your land: This will help you to have a
                    clear understanding of the size and shape of your land, as
                    well as the location of different features such as fields,
                    irrigation systems, and buildings. Monitoring crop health
                    and growth: By regularly monitoring your crops, you can
                    identify any issues that may be affecting their health or
                    growth, such as pests, diseases, or nutrient deficiencies.
                    Optimizing crop management practices: By analyzing data on
                    crop health and growth, you can determine which management
                    practices are most effective for your specific crops and
                    conditions. This may include adjusting irrigation schedules,
                    applying fertilizers, or implementing pest control measures.
                    Identifying areas of potential yield loss: By monitoring
                    crops over time, you can identify areas where yields are
                    consistently lower than expected, which may be due to issues
                    such as soil quality, irrigation problems, or pest
                    infestations."
                </div>
            </div>
            <div></div>
        </div>
        <div class="bg-slate-100 py-4">
            <hr
                class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8"
            />
            <div class="sm:flex sm:items-center sm:justify-between">
                <span
                    class="text-sm text-gray-500 sm:text-center dark:text-gray-400"
                    >© 2022 . All Rights Reserved.
                </span>
                <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        version="1.1"
                        viewBox="0 0 256 256"
                        xml:space="preserve"
                        class="w-4 h-4"
                    >
                        <defs></defs>
                        <g
                            style="
                                stroke: none;
                                stroke-width: 0;
                                stroke-dasharray: none;
                                stroke-linecap: butt;
                                stroke-linejoin: miter;
                                stroke-miterlimit: 10;
                                fill: none;
                                fill-rule: nonzero;
                                opacity: 1;
                            "
                            transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)"
                        >
                            <path
                                d="M 38.789 51.211 l 10.876 10.876 c 0.974 0.974 2.471 1.194 3.684 0.543 l 13.034 -6.997 c 0.964 -0.518 2.129 -0.493 3.07 0.066 l 19.017 11.285 c 1.357 0.805 1.903 2.489 1.268 3.933 c -1.625 3.698 -4.583 10.476 -5.758 13.473 c -0.247 0.631 -0.615 1.209 -1.127 1.652 c -12.674 10.986 -37.89 -2.4 -57.191 -21.701 C 6.358 45.039 -7.028 19.823 3.958 7.149 c 0.444 -0.512 1.022 -0.88 1.652 -1.127 c 2.996 -1.175 9.775 -4.133 13.473 -5.758 c 1.444 -0.635 3.128 -0.089 3.933 1.268 l 11.285 19.017 c 0.558 0.941 0.583 2.106 0.066 3.07 L 27.37 36.651 c -0.651 1.213 -0.431 2.71 0.543 3.684 C 27.913 40.335 38.789 51.211 38.789 51.211 z"
                                style="
                                    stroke: none;
                                    stroke-width: 1;
                                    stroke-dasharray: none;
                                    stroke-linecap: butt;
                                    stroke-linejoin: miter;
                                    stroke-miterlimit: 10;
                                    fill: rgb(0, 0, 0);
                                    fill-rule: nonzero;
                                    opacity: 1;
                                "
                                transform=" matrix(1 0 0 1 0 0) "
                                stroke-linecap="round"
                            />
                        </g>
                    </svg>
                    <p>0991 - 772 - 2538</p>
                    <a
                        href="https://www.facebook.com/mao.lantapan"
                        target="_blank"
                        class="text-gray-500 hover:text-gray-900 dark:hover:text-white"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span class="sr-only">Facebook page</span>
                    </a>
                    <a
                        href="#"
                        @click="SendResume()"
                        class="text-gray-500 hover:text-gray-900 dark:hover:text-white mr-6"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 488 512"
                            class="w-4 h-4 mr-2"
                        >
                            <path
                                fill="currentColor"
                                d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"
                            />
                        </svg>
                        <span class="sr-only">gmail</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
