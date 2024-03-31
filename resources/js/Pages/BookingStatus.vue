<script setup>
  import WaitingSvg from './svg/WaitingSvg.vue';

  defineProps({
    patient: Object,
    booking: Object
  })
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
              <div>
                <!-- <WaitingSvg class="h-[100px]" /> -->
              </div>
              <div class="grow">
                <h2 class="card-title font-bold mb-3">Appoinment Booking Received!</h2>
                <p class="mb-3">Hi {{ patient.firstname }} {{ patient.lastname }}! Your booking request has been sent to Rosario Maclang Bautista General Hospital</p>
                <p class="mb-3">Please note that your appointment is currently being processed. We will review your request and confirm the appointment as soon as possible.</p>
                <p class="text-[#C22E13] italic">Once your appointment is confirmed, we will notify you via the email address you provided during the booking process.</p>

                <table class="table my-5">
                  <tr>
                    <th colspan="2">You Booking Details</th>
                  </tr>
                  <tr>
                    <td>Patient Name:</td>
                    <td>{{ patient.firstname }} {{ patient.middlename }} {{ patient.lastname }}</td>
                  </tr>
                  <tr>
                    <td>Email:</td>
                    <td>{{ patient.email }}</td>
                  </tr>
                  <tr>
                    <td>Booked Date:</td>
                    <td>{{ booking.booking_date_formatted }}</td>
                  </tr>
                  <tr>
                    <td>Status:</td>
                    <td>
                      {{ booking.status_name }}
                    </td>
                  </tr>
                </table>

                <p>
                  If you wish to cancel, please contact us at <strong>Rosario Maclang Bautista General Hospital</strong> with your booking details.
                </p>
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