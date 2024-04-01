<script setup>
  import { router, Link, usePage } from '@inertiajs/vue3'

  const page = usePage()
  const authenticatedUser = page.props.auth.user

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
        <li>
          <Link href="/console/dashboard">
            <i class="fa fa-address-book"></i>
            Bookings
          </Link>
        </li>
        <li>
          <Link href="/console/reports">
            <i class="fa fa-file-excel"></i>
            Reports
          </Link>
        </li>
        <li>
          <Link href="/console/settings">
            <i class="fa fa-cogs"></i>
            Booking Settings
          </Link>
        </li>
        <li v-if="authenticatedUser.role_id == 1">  
          <Link href="/console/users">
            <i class="fa fa-users"></i>
            Users
          </Link>
        </li>
        <li>
          <details>
            <summary>
              <i class="fa fa-user"></i>
              My Account
            </summary>
            <ul class="p-2 bg-base-100 rounded-t-none">
              <li><Link :href="`/console/users/${authenticatedUser.id}`">Update Details</Link></li>
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