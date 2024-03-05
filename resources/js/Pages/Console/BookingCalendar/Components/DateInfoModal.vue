<script setup>
  import dayjs from 'dayjs'
  import { ref, watchEffect } from 'vue'
  import { dateModalStore, blockDateConfirmationModalStore } from '@/store/bookingCalendarStore'
  import axios from 'axios'

  const dateModal = dateModalStore()
  const blockDateConfirmationModal = blockDateConfirmationModalStore()

  const isLoading = ref(true)
  const bookings = ref([])

  const getBookings = () => {
    let date = dayjs(dateModal.dateInfo.date)
    axios.get(`/console/api/bookings?date=${date.format('YYYY-MM-DD')}`)
      .then((response) => {
        bookings.value = response.data
        isLoading.value = false
      })
  }

  const handleClose = () => {
    bookings.value = []
    dateModal.close()
  }

  const handleBlockDateClick = () => {
    dateModal.close()
    blockDateConfirmationModal.setDate(dateModal.dateInfo)
    blockDateConfirmationModal.open()
  }

  watchEffect(() => {
    if (dateModal.dateInfo) {
      isLoading.value = true
      getBookings()
    }
  })

</script>

<template>
  <dialog v-if="dateModal.dateInfo" class="modal" :class="{'modal-open': dateModal.isOpen}">
    <div class="modal-box">
      <div class="mb-3 flex justify-between items-start">
        <div>
          <h1 class="text-black font-semibold text-xl">
            {{ dayjs(dateModal.dateInfo.date).format('MMMM DD, YYYY') }}
          </h1>
          <h3 class="text-black font-semibold">
            {{ dayjs(dateModal.dateInfo.date).format('dddd') }}
          </h3>
        </div>
        <button @click="handleClose" class="">
          <i class="fa fa-times-circle"></i>
        </button>
      </div>
      <hr>
      <div class="my-3">
        <div v-if="isLoading" class="w-full grid place-items-center">
          <span class="loading loading-bars loading-lg"></span>
        </div>
        <div v-else>
          <table v-if="bookings.length" class="table">
            <tbody>
              <tr v-for="booking in bookings" :key="booking.id">
                <td>
                  {{ booking.patient?.firstname }} {{ booking.patient?.lastname }}sss
                </td>
                <td>
                  <a href="`/console/booking/${booking.reference_number}`" target="_blank">
                    <i class="fa-solid fa-up-right-from-square"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-else class="text-center italic">
            No booking on this date
          </div>
        </div>
      </div>
      <hr>
      <div class="mt-3 flex justify-end">
        <button @click="handleBlockDateClick" class="text-error">
          <i class="fa fa-calendar-times"></i>
          Block This Date
        </button>
      </div>
    </div>
  </dialog>
</template>