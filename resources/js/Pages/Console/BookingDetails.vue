<script setup>
  import dayjs from 'dayjs'
  import { router, Link } from '@inertiajs/vue3'
  import HealthDeclarationFormView from '../Components/HealthDeclarationFormView.vue';

  const props = defineProps({
    booking: Object,
    patient: Object,
    healthDeclarationForm: Object
  })

  const approve = () => {
    router.patch(`/console/booking/${props.booking.reference_number}/approve`)

    approve_confirmation_modal.close();
  }

  const cancel = () => {
    router.patch(`/console/booking/${props.booking.reference_number}/cancel`)

    cancel_confirmation_modal.close();
  }
</script>

<script>
  import DashboardLayout from '../Layouts/DashboardLayout.vue';

  export default {
    layout: DashboardLayout
  }
</script>

<template>
  <div class="max-w-screen-xl mx-auto pt-5">

    <div class="flex justify-between">
      <div>
        <Link href="/console/dashboard">View all bookings</Link>
      </div>
      <div class="flex justify-end gap-2">
        <a v-if="booking.status == 0" onclick="approve_confirmation_modal.showModal()" class="btn btn-primary">
          Approve
        </a>
        <a href="#" class="btn btn-neutral">
          Reschedule
        </a>
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
            <td>{{ dayjs(booking.booking_date).format('MMMM DD, YYYY HH:mm AA') }}</td>
          </tr>
          <tr>
            <th>Patient's Email</th>
            <td>{{ patient.email }}</td>
          </tr>
          <tr>
            <th style="min-width: 200px;">Patient's Note</th>
            <td>{{ booking.note }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div>
      <div class="flex justify-end">
        <button class="btn btn-neutral">
          <i class="fa fa-print"></i>
          Print Health Declaration Form
        </button>
      </div>
      <div class="card shadow-lg">
        <div class="card-body px-[50px]">
          <HealthDeclarationFormView :form="healthDeclarationForm"  />
        </div>
      </div>
    </div>

    <dialog id="approve_confirmation_modal" class="modal">
      <div class="modal-box">
        <h3 class="font-bold text-lg">Do you want to approve {{ patient.firstname }}'s appointment?</h3>
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
  </div>
</template>