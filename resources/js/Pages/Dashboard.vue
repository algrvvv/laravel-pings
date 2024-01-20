<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {TailwindPagination} from 'laravel-vue-pagination';

</script>

<script>
export default {
    props: [
        "info",
    ],

    data() {
        return {
            name: '',
            message: ''
        }
    },

    created() {
        Echo.channel('new-ping')
            .listen('.new-ping', res => {
                this.info.unshift(res.info);
            });
    },

    methods: {
        store() {
            axios.post('/domains', {name: this.name})
                .then(res => {
                    console.log(res);
                    this.message = res.data;
                    this.name = '';
                });
        }
    }
}

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Добавление нового домена -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 flex p-2">
                    <input type="text" placeholder="New domain" v-model="name"
                           class="shadow appearance-none border-indigo-400 rounded w-1/2 mr-2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <button @click.prevent="store"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Добавить
                    </button>
                </div>
                <!-- Алерт об успешном добавлении нового домена -->
                <div v-if="message" class="mb-4 bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">{{ this.message.message }}</p>
                            <p class="text-sm">{{ this.message.desc }}</p>
                        </div>
                    </div>
                </div>
                <!-- Таблица с результатом пингов -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full text-left text-sm font-light">
                                        <thead class="border-b-2 border-indigo-400 font-medium">
                                        <tr>
                                            <!--<th scope="col" class="px-6 py-4">#</th>-->
                                            <th scope="col" class="px-6 py-4 text-center">Date</th>
                                            <th scope="col" class="px-6 py-4 text-center">Domain</th>
                                            <th scope="col" class="px-6 py-4 text-center">Info</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="border-b-2 border-indigo-400" v-for="data in info">
                                            <!--<td class="whitespace-nowrap px-6 py-4 font-medium">{{ data.id }}</td>-->
                                            <td class="whitespace-nowrap px-6 py-4 text-center">{{ data.time }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-center">{{ data.domain }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-center">{{ data.info }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
