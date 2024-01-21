<script>

// import {Chart} from "chart.js";
import Chart from 'chart.js/auto';
import {LineController} from "chart.js/auto";
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {

    components: {AuthenticatedLayout, Head},

    props: [
        "pings",
        "domain"
    ],

    data() {
        return {
            dataInfo: [],
            dataTime: [],
            timer: ""
        }
    },

    mounted() {
        this.update();
        this.drawChart();
    },

    created() {
        // this.update();
        // this.timer = setInterval(this.drawChart, 3000);
        Echo.channel(`new-ping-${this.domain.id}`)
            .listen('.new-ping', res => {
                console.log(res);
                this.pings.unshift(res.pings);
            });
    },

    methods: {
        update() {
            console.log("update");
            for (let i = 0; i < this.pings.length; i++) {
                let info = this.pings[i].info.replace('ms', '');
                this.dataInfo.push(parseInt(info));
                this.dataTime.push(this.pings[i].chartTime);
            }
        },

        drawChart() {
            console.log("draw");
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.dataTime.sort(),
                    datasets: [{
                        label: '# Load Time',
                        data: this.dataInfo,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }

}

</script>

<template>
    <Head :title="'Ping ' + domain.name "/>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
                <h1 class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                    Domain name: {{ domain.name }} </h1>
                <!-- График -->
                <canvas id="myChart" height="100" class="my-4"></canvas>
                <!-- Таблица с результатом пингов -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full text-left text-sm font-light">
                                        <thead class="border-b-2 border-sky-500 font-medium">
                                        <tr>
                                            <!--<th scope="col" class="px-6 py-4">#</th>-->
                                            <th scope="col" class="px-6 py-4 text-center">Date</th>
                                            <th scope="col" class="px-6 py-4 text-center">Info</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="border-b-2 border-sky-500" v-for="ping in pings">
                                            <!--<td class="whitespace-nowrap px-6 py-4 font-medium">{{ data.id }}</td>-->
                                            <td class="whitespace-nowrap px-6 py-4 text-center">{{ ping.time }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-center">{{ ping.info }}</td>
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

<style scoped>

</style>
