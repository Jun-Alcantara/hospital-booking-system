<script setup>
  import FullCalendar from '@fullcalendar/vue3'
  import dayGridPlugin from '@fullcalendar/daygrid'
  import interactionPlugin from '@fullcalendar/interaction'

  import { onMounted, watchEffect, ref } from 'vue'
  import { dateModalStore } from '@/store/bookingCalendarStore'
  import axios from 'axios'

  import DateInfoModal from './DateInfoModal.vue'
  import BlockDateConfirmationModal from '@/Pages/Console/BookingCalendar/Components/BlockDateConfirmationModal.vue'

  const dateModal = dateModalStore()

  const handleDayGridClick = (info) => {
    console.log(info)
    dateModal.setDate(info)
    dateModal.open()
  }

  const handleEventClick = (info) => {
    console.log(info.event)
  }

  const events = ref([])

  onMounted(() => {
    axios.get(`/console/api/full-calendar/events`)
      .then((response) => {
        console.log(response)
        events.value = response.data
      })
    
    console.log('Events fetched')
    console.log(events)
  })

  const calendarOptions = ref({
    plugins: [ dayGridPlugin, interactionPlugin ],
    initialView: 'dayGridMonth',
    eventClick: handleEventClick,
    dateClick: handleDayGridClick,
    events: events
  })

  watchEffect(() => {
    calendarOptions.value.events = events
  })
</script>

<template>
  <FullCalendar :options="calendarOptions" />
  <DateInfoModal />
  <BlockDateConfirmationModal />
</template>

<style>
  .blocked-date {
    background-color: #fb4d4d !important;
  }

  .blocked-date > .fc-event-title {
    color: white !important;
  }
</style>