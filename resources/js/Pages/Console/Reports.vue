<script>
  import DashboardLayout from '../Layouts/DashboardLayout.vue'
  import flatPickr from 'vue-flatpickr-component'

  import 'flatpickr/dist/flatpickr.css'

  const config = ref({
    wrap: true, // set wrap to true only when using 'input-group'
    altFormat: 'M j, Y',
    altInput: true,
    dateFormat: 'Y-m-d'
  });
  

  export default {
    layout: DashboardLayout
  }
</script>
<script setup></script>

<template>
  <div class="max-w-screen-xl mx-auto">
    <h1 class="text-3xl">Reports</h1>
    <hr class="my-5">
    <div class="flex">
      <div class="basis-1/4">
        <div class="card w-full shadow-xl border-[1px] border-gray-100">
          <div class="card-body">
            <h2 class="card-title">Patient Approved Bookings Download</h2>
            <p>An excel format of all approved bookings</p>
            <hr class="my-3 border-[1px]" />
            <flatpickr :config="config" class="input input-bordered" />
            <div class="card-actions justify-end">
              <a target="_blank" href="/console/reports/server-side/patient-database" class="btn btn-primary">
                <i class="fa fa-download"></i> Download
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

