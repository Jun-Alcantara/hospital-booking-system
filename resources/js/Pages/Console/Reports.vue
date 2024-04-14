<script>
  import DashboardLayout from '../Layouts/DashboardLayout.vue'
  import DailyCensus from './Reports/DailyCensus.vue'

  export default {
    layout: DashboardLayout
  }
</script>
<script setup>
  import flatPickr from 'vue-flatpickr-component'
  import { ref } from 'vue'

  import 'flatpickr/dist/flatpickr.css'

  const config = ref({
    mode: 'range',
    wrap: true, // set wrap to true only when using 'input-group'
    altFormat: 'M j, Y',
    altInput: true,
    dateFormat: 'Y-m-d'
  });
  
  const downloadUrl = ref(`/console/reports/server-side/patient-database`)

  const bookingDateRange = ref(null)


  const modifyDownloadURL = () => {
    const rawDateRange = bookingDateRange.value
    if (! rawDateRange) return

    const dateRange = rawDateRange.split(' to ')

    if (undefined == dateRange[0] && undefined == dateRange[1]) return

    const start = dateRange[0],
      end = dateRange[1]

    downloadUrl.value = downloadUrl.value.split('?')[0] + `?from=${start}&to=${end}`
  }
</script>

<template>
  <div class="max-w-screen-xl mx-auto">
    <h1 class="text-3xl">Reports</h1>
    <hr class="my-5">
    <div class="flex gap-3">
      <div class="basis-1/3">
        <div class="card w-full shadow-xl border-[1px] border-gray-100">
          <div class="card-body">
            <h2 class="card-title">Patient Approved Bookings Download</h2>
            <p>An excel format of all approved bookings</p>
            <hr class="my-3 border-[1px]" />
            <div class="flex flex-col">
              <span>Booking Date Range:</span>
              <flat-pickr v-model="bookingDateRange" :config="config" @change="modifyDownloadURL" class="input input-bordered w-full cursor-pointer" />
            </div>
            <div class="card-actions justify-end mt-3">
              <a target="_blank" :href="downloadUrl" class="btn btn-primary">
                <i class="fa fa-download"></i> Download
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="basis-1/3">
        <DailyCensus />
      </div>
    </div>
  </div>
</template>

