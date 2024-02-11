<script setup>
  import { Link } from '@inertiajs/vue3'
  import dayjs from 'dayjs'

  defineProps({
    bookings: Object,
    bookingToday: Number,
    pendingBookings: Number
  })
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

    <div class="py-5 flex justify-end">
      <label class="form-control w-full max-w-xs">
        <input type="text" placeholder="Search" class="input input-bordered w-full max-w-xs" />
      </label>
    </div>

    <div class="overflow-x-auto">
      <table class="table table-zebra">
        <!-- head -->
        <thead>
          <tr>
            <th>Reference Number</th>
            <th>Name</th>
            <th>Email</th>
            <th>Booked Date</th>
            <th>Status</th>
            <th class="flex gap-3 justify-end">
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="booking in bookings" :key="booking.id">
            <th>{{ booking.reference_number }}</th>
            <td>{{ booking.patient?.firstname }} {{ booking.patient?.lastname }}</td>
            <td>{{ booking.patient?.email }}</td>
            <td>{{ dayjs(booking.booking_date).format('MMMM DD, YYYY hh:mm A') }}</td>
            <td>{{ booking.status_name }}</td>
            <th class="flex gap-3 justify-end">
              <Link :href="`/console/booking/${booking.reference_number}`" class="btn btn-xs btn-primary">View Details</Link>
            </th>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="bg-back text-white p-5">

    </div>
  </div>
</template>