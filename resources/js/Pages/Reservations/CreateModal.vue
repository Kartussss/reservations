<template>
    <transition name="modal-fade">
    <div class="modal-backdrop w-full">
        <div class="modal">
            <header class="modal-header">
                <slot name="header">
                    <div class="container">
                        <div class="!flex-row">
                        Create table Reservation.

                        </div>
                        <div class="!flex-row text-gray-600">
                                We are open every day of the weeek from 10AM to 10PM.
                        </div>
                    </div>
                </slot>
                <button
                    type="button"
                    class="btn-close"
                    @click="close"
                >
                    x
                </button>
            </header>

            <section class="modal-body">
                <slot name="body">
                    <form @submit.prevent="reserveTable()" >
                        <div class="from-row form-section">
                            <div class="col-12 mb-3">
                                <label
                                    class="form-label form-label-top block mb-2 text-sm font-medium text-red-500 dark:text-white"
                                    for="date"
                                    >Date
                                    <span class="form-required"></span>
                                </label>
                                <input type="date"
                                       class="form-controll g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       v-model="reservation.date"
                                       min="2024-06-15"
                                       max="2024-08-31"
                                       @change="validateTimes()"
                                       placeholder="date">
                            </div>
                            <div class="col-12 mb-3">
                                <label
                                    class="form-label form-label-top block mb-2 text-sm font-medium text-red-500 dark:text-white"
                                    for="timeFrom"
                                >TimeFrom
                                    <span class="form-required"></span>
                                </label>
                                <input type="time"
                                       class="form-controll g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       v-model="reservation.timeFrom"
                                       min="10:00:00"
                                       max="21:00:00"
                                       @change="validateTimes()"
                                       placeholder="timeFrom">
                            </div>
                            <div class="col-12 mb-3">
                                <label
                                    class="form-label form-label-top block mb-2 text-sm font-medium text-red-500 dark:text-white"
                                    for="timeTo"
                                >TimeTo
                                    <span class="form-required"></span>
                                </label>
                                <input type="time"
                                       class="form-controll g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       v-model="reservation.timeTo"
                                       min="11:00:00"
                                       max="22:00:00"
                                       @change="validateTimes()"
                                       placeholder="timeTo">
                            </div>
                        </div>
                      <button type="submit" class=" bg-transparent enabled:hover:bg-blue-500 disabled:bg-white-300 disabled:border-gray-300 disabled:text-gray-300 text-red-500 font-semibold enabled:hover:text-white py-2 px-4 border border-red-500 enabled:hover:border-transparent rounded" :disabled="isDisabled" > Make reservation</button>
                    </form>
                </slot>
            </section>

            <footer class="modal-footer">
                <p v-if="errors.length" >
                    <b>Please correct the following error(s):</b>
                    <ul class="px-6 py-5">
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </p>
            </footer>
        </div>
    </div>
    </transition>
</template>


<script>
import moment from "moment"
export default {
    name: "CreateModal",
    data() {
        return {
            'reservation': {
                'date': null,
                'timeFrom': null,
                'timeTo': null,
            },
            errors: [],
            isDisabled: true,
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        reserveTable() {
            if (!this.errors.length)
            {
                axios.post('/reservations/create', this.reservation).then(
                    response => {
                        console.log(response)
                        this.$emit('reload')
                        this.close()
                    }
                ).catch(
                    Error => {
                        console.log(Error);
                        this.errors.push( Error.response.data[0].message)
                        this.isDisabled = true;
                    }
                )
            }

        },
        validateTimes(e) {
            this.errors = [];
            const actualTime = new Date().toLocaleTimeString();
            const actualDate = new Date().toLocaleDateString();

            if (!moment(this.reservation.date).isAfter(moment(actualDate))) {
                this.errors.push("Invalid reservation date.");
            }
            if (!moment(this.reservation.date).isAfter(moment(actualDate)) ||
                moment(this.reservation.timeFrom).isAfter(actualTime)) {
                this.errors.push("Invalid reservation timeFrom.");
            }
            if(this.reservation.timeTo) {
                if (!moment(this.reservation.date).isAfter(moment(actualDate)) ||
                    moment(this.reservation.timeTo).isAfter(actualTime)) {
                    this.errors.push("Invalid reservation timeTo.");
                }
            }else {
                this.errors.push("Invalid reservation timeTo.");
            }

            if (this.reservation.timeTo <= this.reservation.timeFrom) {
                this.errors.push("Reservation timeTo must be greater than timeFrom.");
                console.log(this.errors, moment(this.reservation.timeTo).isAfter(this.reservation.timeFrom))
            }

            if (!this.errors.length) {
                this.isDisabled = false;
                return true;
            }
        },
    },
    mounted(){
        this.validateTimes()
    },
}
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
}
.modal {
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    width: 30%;
}

.modal-header,
.modal-footer {
    padding: 15px;
    display: flex;
}

.modal-header {
    position: relative;
    border-bottom: 1px solid #eeeeee;
    color: #FF2D20;
    justify-content: space-evenly;
}

.modal-footer {
    border-top: 1px solid #eeeeee;
    flex-direction: column;
    justify-content: flex-end;
}

.modal-body {
    position: relative;
    padding: 20px 10px;
    color: #FF2D20;
}

.btn-close {
    position: absolute;
    top: 0;
    right: 20px;
    border: none;
    font-size: 30px;
    padding: 5px;
    cursor: pointer;
    font-weight: bold;
    color: black;
    background: transparent;
}

.btn-red {
    color: #FF2D20;
    background: white;
    border: 1px solid #FF2D20;
    border-radius: 2px;
}


.modal-fade-enter,
.modal-fade-leave-to {
    opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity .5s ease;
}
</style>
