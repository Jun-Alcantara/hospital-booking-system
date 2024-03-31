<script setup>
  import flatPickr from 'vue-flatpickr-component'
  import 'flatpickr/dist/flatpickr.css'

  import { ref } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  import dayjs from 'dayjs'
  import axios from 'axios'

  const props = defineProps({
    disabledDates: Object,
    blockDate: Object,
    booking: Object
  })

  const config = ref({
    wrap: true, // set wrap to true only when using 'input-group'
    altFormat: 'M j, Y',
    altInput: true,
    dateFormat: 'Y-m-d',
    disable: props.disabledDates,
    minDate: dayjs().add(1, 'd').format('YYYY-MM-DD')
  });

  const timeSlots = ref([])

  const form = useForm({
    newDate: null,
    time: null
  })

  const getTimeSlots = () => {
    axios.get(`/booking/available-time-slots?date=${form.date}`)
      .then((response) => {
        timeSlots.value = response.data
      })
  }

  const handleSubmit = () => {
    form.post(`/booking/${props.booking.reference_number}/reschedule-request`)
  }
</script>

<template>
  <section class="bg-gray-100" style="background: url('/images/backgrounds/booking-form.jpg'); background-repeat: no-repeat; background-size: cover;">
    <div class="max-w-screen-xl mx-auto h-screen flex justify-center items-center">
      <div class="basis-1/2 flex justify-center items-center">
        <div class="flex flex-col items-center justify-center">
          <figure class="w-[250px] aspect-square">
            <img :src="`/images/logo.png`" class="w-full h-full object-cover">
          </figure>
          <h1 class="font-bold text-[4.0rem] text-white text-center">HealthConnect </h1>
        </div>
      </div>
      <div class="basis-1/2">
        <div class="card w-full bg-base-100 shadow-xl">
          <div class="card-body">
            <div class="flex flex-col">
              <h1 class="text-xl">
                Your selected date of appointment has been block. Please select a new date
              </h1>
              <h3 class="mt-3 italic font-semibold">
                Reason for block the date: {{ blockDate.reason }}
              </h3>
              <div class="mt-3">
                <div class="label">
                  <span class="label-text">Select New Date:</span>
                </div>
                <flat-pickr 
                  placeholder="Select date of visit"
                  class="input input-bordered w-full cursor-pointer"
                  :class="{'input-error text-error': form.errors.newDate}"
                  v-model="form.newDate"
                  :config="config"
                  @change="getTimeSlots"
                />
              </div>
              <div>
                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text" :class="{'text-error': form.errors.time}">Select Time slot:</span>
                  </div>
                  <select 
                    v-model="form.time"
                    class="select select-bordered w-full"
                    :class="{'input-error text-error': form.errors.time}"
                  >
                    <option disabled selected>Select date</option>
                    <option
                      v-for="slot in timeSlots"
                      v-if="timeSlots.length > 0"
                      :disabled="!slot.is_available"
                      :value="slot.id"
                    >
                      {{ slot.text }} {{ !slot.is_available ? '(fully booked)' : '' }}
                    </option>
                  </select>
                  <div class="text-error" v-if="form.errors.time">{{ form.errors.time }}</div>
                </label>
              </div>
              <div class="mt-5 flex justify-end">
                <button @click="handleSubmit" class="btn btn-primary">
                  Send Reschedule Request
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
  .table {
    border-radius: 5px;
  }

  .table th,
  .table td {
    border: 1px solid gray;
  }
</style>