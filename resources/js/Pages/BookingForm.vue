<script setup>
  import { ref } from 'vue'
  import flatpickr from 'flatpickr'

  const bookingDatePicker = ref(null)
  flatpickr(bookingDatePicker)
</script>

<template>
  <section class="bg-gray-100" style="background: url('/images/backgrounds/booking-form.jpg'); background-repeat: no-repeat; background-size: cover;">
    <!-- <div class="absolute w-full h-full bg-black opacity-[0.3]"></div> -->
    <div class="max-w-screen-xl mx-auto">
      <div class="flex">
        <div class="basis-1/2 flex justify-center items-center">
          <div>
            <h1 class="font-bold text-[4rem] text-white leading-[70px] mb-4">Rosario Maclang Bautista General Hospital</h1>
            <p class="text-white text-2xl">
              #ServiceWithSmile
            </p>
          </div>
        </div>
        <div class="basis-1/2 flex justify-center items-center h-screen">

          <div class="card w-[80%] bg-base-100 shadow-xl">
            <div class="card-body">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">What is your name?</span>
                </div>
                <div class="flex gap-2">
                  <input type="text" placeholder="First Name" class="input input-bordered w-full" />
                  <input type="text" placeholder="Middle name" class="input input-bordered w-full" />
                  <input type="text" placeholder="Last name" class="input input-bordered w-full" />
                </div>
              </label>

              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Email address:</span>
                </div>
                <input type="text" placeholder="Email address..." class="input input-bordered w-full" />
              </label>

              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Date and time of visit:</span>
                </div>
                <input ref="bookingDatePicker" type="text" placeholder="Email address..." class="input input-bordered w-full" />
              </label>
              <label class="form-control">
                <div class="label">
                  <span class="label-text">Note to hospital:</span>
                </div>
                <textarea class="textarea textarea-bordered h-24"></textarea>
              </label>
              <button class="btn btn-primary mt-2">Make a Booking</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</template>