<script setup>
  import { Link, usePage } from '@inertiajs/vue3'
  import { ref } from 'vue'
  import dayjs from 'dayjs'
  import axios from 'axios'
  
  const props = defineProps({
    bookings: Object
  })

  const page = usePage()
  const authenticatedUser = page.props.auth.user

  const bookings = ref(props.bookings)

  const search = ref('')
  const statusFilter = ref('all')

  const handleSearch = () => {
    axios.get(`/api/search/booking?q=${search.value}&status=${statusFilter.value}`)
      .then((response) => {
        bookings.value = response.data
      })
  }

  const handleStatusFilterChange = () => {
    handleSearch()
  }
</script>

<template>
  <div class="py-5 flex justify-end gap-3">
    <select 
      v-if="authenticatedUser.role_id == 1"
      @change="handleStatusFilterChange" 
      v-model="statusFilter" 
      class="select select-bordered w-full max-w-xs"
    >
      <option disabled selected>Select Status</option>
      <option value="all">All</option>
      <option value="0">For Assessment</option>
      <option value="4">For Approval</option>
      <option value="1">Approved</option>
      <option value="3">Cancelled</option>
    </select>
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
          <th>Email Verified</th>
          <th>Booked Date</th>
          <th>Booking Date</th>
          <th>Clinic / Department</th>
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
          <td>{{ booking.patient?.email_verified_at ? 'Yes' : 'No' }}</td>
          <td>{{ dayjs(booking.booking_date).format('MMMM DD, YYYY hh:mm A') }}</td>
          <td>{{ dayjs(booking.created_at).format('MMMM DD, YYYY hh:mm A') }}</td>
          <td>{{ booking.clinic?.name }} / {{ booking.department?.name }}</td>
          <td>{{ booking.status_name }}</td>
          <th class="flex gap-3 justify-end">
            <Link :href="`/console/booking/${booking.reference_number}`" class="btn btn-xs btn-primary">View Details</Link>
          </th>
        </tr>
      </tbody>
    </table>
  </div>
</template>