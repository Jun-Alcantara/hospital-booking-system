<script>
  import DashboardLayout from '../Layouts/DashboardLayout.vue';

  export default {
    layout: DashboardLayout
  }
</script>

<script setup>
  import dayjs from 'dayjs'
  import axios from 'axios'
  import { useForm, Link } from '@inertiajs/vue3'
  import { ref } from 'vue'
  import flatPickr from 'vue-flatpickr-component'
  import 'flatpickr/dist/flatpickr.css'

  const props = defineProps({
    booking: Object,
    patient: Object,
    disabledDates: Array,
    clinics: Object
  })

  const form = useForm({
    clinic: null,
    department: null,
    newDate: null,
    rescheduleRemarks: null
  })

  const departments = ref([])

  const newBookingDateConfig = {
    disable: props.disabledDates,
    minDate: dayjs().add(1, 'd').format('YYYY-MM-DD')
  }

  const loadDepartments = () => {
    if (form.clinic) {
      axios.get(`/console/clinic/${form.clinic}/departments`)
        .then((response) => departments.value = response.data)
    }
  }

  const handleClinicChange = () => {
    form.department = null
    loadDepartments()
  }

  const handleSubmit = () => {
    form.post(`/console/booking/${props.booking.reference_number}/reschedule`)
  }
</script>

<template>
  <div class="max-w-screen-xl mx-auto">
    <Link :href="`/console/booking/${booking.reference_number}`">
      <i class="fa fa-arrow-left"></i> Booking Details
    </Link>
    <h1 class="text-2xl">Reschedule Form</h1>
    <div class="flex mt-3 gap-5">
      <div class="basis-1/2">
        <div class="card w-full bg-base-100 shadow-xl border-[1px]">
          <div class="card-body">
            <h1 class="text-xl">
              Original Booking
            </h1>
            <table id="details" class="mt-3">
              <tr>
                <th class="text-left">Status</th>
                <td>{{ booking.status_name }}</td>
              </tr>
              <tr>
                <th class="text-left">Reference Number</th>
                <td>{{ booking.reference_number }}</td>
              </tr>
              <tr>
                <th class="text-left">Patient Name</th>
                <td>{{ patient.firstname }} {{ patient.middlename }} {{ patient.lastname }}</td>
              </tr>
              <tr>
                <th class="text-left">
                  Booked Date
                </th>
                <td>
                  {{ dayjs(booking.booking_date).format('MMM DD, YYYY') }}
                </td>
              </tr>
              <tr>
                <th class="text-left">Booking Date</th>
                <td>{{ dayjs(booking.created_at).format('MMMM DD, YYYY HH:mm A') }}</td>
              </tr>
              <tr>
                <th class="text-left">Patient's Email</th>
                <td>{{ patient.email }}</td>
              </tr>
              <tr>
                <th class="text-left" style="min-width: 200px;">Patient's Note</th>
                <td>{{ booking.note }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="basis-1/2">
        <div class="card w-full bg-base-100 shadow-xl border-[1px]">
          <div class="card-body">
            <h1 class="text-xl">
              New Booking Schedule
            </h1>
            <table class="">
              <tr>
                <td colspan="2">
                  <label class="form-control w-full">
                    <div class="label">
                      <span class="label-text" :class="{'text-error' : form.errors.clinic}">Clinic</span>
                    </div>
                    <select v-model="form.clinic" @change="handleClinicChange" class="select select-bordered" :class="{'select-error' : form.errors.clinic}">
                      <option disabled selected>Pick one</option>
                      <option v-for="clinic in clinics" :value="clinic.id">{{ clinic.name }}</option>
                    </select>
                    <span v-if="form.errors.clinic" class="text-error">{{ form.errors.clinic }}</span>
                  </label>
                </td>
              </tr>
              <tr v-if="form.clinic">
                <td colspan="2">
                  <label class="form-control w-full">
                    <div class="label">
                      <span class="label-text" :class="{'text-error' : form.errors.department}">Department</span>
                    </div>
                    <select v-model="form.department" class="select select-bordered" :class="{'select-error' : form.errors.department}">
                      <option :value="null" disabled selected>Pick one</option>
                      <option v-for="department in departments" :value="department.id">{{ department.name }}</option>
                    </select>
                    <span v-if="form.errors.department" class="text-error">{{ form.errors.department }}</span>
                  </label>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="text-left">
                  <div class="label">
                    <span class="label-text" :class="{'text-error': form.errors.newDate}">New Appointment Date</span>
                  </div>
                  <flatPickr v-model="form.newDate" :modelValue="form.newDate" :config="newBookingDateConfig" class="input input-bordered w-full" :class="{'input-error': form.errors.newDate}" />
                  <span v-if="form.errors.newDate" class="text-error">{{ form.errors.newDate }}</span>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="">
                  <div class="label">
                    <span class="label-text">Reschedule Remarks</span>
                  </div>
                  <textarea v-model="form.rescheduleRemarks" class="textarea textarea-bordered w-full"></textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="flex flex-col gap-3 justify-end">
                  <div role="alert" class="alert alert-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Once rescheduled, this booking will be automatically approved and the patient will be notified.</span>
                  </div>
                  <button @click.prevent="handleSubmit" class="btn btn-primary">
                    Reschedule Booking
                  </button>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
  table#details th, 
  table#details td {
    border-top: 1px solid lightgray;
    /* border-bottom: 1px solid lightgray; */
    padding: 10px 0px;
  }
</style>