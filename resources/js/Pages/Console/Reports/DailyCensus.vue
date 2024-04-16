<script setup>
  import flatPickr from 'vue-flatpickr-component'
  import { ref, onMounted } from 'vue'
  import axios from 'axios'

  const config = ref({
    wrap: true, // set wrap to true only when using 'input-group'
    altFormat: 'M j, Y',
    altInput: true,
    dateFormat: 'Y-m-d'
  });

  const clinics = ref([])
  const departments = ref([])

  onMounted(() => {
    axios.get(`/console/clinics`).then((response) => {
      clinics.value = response.data
    })
  })

  const censusDate = ref(null)
  const clinic = ref(null)
  const department = ref(null)

  const downloadUrl = ref(`/console/reports/server-side/daily-census?clinic=3&department=11&date=2024-04-24`)

  const modifyDownloadURL = () => {
    censusDate.value = censusDate
    console.log({
      censusDate: censusDate.value,
      clinic: clinic.value,
      department: department.value,
    })
  }
</script>

<template>
  <div class="card w-full shadow-xl border-[1px] border-gray-100">
    <div class="card-body">
      <h2 class="card-title">Daily Census</h2>
      <p>PDF Format report of patient count</p>
      <hr class="my-3 border-[1px]" />
      <div class="flex flex-col">
        <span>Clinic:</span>
        <select v-model="clinic" @change="modifyDownloadURL" class="select select-bordered w-full">
          <option value=""></option>
          <option v-for="clinic in clinics">{{ clinic.name }}</option>
        </select>
      </div>
      <div class="flex flex-col">
        <span>Department:</span>
        <select v-model="department" @change="modifyDownloadURL" class="select select-bordered w-full">
          <option value=""></option>
          <option v-for="department in departments">{{ department.name }}</option>
        </select>
      </div>
      <div class="flex flex-col">
        <span>Census Date:</span>
        <flat-pickr v-model="censusDate" :config="config" @change="modifyDownloadURL" class="input input-bordered w-full cursor-pointer" />
      </div>
      <div class="card-actions justify-end mt-3">
        <a target="_blank" :href="downloadUrl" class="btn btn-primary">
          <i class="fa fa-download"></i> Download
        </a>
      </div>
    </div>
  </div>
</template>