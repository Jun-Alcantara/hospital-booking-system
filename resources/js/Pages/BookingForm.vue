<script setup>
  import { router, useForm } from '@inertiajs/vue3'

  const form = useForm({
    email: null,
    firstname: null,
    middlename: null,
    lastname: null,
    datetime: null,
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
          <form @submit.prevent="submit">

            <div class="card w-[80%] bg-base-100 shadow-xl">
              <div class="card-body">
                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text">What is your name?</span>
                  </div>
                  <div class="flex gap-2">

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

                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text">Date and time of visit:</span>
                  </div>

                  <input
                    v-model="form.datetime"
                    type="datetime-local"
                    class="input input-bordered w-full cursor-pointer"
                    :class="{'input-error text-error': form.errors.datetime}"
                    onclick="datetimepicker.showModal()"
                    readonly
                  />
                  <div class="text-error" v-if="form.errors.datetime">{{ form.errors.datetime }}</div>

                </label>
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
              </div>
            </div>
          
          </form>

          <dialog id="datetimepicker" class="modal">
            <div class="modal-box">
              <h3 class="font-bold text-lg">Hello!</h3>
              <p class="py-4">Press ESC key or click the button below to close</p>
              <div class="modal-action">
                <form method="dialog">
                  <!-- if there is a button in form, it will close the modal -->
                  <button class="btn">Close</button>
                </form>
              </div>
            </div>
          </dialog>
        </div>
      </div>
    </div>
  </section>
</template>