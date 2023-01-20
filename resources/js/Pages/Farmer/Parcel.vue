<script setup>
import { inject } from "vue";

const add_farmer = inject("add_farmer");

const removeParcel = (index) => {
    add_farmer.details.parcels.splice(index, 1);
};
</script>

<template>
    <div class="relative overflow-x-auto mr-2 w-full">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-green-100">
                    <tr>
                        <th scope="col" class="px-3 py-3">Farm Parcel no.</th>
                        <th scope="col" class="px-[20vmin] py-3">
                            FARM LAND DESCRIPTION
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Crop/Commodity
                            <br />
                            (Rice/Corn/HVC/Livestock/Poultry/Agri-Fishery)
                            <br />
                            For Livestock & Poultry
                            <br />
                            (Specify type of animal)
                        </th>
                        <th scope="col" class="px-[8vmin] py-4">Size (ha)</th>
                        <th scope="col" class="px-[10vmin] py-3">
                            No. head
                            <br />
                            (For Livestock and Poultry)
                        </th>
                        <th scope="col" class="px-[10vmin] py-3">Farm Type</th>
                        <th scope="col" class="px-6 py-3">
                            Organic Practitioner (Yes/NO)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template
                        v-for="(parcel, index) in add_farmer.details.parcels"
                    >
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4" @click="removeParcel(index)">
                                {{ index + 1 }}
                            </td>
                            <td class="px-6 py-4 w-full">
                                <label
                                    for="Region"
                                    class="block mb-2 text-sm font-medium text-gray-900"
                                    >Location</label
                                >
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
                                <div class="mt-2">
                                    <label
                                        for="Total Farm area (ha)"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                    >
                                        Total Farm area (ha)</label
                                    >
                                    <input
                                        type="text"
                                        name="number_of_parcels"
                                        id="number_of_parcels"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Total Farm area (ha)"
                                        required=""
                                    />
                                </div>
                                <div class="mt-2">
                                    <label
                                        for="Ownership Document No"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                    >
                                        Ownership Document No</label
                                    >
                                    <input
                                        type="text"
                                        name="number_of_parcels"
                                        id="number_of_parcels"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Ownership Document No"
                                        required=""
                                    />
                                </div>
                                <div class="mt-2">
                                    <label
                                        for="Ownership Document No"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                    >
                                        Ownership</label
                                    >
                                    <input
                                        type="radio"
                                        id="html"
                                        name="farm_owner"
                                        value="Registered Owner"
                                    /> 
                                    <label for="html">Registered Owner</label
                                    ><br />

                                    <input
                                        type="radio"
                                        id="html"
                                        name="farm_owner"
                                        value="Tenant"
                                    />
                                    <label for="html">Tenant</label
                                    ><input
                                        type="text"
                                        name="number_of_parcels"
                                        id="number_of_parcels"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Name of Land owner"
                                        required=""
                                    />
                                    <br />
                                    <input
                                        type="radio"
                                        id="html"
                                        name="farm_owner"
                                        value="Lessee"
                                    />
                                    <label for="html">Lessee</label
                                    ><input
                                        type="text"
                                        name="number_of_parcels"
                                        id="number_of_parcels"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Name of Land owner"
                                        required=""
                                    />
                                    <br />
                                    <input
                                        type="radio"
                                        id="html"
                                        name="farm_owner"
                                        value="Others"
                                    />
                                    <label for="html">Others</label
                                    ><input
                                        type="text"
                                        name="number_of_parcels"
                                        id="number_of_parcels"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Please Specify"
                                        required=""
                                    />
                                    <br />
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <textarea
                                    name="number_of_parcels"
                                    id="number_of_parcels"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    placeholder="Specify animals"
                                    required=""
                                    cols="30"
                                    rows="30"
                                ></textarea>
                            </td>
                            <td class="px-6 py-4 w-[4vmin]">
                                <input
                                    type="number"
                                    name="number_of_parcels"
                                    id="number_of_parcels"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    placeholder="Size"
                                    required=""
                                />
                            </td>
                            <td class="px-6 py-4">
                                <input
                                    type="number"
                                    name="number_of_parcels"
                                    id="number_of_parcels"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    placeholder="Number of head"
                                    required=""
                                />
                            </td>
                            <td class="px-6 py-4">
                                <select
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    name=""
                                    id=""
                                >
                                    <option value="0">Irrigated</option>
                                    <option value="1">Rainfed Upland</option>
                                    <option value="2">Rainfed Lowland</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <select
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    name=""
                                    id=""
                                >
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>
