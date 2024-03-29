<script setup>
  import { ref } from 'vue'

  import BookingList from './Dashboard/BookingList.vue'
  import BookingCalendar from './Dashboard/BookingCalendar.vue'

  defineProps({
    bookings: Object,
    bookingToday: Number,
    pendingBookings: Number
  })

  const activeTab = ref(2)
  
  const handleTabClick = (tabIndex) => {
    activeTab.value = tabIndex
  }
</script>

<script>
  import DashboardLayout from '../Layouts/DashboardLayout.vue'

  export default {
    layout: DashboardLayout
  }
</script>

<template>
  <div class="max-w-screen-xl mx-auto pt-5">
    <div class="flex gap-2">
      <div v-if="bookingToday > 0" role="alert" class="alert alert-info basis-1/2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>You have <strong>{{ bookingToday }}</strong> booking today</span>
      </div>

      <div v-if="bookingToday > 0" role="alert" class="alert alert-warning basis-1/2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span><strong>{{ pendingBookings }}</strong> pending bookings</span>
      </div>
    </div>

    <div class="flex justify-center">
      <div role="tablist" class="tabs tabs-boxed">
        <a @click="handleTabClick(2)" role="tab" class="tab" :class="{'tab-active': activeTab == 2}">
          <i class="fa fa-file"></i> &nbsp; Booking List
        </a>
        <a @click="handleTabClick(1)" role="tab" class="tab" :class="{'tab-active': activeTab == 1}">
          <i class="fa fa-calendar"></i> &nbsp; Booking Calendar
        </a>
      </div>
    </div>

    <BookingCalendar v-if="activeTab == 1" />
    <BookingList v-if="activeTab == 2" :bookings="bookings" />

  </div>
</template>