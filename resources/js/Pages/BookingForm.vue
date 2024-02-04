<script setup>
</script>

<template>
  <section class="bg-gray-100" style="background: url('/images/backgrounds/booking-form.jpg'); background-repeat: no-repeat; background-size: cover;">
    <div class="max-w-screen-xl mx-auto">
      <div class="flex">
        <div class="basis-1/2 flex justify-center items-center">
          <div>
            <h1 class="font-bold text-4xl">The Name of the Hospital Here</h1>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam delectus expedita alias sit saepe quos voluptas, 
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
                <input type="datetime-local" placeholder="Email address..." class="input input-bordered w-full" />
              </label>
              <label class="form-control">
                <div class="label">
                  <span class="label-text">Note to hospital:</span>
                </div>
                <textarea class="textarea textarea-bordered h-24" placeholder="Bio"></textarea>
              </label>
              <button class="btn btn-primary mt-2">Make a Booking</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</template>