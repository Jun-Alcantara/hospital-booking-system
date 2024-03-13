<script setup>
  import { ref } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  import { debounce } from "lodash"
  import flatPickr from 'vue-flatpickr-component'
  import dayjs from 'dayjs'
  import axios from 'axios'

  import 'flatpickr/dist/flatpickr.css'

  const props = defineProps({
    disabledDates: Array
  })

  console.log(Object.values(props.disabledDates))

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

  const handleEmailType = debounce( async (e) => {
    let email = e.target.value
    
    axios.get(`/api/patients?email=${email}`)
      .then((response) => {
        if (response.status === 200 && response.data) {
          let patient = response.data

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

                <label class="form-control">
                  <div class="label">
                    <span class="label-text">Purpose Of Visit:</span>
                  </div>
                  
                  <textarea 
                    v-model="form.note"  
                    class="textarea textarea-bordered h-24"
                    placeholder="My symptoms are ..."
                  ></textarea>

                </label>

                <button class="btn btn-primary mt-3">Make a Booking</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>