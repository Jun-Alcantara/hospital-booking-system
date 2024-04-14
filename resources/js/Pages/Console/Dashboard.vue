<script setup>
  import { ref } from 'vue'
  import { Link, usePage } from '@inertiajs/vue3'
 
  import BookingList from './Dashboard/BookingList.vue'
  import BookingCalendar from './Dashboard/BookingCalendar.vue'

  defineProps({
    bookings: Object,
    bookingToday: Number,
    pendingBookings: Number
  })

  const page = usePage()
  const authenticatedUser = page.props.auth.user

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
      <div v-if="bookingToday.length > 0 && (authenticatedUser.role_id == 3 || authenticatedUser.role_id == 1)" role="alert" class="alert alert-info basis-1/2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <a href="#" onclick="approved_bookings_modal.showModal()">You have <strong>{{ bookingToday.length }}</strong> booking today</a>
      </div>

      <div v-if="pendingBookings.length > 0" role="alert" class="alert alert-warning" 
        :class="{'!w-full': authenticatedUser.role_id == 2, 'basis-1/2': (authenticatedUser.role_id == 3 || authenticatedUser.role_id == 1)}"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <a href="#" onclick="pending_bookings_modal.showModal()"><strong>{{ pendingBookings.length }}</strong> pending bookings</a>
      </div>
    </div>

    <div class="flex justify-center mt-5">
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

    <dialog id="pending_bookings_modal" class="modal">
      <div class="modal-box">
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <div class="overflow-x-auto mt-5">
          <table class="table">
            <!-- head -->
            <thead>
              <tr>
                <th>Reference Number</th>
                <th>Name</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="booking in pendingBookings">
                <td>{{ booking.reference_number }}</td>
                <td>{{ booking.patient?.firstname }} {{ booking.patient?.lastname }}</td>
                <td>
                  <Link :href="`/console/booking/${booking.reference_number}`">
                    View
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </dialog>

    <dialog id="approved_bookings_modal" class="modal">
      <div class="modal-box">
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <div class="overflow-x-auto mt-5">
          <table class="table">
            <!-- head -->
            <thead>
              <tr>
                <th>Reference Number</th>
                <th>Name</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="booking in bookingToday">
                <td>{{ booking.reference_number }}</td>
                <td>{{ booking.patient?.firstname }} {{ booking.patient?.lastname }}</td>
                <td>
                  <Link :href="`/console/booking/${booking.reference_number}`">
                    View
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </dialog>

  </div>
</template>