<script setup>
  import dayjs from 'dayjs'
  import { ref } from 'vue'
  import { router, Link, useForm } from '@inertiajs/vue3'
  import HealthDeclarationFormView from '../Components/HealthDeclarationFormView.vue'

  import flatPickr from 'vue-flatpickr-component'
  import 'flatpickr/dist/flatpickr.css'

  const props = defineProps({
    booking: Object,
    patient: Object,
    healthDeclarationForm: Object,
    clinics: Object
  })

  const form = useForm({
    clinic: null,
    department: null
  })

  const departments = ref({})

  const approve = () => {
    form.patch(`/console/booking/${props.booking.reference_number}/approve`, {
      onSuccess: (response) => {
        console.log(response)
      }
    })

    approve_confirmation_modal.close();
  }

  const cancel = () => {
    router.patch(`/console/booking/${props.booking.reference_number}/cancel`)

    cancel_confirmation_modal.close();
  }

  const loadDepartments = () => {
    if (form.clinic) {
      axios.get(`/console/clinic/${form.clinic}/departments`)
        .then((response) => departments.value = response.data)
    }
  }
</script>

<script>
  import DashboardLayout from '../Layouts/DashboardLayout.vue';
import axios from 'axios';

  export default {
    layout: DashboardLayout
  }
</script>

<template>
  <div class="max-w-screen-xl mx-auto pt-5">

    <div class="flex justify-between mb-3">
      <div>
        <Link href="/console/dashboard" class="btn">
          <i class="fa fa-arrow-left"></i>
          View all bookings</Link>
      </div>
      <div class="flex justify-end gap-2">
        <a v-if="booking.status == 0" onclick="approve_confirmation_modal.showModal()" class="btn btn-primary">
          Approve
        </a>
        <Link v-if="booking.status != 1 && booking.status != 3" :href="`/console/booking/${booking.reference_number}/reschedule`" onclick="reschedule_booking.showModal()" class="btn btn-neutral">
          Reschedule
        </Link>
        <a v-if="booking.status == 0" onclick="cancel_confirmation_modal.showModal()" href="#" class="btn btn-warning">
          Cancel
        </a>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="table">
        <tbody>
          <tr>
            <th>Status</th>
            <td>{{ booking.status_name }}</td>
          </tr>
          <tr>
            <th>Reference Number</th>
            <td>{{ booking.reference_number }}</td>
          </tr>
          <tr>
            <th>Patient Name</th>
            <td>{{ patient.firstname }} {{ patient.middlename }} {{ patient.lastname }}</td>
          </tr>
          <tr>
            <th>Booked Date</th>
            <td>{{ dayjs(booking.booking_date).format('MMMM DD, YYYY HH:mm A') }}</td>
          </tr>
          <tr>
            <th>Booking Date</th>
            <td>{{ dayjs(booking.created_at).format('MMMM DD, YYYY HH:mm A') }}</td>
          </tr>
          <tr>
            <th>Patient's Email</th>
            <td>{{ patient.email }}</td>
          </tr>
          <tr>
            <th style="min-width: 200px;">Patient's Note</th>
            <td>{{ booking.note }}</td>
          </tr>
          <tr>
            <th>Clinic / Department</th>
            <td>{{ booking.clinic?.name }} / {{ booking.department?.name }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div>
      <!-- <div class="flex justify-end">
        <button class="btn btn-neutral">
          <i class="fa fa-print"></i>
          Print Health Declaration Form
        </button>
      </div> -->
      <div class="card shadow-lg">
        <div class="card-body px-[50px]">
          <HealthDeclarationFormView v-if="healthDeclarationForm" :form="healthDeclarationForm"  />
        </div>
      </div>
    </div>

    <dialog id="approve_confirmation_modal" class="modal">
      <div class="modal-box">
        <h3 class="font-bold text-lg">Do you want to approve {{ patient.firstname }}'s appointment?</h3>
        <div class="mb-5 mt-2">
          <label class="form-control w-full">
            <div class="label">
              <span class="label-text">Assign to Clinic</span>
            </div>
            <select class="select select-bordered" @change="loadDepartments" v-model="form.clinic">
              <option v-for="clinic in clinics" :value="clinic.id">{{ clinic.name }}</option>
            </select>
          </label>

          <label class="form-control w-full mt-4" v-if="departments.length > 0">
            <div class="label">
              <span class="label-text">Department</span>
            </div>
            <select class="select select-bordered" v-model="form.department">
              <option v-for="department in departments" :value="department.id">{{ department.name }}</option>
            </select>
          </label>
        </div>
        <div class="flex justify-center gap-2 mt-5">
          <button @click="approve" class="btn btn-primary">Approve</button>
          <form method="dialog">
            <button onclick="approve" class="btn btn-neutral">Close</button>
          </form>
        </div>
      </div>
      <form method="dialog" class="modal-backdrop">
        <button>close</button>
      </form>
    </dialog>

    <dialog id="cancel_confirmation_modal" class="modal">
      <div class="modal-box">
        <h3 class="font-bold text-lg">Are you sure you want to cancel {{ patient.firstname }}'s appointment?</h3>
        <div class="flex justify-center gap-2 mt-5">
          <button @click="cancel" class="btn btn-primary">Cancel</button>
          <form method="dialog">
            <button onclick="approve" class="btn btn-neutral">Close</button>
          </form>
        </div>
      </div>
      <form method="dialog" class="modal-backdrop">
        <button>close</button>
      </form>
    </dialog>

    <dialog id="reschedule_booking" class="modal">
      <div class="modal-box">
        <h3 class="font-bold text-lg">Reschedule {{ patient.firstname }}'s appointment</h3>
        <flat-pickr />
        <div class="flex justify-center gap-2 mt-5">
          <button @click="cancel" class="btn btn-primary">Cancel</button>
          <form method="dialog">
            <button onclick="approve" class="btn btn-neutral">Close</button>
          </form>
        </div>
      </div>
      <form method="dialog" class="modal-backdrop">
        <button>close</button>
      </form>
    </dialog>
  </div>
</template>