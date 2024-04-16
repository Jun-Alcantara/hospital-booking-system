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
      console.log(response.data)
    })
  })

  const censusDate = ref(null)
  const clinic = ref(null)
  const department = ref(null)

  const getClinics = () => {
    axios.get(`/console/clinic/${clinic.value}/departments`).then((response) => {
      departments.value = response.data
    })

    modifyDownloadURL()
  }

  const downloadUrl = ref(`/console/reports/server-side/daily-census?clinic=${clinic.value}&department=${department.value}&date=${censusDate.value}`)

  const modifyDownloadURL = () => {
    downloadUrl.value = `/console/reports/server-side/daily-census?clinic=${clinic.value}&department=${department.value}&date=${censusDate.value}`
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
        <select v-model="clinic" @change="getClinics" class="select select-bordered w-full">
          <option value=""></option>
          <option v-for="clinic in clinics" :value="clinic.id">{{ clinic.name }}</option>
        </select>
      </div>
      <div class="flex flex-col">
        <span>Department:</span>
        <select v-model="department" @change="modifyDownloadURL" class="select select-bordered w-full">
          <option value=""></option>
          <option v-for="department in departments" :value="department.id">{{ department.name }}</option>
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