<script setup>
  import { router } from '@inertiajs/vue3'

  const logout = () => {
    router.delete('/console/logout', {
      onSuccess: (response) => console.log(response)
    })
  }
</script>

<template>
  <div class="navbar bg-base-100 mb-5 bg-gray-200 shadow-xl">
    <div class="flex-1">
      <a class="btn btn-ghost text-xl">Booking Dashboard</a>
    </div>
    <div class="flex-none">
      <ul class="menu menu-horizontal px-1">
        <li><a>Bookings</a></li>
        <li><a>Patients</a></li>
        <li><a>Reports</a></li>
        <li>
          <details>
            <summary>
              My Account
            </summary>
            <ul class="p-2 bg-base-100 rounded-t-none">
              <li><a>Update Details</a></li>
              <li>
                <form @submit.prevent="logout">
                  <button type="submit">Logout</button>
                </form>
              </li>
            </ul>
          </details>
        </li>
      </ul>
    </div>
  </div>
  
  <slot />
</template>