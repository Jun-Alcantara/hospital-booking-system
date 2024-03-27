<script setup>
  import { Link } from '@inertiajs/vue3'
  import { ref } from 'vue'
  import dayjs from 'dayjs'
  import axios from 'axios'
  
  const props = defineProps({
    bookings: Object
  })

  const bookings = ref(props.bookings)

  const search = ref('')

  const handleSearch = () => {
    axios.get(`/api/search/booking?q=${search.value}`)
      .then((response) => {
        bookings.value = response.data
      })
  }
</script>

<template>
  <div class="py-5 flex justify-end">
    <label class="form-control w-full max-w-xs">
      <input v-model="search" @keyup="handleSearch" type="text" placeholder="Search" class="input input-bordered w-full max-w-xs" />
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
          <th>Booking Date</th>
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
          <td>{{ dayjs(booking.created_at).format('MMMM DD, YYYY hh:mm A') }}</td>
          <td>{{ booking.status_name }}</td>
          <th class="flex gap-3 justify-end">
            <Link :href="`/console/booking/${booking.reference_number}`" class="btn btn-xs btn-primary">View Details</Link>
          </th>
        </tr>
      </tbody>
    </table>
  </div>
</template>