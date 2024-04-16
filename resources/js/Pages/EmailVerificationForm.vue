<script setup>
  import { ref } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  import axios from 'axios'

  const props = defineProps({
    patient: Object,
    booking: Object
  })  

  const otp = ref(null)
  const otpInvalid = ref(false)

  const form = useForm({
    otp: null
  })


  const handleVerify = () => {
    form.post(`/booking/${props.booking.reference_number}/verify-email`)
  }
</script>

<template>
  <section class="bg-gray-100" style="background: url('/images/backgrounds/booking-form.jpg'); background-repeat: no-repeat; background-size: cover;">
    <div class="max-w-screen-xl mx-auto h-screen flex flex-col justify-center items-center">
      <div>
        <div class="card w-1/2 mx-auto bg-base-100 shadow-xl">
          <div class="card-body">
            <div class="flex flex-col">
              <h1 class="font-semibold text-3xl text-center">Verify Your Email</h1>
              <p class="text-center">
                We've sent a 6-digit verification code to <strong>{{ patient.email }}</strong>. Please check your email inbox or spam folder.
              </p>
              <input v-model="form.otp" type="text" class="input input-bordered text-center mt-5">
              <span v-if="form.errors.otp" class="text-error">Incorrect OTP</span>
              <button @click="handleVerify" class="btn btn-primary mt-3">
                Verify Email
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>