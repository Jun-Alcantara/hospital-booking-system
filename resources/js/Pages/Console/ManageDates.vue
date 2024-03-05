<script setup>
  import FullCalendar from '@fullcalendar/vue3'
  import dayGridPlugin from '@fullcalendar/daygrid'
  import interactionPlugin from '@fullcalendar/interaction'

  const props = defineProps({
    bookings: Object
  })

  const handleEventClick = (info) => {
    console.log(info)
  }

  const handleDayGridClick = (info) => {
    console.log(info)
  }

  console.log(props.bookings)

  const calendarOptions = {
    plugins: [ dayGridPlugin, interactionPlugin ],
    initialView: 'dayGridMonth',
    eventClick: handleEventClick,
    dateClick: handleDayGridClick,
    events: props.bookings
  }
</script>

<script>
  import DashboardLayout from '../Layouts/DashboardLayout.vue';

  export default {
    layout: DashboardLayout
  }
</script>

<template>
  <div class="max-w-screen-xl mx-auto">
    <FullCalendar :options="calendarOptions" />
  </div>
</template>

<style>
  .fc-event,
  .fc-daygrid {
    cursor: pointer !important;
  }
</style>