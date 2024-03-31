<script setup>
  import { ref } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  import { debounce } from "lodash"
  import flatPickr from 'vue-flatpickr-component'
  import dayjs from 'dayjs'
  import axios from 'axios'

  import 'flatpickr/dist/flatpickr.css'

  const props = defineProps({
    disabledDates: Array,
    settings: Object
  })

  const showOpdSchedule = ref(false)

  const config = ref({
    wrap: true, // set wrap to true only when using 'input-group'
    altFormat: 'M j, Y',
    altInput: true,
    dateFormat: 'Y-m-d',
    disable: props.disabledDates,
    minDate: dayjs().add(1, 'd').format('YYYY-MM-DD')
  });
  

  const form = useForm({
    email: null,
    firstname: null,
    middlename: null,
    lastname: null,
    date: null,
    philhealthMember: false,
    pwd: false,
    senior: false,
    time: '',
    note: ''
  })

  const submit = () => {
    form.post('/booking/submit', {
      onError: (error) => console.log(error),
      onSuccess: (response) => {
        console.log(response)
      }
    })
  }

  const timeSlots = ref({})

  const getTimeSlots = () => {
    axios.get(`/booking/available-time-slots?date=${form.date}`)
      .then((response) => {
        timeSlots.value = response.data
      })
  }

  const patientPendingBooking = ref(null)

  const handleEmailType = debounce( async (e) => {
    let email = e.target.value
    
    axios.get(`/api/patients?email=${email}`)
      .then((response) => {
        if (response.status === 200 && response.data) {
          let patient = response.data.patient
          let pendingBooking = response.data.pendingBooking

          patientPendingBooking.value = pendingBooking

          form.firstname = patient.firstname
          form.middlename = patient.middlename
          form.lastname = patient.lastname
        } else {
          form.firstname = null
          form.middlename = null
          form.lastname = null
        }
      })
  }, 300)
</script>

<template>
  <section class="bg-gray-100" style="background: url('/images/backgrounds/booking-form.jpg'); background-repeat: no-repeat; background-size: cover;">
    <div class="max-w-screen-xl mx-auto h-screen">
      <div class="flex flex-col md:flex-row">
        <div class="basis-1/2 flex justify-center items-center">
          <div class="flex flex-col items-center justify-center">
            <figure class="w-[250px] aspect-square">
              <img :src="`/images/logo.png`" class="w-full h-full object-cover">
            </figure>
            <h1 class="font-bold text-[4.0rem] text-white text-center">HealthConnect</h1>
          </div>
        </div>
        <div class="basis-1/2 flex justify-center items-center h-screen">

          <div class="card w-full bg-base-100 shadow-xl">
            <div class="card-body">

              <div  v-if="patientPendingBooking" class="alert alert-warning">
                <i class="fa fa-exclamation-triangle"></i>
                <span>You still have pending bookings. Click <a :href="`/booking/status/${patientPendingBooking.reference_number}`" class="underline">here</a> to view details.</span>
              </div>

              <form @submit.prevent="submit">

                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text " :class="{'text-error': form.errors.email}">Email address:</span>
                  </div>

                  <input 
                    v-model="form.email"
                    @input="handleEmailType"
                    type="text" 
                    placeholder="Email address" 
                    class="input input-bordered w-full"
                    :class="{'input-error text-error': form.errors.email}"
                  />
                  <div class="text-error" v-if="form.errors.email">{{ form.errors.email }}</div>
                </label>

                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text">What is your name?</span>
                  </div>
                  <div class="flex flex-col lg:flex-row gap-2">

                    <input 
                      v-model="form.firstname"
                      type="text" 
                      placeholder="First Name" 
                      class="input input-bordered w-full"
                      :class="{'input-error text-error': form.errors.firstname}"
                    />

                    <input 
                      v-model="form.middlename"
                      type="text" 
                      placeholder="Middle name" 
                      class="input input-bordered w-full"
                    />

                    <input 
                      v-model="form.lastname"
                      type="text" 
                      placeholder="Last name" 
                      class="input input-bordered w-full"
                      :class="{'input-error text-error': form.errors.lastname}"
                    />

                  </div>
                  <div class="text-error" v-if="form.errors.firstname">{{ form.errors.firstname }}</div>
                  <div class="text-error" v-if="form.errors.firstname">{{ form.errors.lastname }}</div>
                </label>

                <div class="flex gap-2">
                  <label class="form-control w-full">
                    <div class="label">
                      <span class="label-text " :class="{'text-error': form.errors.date}">Date:</span>
                    </div>

                    <flat-pickr 
                      placeholder="Select date of visit"
                      class="input input-bordered w-full cursor-pointer"
                      :class="{'input-error text-error': form.errors.date}"
                      v-model="form.date"
                      :config="config"
                      @change="getTimeSlots"
                    />
                    <div class="text-error" v-if="form.errors.date">{{ form.errors.date }}</div>
                  </label>

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

                <hr class="my-3">

                <div class="form-control my-3 flex flex-row">
                  <div class="basis-1/2">
                    <label>Are you a PhilHealth member?</label>
                    <div class="flex gap-7 mt-2">
                      <div class="flex items-center">
                        <input type="radio" name="radio-2" class="radio radio-primary" value="true" v-model="form.philhealthMember" /> &nbsp; Yes
                      </div>
                      <div class="flex items-center">
                        <input type="radio" name="radio-2" class="radio radio-primary" value="false" v-model="form.philhealthMember" /> &nbsp; No
                      </div>
                    </div>
                  </div>
                  <div class="basis-1/2 flex flex-col gap-3 justify-center">
                    <div class="flex items-center">
                      <input type="checkbox" v-model="form.pwd" class="checkbox" /> &nbsp; I'm a PWD (Person with Disabilities)
                    </div>
                    <div class="flex items-center">
                      <input type="checkbox" v-model="form.senior" class="checkbox" /> &nbsp; I'm a Senior Citizen
                    </div>
                  </div>
                </div>

                <hr class="mt-3 mb-1">

                <label class="form-control">
                  <div class="label">
                    <span class="label-text">Purpose of visit:</span>
                  </div>
                  
                  <textarea 
                    v-model="form.note"  
                    class="textarea textarea-bordered h-24"
                    placeholder="Symptoms/Previous checkup result/Name of Doctor"
                  ></textarea>

                </label>

                <span class="italic text-gray-500">
                  The patient needs to arrive one hour before their scheduled appointment.
                </span>

                <div class="flex gap-3">
                  <button :disabled="patientPendingBooking" class="btn btn-primary mt-3">Make a Booking</button>
                  <button 
                    v-if="settings.opd_schedule_img"
                    class="btn btn-primary mt-3"
                    @click.prevent="showOpdSchedule = true"
                  >View OPD Schedule</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <dialog class="modal" :class="{'modal-open': showOpdSchedule}">
      <div class="modal-box w-11/12 max-w-5xl">
        <div class="mb-3 flex justify-between items-center">
          <h1 class="text-xl font-semibold">
            OPD Schedule as of {{ dayjs().format("MMMM DD, YYYY") }}
          </h1>
          <button class="btn bg-green-800 text-white" @click="showOpdSchedule = false">
            <i class="fa fa-times"></i>
            Close
          </button>
        </div>
        <figure>
          <img :src="`/storage/${settings.opd_schedule_img}`" class="w-full h-full object-cover">
        </figure>
      </div>
    </dialog>
  </section>
</template>