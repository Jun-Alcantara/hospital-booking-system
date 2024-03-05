<script setup>
  import dayGridPlugin from '@fullcalendar/daygrid'
  import interactionPlugin from '@fullcalendar/interaction'
  import { dateModalStore } from '@/store/bookingCalendarStore'
  
  import FullCalendar from '@fullcalendar/vue3'
  import DateInfoModal from './Components/DateInfoModal.vue'
  import BlockDateConfirmationModal from './Components/BlockDateConfirmationModal.vue'

  const props = defineProps({
    events: Object
  })

  const dateModal = dateModalStore()

  const handleEventClick = (event, info) => {
    console.log(event)
  }

  const handleDayGridClick = (info) => {
    console.log(info)
    dateModal.setDate(info)
    dateModal.open()
  }

  const calendarOptions = {
    plugins: [ dayGridPlugin, interactionPlugin ],
    initialView: 'dayGridMonth',
    eventClick: handleEventClick,
    dateClick: handleDayGridClick,
    events: props.events
  }
</script>

<script>
  import DashboardLayout from '@/Pages/Layouts/DashboardLayout.vue';

  export default {
    layout: DashboardLayout
  }
</script>

<template>
  <div class="max-w-screen-xl mx-auto">
    <FullCalendar key="dateModal.updateKey" :options="calendarOptions" />
    <DateInfoModal />
    <BlockDateConfirmationModal />
  </div>
</template>

<style>
  .fc-event,
  .fc-daygrid {
    cursor: pointer !important;
  }

  .fc-event-title {
    color: black !important
  }
</style>