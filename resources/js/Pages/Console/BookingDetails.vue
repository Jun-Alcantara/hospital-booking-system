<script setup>
  import dayjs from 'dayjs'
  import { ref } from 'vue'
  import { router, Link, useForm, usePage } from '@inertiajs/vue3'
  import HealthDeclarationFormView from '../Components/HealthDeclarationFormView.vue'

  import flatPickr from 'vue-flatpickr-component'
  import 'flatpickr/dist/flatpickr.css'

  const props = defineProps({
    booking: Object,
    patient: Object,
    healthDeclarationForm: Object,
    clinics: Object,
    clinicDepartmentApprovedBookings: Number
  })

  const page = usePage()
  const authenticatedUser = page.props.auth.user;

  const departments = ref([])

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

  const form = useForm({
    clinic: null,
    department: null
  })

  const forwardToClinicDepartment = () => {
    form.patch(`/console/booking/${props.booking.reference_number}/assign`)
  }

  const returnToTriage = () => {
    form.patch(`/console/booking/${props.booking.reference_number}/return-to-triage`)
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
    </div>

    <div class="flex gap-3">
      <div class="card border-[1px] border-gray-100 shadow-md basis-2/3">
        <div class="card-body">
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
                <tr>
                  <th>Number of Approved Booking in this Clinic / Department</th>
                  <td>{{ clinicDepartmentApprovedBookings }}</td>
                </tr>
                <tr v-if="booking.assigned_by">
                  <th>Assigned By</th>
                  <td>{{ booking.assigned_by?.name }}</td>
                </tr>
                <tr v-if="booking.approver">
                  <th>Approved By</th>
                  <td>{{ booking.approver?.name }}</td>
                </tr>
                <tr v-if="booking.cancelled_by">
                  <th>Cancelled By</th>
                  <td>{{ booking.cancelled_by?.name }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card border-[1px] border-gray-100 shadow-md basis-1/3">
        <div class="card-body">
          <div v-if="authenticatedUser.role_id == 2">
            <div v-if="booking.status == 0" id="clinic_department_assessent_form">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Clinic</span>
                </div>
                <select 
                  class="select select-bordered" 
                  :class="{'select-error': form.errors.clinic}"
                  @change="loadDepartments" 
                  v-model="form.clinic"
                >
                  <option v-for="clinic in clinics" :value="clinic.id">{{ clinic.name }}</option>
                </select>
                <span v-if="form.errors.clinic" class="text-error">{{ form.errors.clinic }}</span>
              </label>

              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Department</span>
                </div>
                <select 
                  class="select select-bordered" 
                  :class="{'select-error': form.errors.department}"
                  v-model="form.department"
                >
                  <option value="null"  v-if="departments.length <= 0">--</option>
                  <option v-for="department in departments" :value="department.id">{{ department.name }}</option>
                </select>
                <span v-if="form.errors.department" class="text-error">{{ form.errors.department }}</span>
              </label>

              <div class="form-control mt-3">
                <button 
                  @click="forwardToClinicDepartment" 
                  class="btn btn-primary"
                  :disabled="form.processing"
                >
                  Forward Booking to Clinic / Department
                </button>
              </div>
            </div>
            <div v-else-if="booking.status == 2">
              <h1 class="italic text-center">
                This booking has been sent to Admission Coordinator and waiting for approval. 
              </h1>
            </div>
            <div v-else-if="booking.status == 3">
              <h1 class="italic text-center">
                This booking has been cancelled by {{ booking.cancelled_by?.name }}
              </h1>
            </div>
          </div>

          <!-- ADMISSION OR ADMIN -->
          <div v-if="authenticatedUser.role_id == 1 || authenticatedUser.role_id == 3">
            <div v-if="booking.status == 2" id="clinic_department_accept_form">
              <div class="form-control">
                <button @click="approve" class="btn btn-primary">
                  <i class="fa fa-check-circle"></i>
                  Accept Booking
                </button>
                <a :href="`/console/booking/${booking.reference_number}/reschedule`" class="btn btn-neutral mt-3">
                  <i class="fa fa-calendar"></i>
                  Reschedule Booking
                </a>
                <button onclick="cancel_confirmation_modal.showModal()" class="btn btn-warning mt-3">
                  <i class="fa fa-calendar-times"></i>
                  Cancel
                </button>
                <button onclick="return_triage_modal.showModal()" class="btn neutral mt-3">
                  <i class="fa fa-arrow-left"></i>
                  Return to Triage
                </button>
              </div>
            </div>
            <div v-else-if="booking.status == 3">
              <h1 class="italic text-center">
                This booking has been cancelled by {{ booking.cancelled_by?.name }}
              </h1>
            </div>
            <div v-else-if="booking.status == 1">
              <h1 class="italic text-center">
                This booking has been approved by {{ booking.approver?.name }}
              </h1>
            </div>
          </div>

          <!-- <h1 v-else class="italic text-center">No actions required</h1> -->
        </div>
      </div>
    </div>

    <div class="mt-5">
      <div class="flex justify-end">
        <a target="_blank" :href="`/console/reports/client-side/printable/health-declaration/${booking.reference_number}`" class="btn btn-neutral">
          <i class="fa fa-print"></i>
          Print Health Declaration Form
        </a>
      </div>
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
          <button @click="cancel" class="btn btn-primary basis-1/2">Cancel</button>
          <form method="dialog" class="basis-1/2">
            <button onclick="approve" class="btn btn-neutral w-full">Close</button>
          </form>
        </div>
      </div>
      <form method="dialog" class="modal-backdrop">
        <button>close</button>
      </form>
    </dialog>

    <dialog id="return_triage_modal" class="modal">
      <div class="modal-box">
        <h3 class="font-bold text-lg">Are you sure you want to return {{ patient.firstname }}'s appointment to triage stage?</h3>
        <hr class="my-3">
        <p>This will allow triage officer to select new clinic and department for the patient</p>
        <div class="flex justify-center gap-2 mt-5">
          <button @click="returnToTriage" class="btn btn-primary basis-1/2">Forward back to Triage</button>
          <form method="dialog" class="basis-1/2">
            <button class="btn btn-neutral w-full">Close</button>
          </form>
        </div>
      </div>
      <form method="dialog" class="modal-backdrop">
        <button>close</button>
      </form>
    </dialog>
  </div>
</template>