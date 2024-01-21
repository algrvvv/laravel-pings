<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {TailwindPagination} from 'laravel-vue-pagination';

</script>

<script>
export default {
    props: [
        "domains",
    ],

    data() {
        return {
            name: '',
            message: ''
        }
    },

    // created() {
    //     Echo.channel('new-ping')
    //         .listen('.new-ping', res => {
    //             this.info.unshift(res.info);
    //         });
    // },

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
                <div v-if="message"
                     class="mb-4 bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                     role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">{{ this.message.message }}</p>
                            <p class="text-sm">{{ this.message.desc }}</p>
                        </div>
                    </div>
                </div>
                <!-- Вывод всех доступных доменов -->
                <h1 class="my-4 font-semibold text-xl text-gray-800 leading-tight">Доступные домены:</h1>
                <div class="flex" v-if="domains">
                    <div v-for="domain in domains"
                         class="bg-white overflow-hidden shadow-sm mb-4 p-2 mr-2 rounded sm:rounded-lg">
                        <a :href="'domain/' + domain.id">{{ domain.name }}</a>
                    </div>
                </div>
                <div v-else>
                    <p>Доступных доменов нет</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
