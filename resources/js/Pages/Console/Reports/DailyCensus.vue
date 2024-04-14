<script setup>
  import flatPickr from 'vue-flatpickr-component'
  import { ref } from 'vue'

  const config = ref({
    wrap: true, // set wrap to true only when using 'input-group'
    altFormat: 'M j, Y',
    altInput: true,
    dateFormat: 'Y-m-d'
  });
</script>

<template>
  <div class="card w-full shadow-xl border-[1px] border-gray-100">
    <div class="card-body">
      <h2 class="card-title">Daily Census</h2>
      <p>PDF Format report of patient count</p>
      <hr class="my-3 border-[1px]" />
      <div class="flex flex-col">
        <span>Census Date:</span>
        <flat-pickr v-model="bookingDateRange" :config="config" @change="modifyDownloadURL" class="input input-bordered w-full cursor-pointer" />
      </div>
      <div class="card-actions justify-end mt-3">
        <a target="_blank" :href="downloadUrl" class="btn btn-primary">
          <i class="fa fa-download"></i> Download
        </a>
      </div>
    </div>
  </div>
</template>