<script>
  import DashboardLayout from '../Layouts/DashboardLayout.vue';

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

