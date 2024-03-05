<script setup>
  import { ref } from 'vue'
  import { dateModalStore, blockDateConfirmationModalStore } from '@/store/bookingCalendarStore'
  import dayjs from 'dayjs'
  import axios from 'axios'
  import { useForm } from '@inertiajs/vue3'

  const blockDateConfirmationModal = blockDateConfirmationModalStore()
  const dateModal = dateModalStore()

  const reason = ref('')

  const handleCloseClick = () => {
    blockDateConfirmationModal.close()
    dateModal.open()
  }

  const handleBlockDateClick = () => {
    const form = useForm({
      reason: reason.value,
      date: dayjs(dateModal.dateInfo?.date).format('YYYY-MM-DD')
    })

    form.post('/console/api/block-date', {
      onSuccess: () => {
        blockDateConfirmationModal.close()
      }
    })
  }
</script>

<template>
  <dialog v-if="blockDateConfirmationModal.dateInfo" class="modal" :class="{'modal-open': blockDateConfirmationModal.isOpen}">
    <div class="modal-box">
      <div class="mb-3 flex justify-between items-start">
        <div>
        </div>
        <button @click="handleCloseClick" class="">
          <i class="fa fa-times-circle"></i>
        </button>
      </div>
      <div>
        <h3 class="text-2xl text-center">
          Are you sure you want to block <br> {{ dayjs(blockDateConfirmationModal.dateInfo.date).format('MMMM DD, YYYY') }}
        </h3>
        <p class="text-center mt-3">
          Patients that have confirmed appointments on this date will receive an email notification and will be given the option to choose a new schedule
        </p>
      </div>
      <textarea v-model="reason" class="textarea textarea-bordered w-full mt-3" placeholder="Add a note why you blocked this date"></textarea>
      <div class="flex justify-center gap-3 mt-5">
        <button @click="handleCloseClick" class="btn btn-neutral">
          <i class="fa fa-times"></i> Cancel Action
        </button>
        <button @click="handleBlockDateClick" class="btn btn-primary">
          <i class="fa fa-calendar-times"></i> Bock the Date
        </button>
      </div>
    </div>
  </dialog>
</template>