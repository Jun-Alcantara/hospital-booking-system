<script setup>
  import { ref, computed } from 'vue'
  import flatPickr from 'vue-flatpickr-component'
  import dayjs from 'dayjs'
  import { useForm, usePage } from '@inertiajs/vue3'

  import 'flatpickr/dist/flatpickr.css'

  const props = defineProps({
    settings: Object
  })

  const form = useForm({
    maxBookingPerDay: props.settings.max_booking_per_day,
    visitStart: props.settings.visit_start,
    visitEnd: props.settings.visit_end,
    blockDates: null
  })

  const flatPickrConfig = ref({
    minDate: dayjs().add(1, 'd').format('YYYY-MM-DD'),
    mode: "multiple",
    defaultDate: form.blockDates
  })

  const showAlert = ref(false)

  const submit = () => {
    form.patch('/console/settings', {
      onSuccess: () => {
        showAlert.value = usePage().props.flash_notifications.success
      }
    })
  }

  const visitStartTimeSlot = computed(() => {
    const start = 6, end = 18;

    const result = [];
    for (let i = start; i <= end; i++) {
      let timeSlot = i;
      let ampm = 'AM';

      if (timeSlot >= 13) {
        timeSlot = timeSlot - 12
        ampm = 'PM'
      }

      result.push({
        text: `${timeSlot}:00 ${ampm}`,
        num: i
      });
    }

    return result;
  })

  const visitEndTimeSlot = computed(() => {
    console.log(form.visitEnd)
    const start = form.visitEnd ?? 6, end = 18;

    const result = [];
    for (let i = start; i <= end; i++) {
      let timeSlot = i;
      let ampm = 'AM';

      if (timeSlot >= 13) {
        timeSlot = timeSlot - 12
        ampm = 'PM'
      }

      result.push({
        text: `${timeSlot}:00 ${ampm}`,
        num: i
      });
    }

    return result;
  })
</script>

<script>
  import DashboardLayout from '../Layouts/DashboardLayout.vue';

  export default {
    layout: DashboardLayout
  }
</script>

<template>
  <div class="max-w-screen-xl mx-auto">
    <h1 class="text-primary text-3xl">Booking Settings</h1>
    <hr class="my-5">
    
    <div v-if="showAlert" role="alert" class="alert alert-success mb-5">
      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
      <span>{{ showAlert }}</span>
    </div>

    <form @submit.prevent="submit">
      <div class="flex gap-2 mb-3">
        <div class="w-1/3">
          <label class="form-control w-full">
            <div class="label">
              <span class="label-text">Maximum bookings per day:</span>
            </div>
            <input 
              v-model="form.maxBookingPerDay"
              type="number"
              class="input input-bordered w-full"
            />
          </label>
        </div>

        <div class="w-1/3">
          <!-- <label class="form-control w-full">
            <div class="label">
              <span class="label-text">Visiting Starts At:</span>
            </div>
            <input
              v-model="form.visitStart"
              type="time"
              class="input input-bordered w-full"
              step="3600000"
            />
          </label> -->
          <label class="form-control w-full">
            <div class="label">
              <span class="label-text" :class="{'text-error': form.errors.visitStart}">Visiting Starts At:</span>
            </div>
            <select 
              v-model="form.visitStart"
              class="select select-bordered w-full"
              :class="{'input-error text-error': form.errors.visitStart}"
            >
              <option v-for="h in visitStartTimeSlot" value="{{ h.num }}">{{ h.text }}</option>
            </select>
            <div class="text-error" v-if="form.errors.visitStart">{{ form.errors.visitStart }}</div>
          </label>
        </div>

        <div class="w-1/3">
          <label class="form-control w-full">
            <div class="label">
              <span class="label-text" :class="{'text-error': form.errors.visitStart}">Visiting Starts At:</span>
            </div>
            <select 
              v-model="form.visitStart"
              class="select select-bordered w-full"
              :class="{'input-error text-error': form.errors.visitStart}"
            >
              <option v-for="h in visitEndTimeSlot" value="{{ h.num }}">{{ h.text }}</option>
            </select>
            <div class="text-error" v-if="form.errors.visitStart">{{ form.errors.visitStart }}</div>
          </label>
          <!-- <label class="form-control w-full">
            <div class="label">
              <span class="label-text">Visiting Ends At:</span>
            </div>
            <input 
              v-model="form.visitEnd"
              type="time"
              class="input input-bordered w-full"
            />
          </label> -->
        </div>
      </div>
      
      <!-- <div class="flex gap-2 mb-3">
        <div class="w-full">
          <label class="form-control w-full">
            <div class="label">
              <span class="label-text">Block Dates (disable booking):</span>
            </div>

            <flat-pickr 
              placeholder="Select date of visit"
              class="input input-bordered w-full cursor-pointer"
              :config="flatPickrConfig"
            />
          </label>
        </div>
      </div> -->

      <div class="flex justify-end">
        <button type="submit" class="btn bg-black text-white hover:bg-white hover:text-black">
          <i class="fa fa-save"></i>
          Save Settings
        </button>
      </div>
    </form>
  </div>
</template>