 <template>
    <Head title="reservations" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-red-500 leading-tight">Reservations</h2>
            <template>
                <div>
                    <h2 style="text-align: center;">
                        Reservation Saved</h2>
                </div>
            </template>
        </template>

        <div id="reservations"  class="py-12 items-center ">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6 rounded-lg bg-white p-4 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20]">
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                    <thead>
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-red-500 uppercase dark:text-neutral-500"
                                        >
                                          Reservatioin Id
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-red-500 uppercase dark:text-neutral-500"
                                        >
                                          Reservation Date
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-red-500 uppercase dark:text-neutral-500"
                                        >
                                          Reservation Time
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-red-500 uppercase dark:text-neutral-500"
                                        >
                                          Cancel reservation
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    <tr v-if="reservations.length == 0">
                                        No reservations were found in our system.
                                    </tr>
                                    <tr v-else v-for="reservation in reservations" :key="reservation.id">
                                      <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"
                                      >
                                        {{reservation.id}}
                                      </td>
                                      <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"
                                      >
                                        {{reservation.date}}
                                      </td>
                                      <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"
                                      >
                                        {{ reservation.timeFrom}} &rarr;  {{ reservation.timeTo }}
                                      </td>
                                       <td
                                           class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-800 dark:text-neutral-200"
                                       >
                                           <button :id="reservation.id" @click="deleteReservation(reservation)">
                                               Cancel
                                           </button>

                                       </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-4">
                    <button
                        type="button"
                        class="btn text-center text-red-500 col-start-5 col-span-4 rounded-lg bg-white-500 p-4 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-red-500/[0.75] transition duration-300 hover:text-black/70 hover:ring-black/[20] focus:outline-none focus-visible:ring-[#FF2D20]"
                        @click="showModal"
                    >
                        Create Reservation
                    </button>

                    <modal
                        v-show="isModalVisible"
                        @close="closeModal"
                        @reload="getReservations"
                    />
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import modal from './CreateModal.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';


</script>
<script>

export default
{
  //props:['reservations'],
  name: 'reservations',
  components: {
      modal,
  },
  data() {
    return {
      reservations:[],
      isModalVisible: false,
    };
  },
  methods: {
    getReservations() {
        fetch('http://localhost/reservations/myreservations')
            .then(res => res.json())
            .then(data => this.reservations = data)
            .catch(err => console.log(err.message))
    },
    deleteReservation(reservation) {
        let myId  = `${reservation.id}`;
        console.log()
        axios.delete('/reservations/'+`${reservation.id}`).then(
            response => {
                console.log(response)
                this.getReservations()
            }
        ).catch(
            Error => {
                console.log(Error);
            }
        )
    },
    showModal() {
       this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    }

  },
  async created() {
    this.reservations = await this.getReservations();
  },


}
</script>

<style scoped>

</style>
