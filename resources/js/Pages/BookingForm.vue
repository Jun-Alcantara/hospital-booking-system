<script setup>
  import { ref } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  import flatPickr from 'vue-flatpickr-component'
  import 'flatpickr/dist/flatpickr.css'

  const date = ref(null);

  const config = ref({
    wrap: true, // set wrap to true only when using 'input-group'
    altFormat: 'M j, Y',
    altInput: true,
    dateFormat: 'Y-m-d',        
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
</script>

<template>
  <section class="bg-gray-100" style="background: url('/images/backgrounds/booking-form.jpg'); background-repeat: no-repeat; background-size: cover;">
    <div class="max-w-screen-xl mx-auto h-screen">
      <div class="flex flex-col md:flex-row">
        <div class="basis-1/2 flex justify-center items-center">
          <div class="py-5">
            <h1 class="font-bold text-4xl text-white text-center">Rosario Maclang Bautista General Hospital</h1>
          </div>
        </div>
        <div class="basis-1/2 flex justify-center items-center h-screen">

          <div class="card w-full bg-base-100 shadow-xl">
            <div class="card-body">
              <form @submit.prevent="submit">
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

                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text " :class="{'text-error': form.errors.email}">Email address:</span>
                  </div>

                  <input 
                    v-model="form.email"
                    type="text" 
                    placeholder="Email address" 
                    class="input input-bordered w-full"
                    :class="{'input-error text-error': form.errors.email}"
                  />
                  <div class="text-error" v-if="form.errors.email">{{ form.errors.email }}</div>
                </label>

                <div class="flex gap-2">
                  <label class="form-control w-full">
                    <div class="label">
                      <span class="label-text " :class="{'text-error': form.errors.date}">Date & Time:</span>
                    </div>

                    <flat-pickr 
                      placeholder="Select date of visit"
                      class="input input-bordered w-full cursor-pointer"
                      :class="{'input-error text-error': form.errors.date}"
                      v-model="form.date"
                      :config="config"
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
                      <option disabled selected>Select time of visit</option>
                      <option value="10">10:00 AM</option>
                      <option value="11">11:00 AM</option>
                      <option value="13">01:00 PM</option>
                      <option value="14">02:00 PM</option>
                      <option value="15">03:00 PM</option>
                      <option value="16">04:00 PM</option>
                      <option value="17">05:00 PM</option>
                      <option value="18">06:00 PM</option>
                    </select>
                    <div class="text-error" v-if="form.errors.time">{{ form.errors.time }}</div>
                  </label>
                </div>

                <label class="form-control">
                  <div class="label">
                    <span class="label-text">Note to hospital:</span>
                  </div>
                  
                  <textarea 
                    v-model="form.note"  
                    class="textarea textarea-bordered h-24"
                    placeholder="Bio"
                  ></textarea>

                </label>

                <button class="btn btn-primary mt-2">Make a Booking</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>