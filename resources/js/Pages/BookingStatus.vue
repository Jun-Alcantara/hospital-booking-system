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
      <div class="basis-1/2">
        <div>
          <h1 class="font-bold text-[4.0rem] text-white">Rosario Maclang Bautista General Hospital</h1>
          <p class="text-white">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe, repellendus aperiam. Expedita suscipit quas earum? Quo, deserunt, aperiam aspernatur voluptatum in adipisci quae quis perferendis doloremque veritatis repellendus eum impedit.
            Est aperiam modi ea tempora voluptas ipsa repellendus nemo dolorum dolor maxime facilis voluptates velit deserunt assumenda totam nulla sequi, similique fugit dolorem vitae nisi quae eaque corporis! Commodi, repudiandae?
          </p>
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
                <h2 class="card-title font-bold mb-3">Hi {{ patient.firstname }} {{ patient.lastname }}! Your booking request has been sent to Rosario Maclang Bautista General Hospital</h2>
                <p>Please note that your appointment is currently being processed. We will review your request and confirm the appointment as soon as possible.
                  <br>
                  <span class="text-error font-semibold">Once your appointment is confirmed, we will notify you via the email address you provided during the booking process.</span>
                </p>

                <div class="py-5">
                  <h3 class="text-xl font-semibold">Your booking details:</h3>
                  <!-- <p>Reference Number: {{ booking.reference_number }}</p> -->
                  <p>{{ patient.firstname }} {{ patient.middlename }} {{ patient.lastname }}</p>
                  <p>{{ patient.email }}</p>
                  <p>{{ booking.booking_date_formatted }}</p>
                  <p>Status: {{ booking.status_name }}</p>
                </div>

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