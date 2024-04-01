<script>
  import DashboardLayout from '@/Pages/Layouts/DashboardLayout.vue';

  export default {
    layout: DashboardLayout
  }
</script>

<script setup>
  import { ref } from 'vue'
  import { useForm, Link } from '@inertiajs/vue3'

  const props = defineProps({
    users: Object
  })

  const newUserForm = useForm({
    name: null,
    email: null,
    role: null,
    defaultPassword: null
  })

  const showCreateModal = ref(false)

  const handleOpenModalClick = () => {
    showCreateModal.value = true
  }

  const handleSubmit = () => {
    newUserForm.post(`/console/users`, {
      onSuccess: (response) => {
        showCreateModal.value = false
      }
    })
  }
</script>

<template>
  <div class="max-w-screen-xl mx-auto">
    <div class="flex justify-between items-center mb-5">
      <h1 class="text-xl">All Users</h1>
      <button @click="handleOpenModalClick" class="btn btn-primary">
        <i class="fa fa-user-plus"></i> Create New User
      </button>
    </div>

    <div class="overflow-x-auto">
      <table class="table table-zebra">
        <!-- head -->
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created By</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <th>{{ user.name }}</th>
            <td>{{ user.email }}</td>
            <td>{{ user.role_id == 1 ? 'Administrator' : 'Staff' }}</td>
            <td>{{ user.created_by?.name }}</td>
            <td>{{ user.status == 1 ? 'Active' : 'Inactive' }}</td>
            <td class="text-right">
              <Link :href="`/console/users/${user.id}`" class="text-primary">
                <i class="fa fa-eye"></i> View Details
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <dialog class="modal" :class="{'modal-open': showCreateModal}">
      <div class="modal-box">
        <div class="flex flex-col mb-3">
          <span>Name:</span>
          <input type="text" class="input input-bordered" v-model="newUserForm.name">
          <span v-if="newUserForm.errors.name" class="text-error">{{ newUserForm.errors.name }}</span>
        </div>
        <div class="flex flex-col mb-3">
          <span>Email:</span>
          <input type="email" class="input input-bordered" v-model="newUserForm.email">
          <span v-if="newUserForm.errors.email" class="text-error">{{ newUserForm.errors.email }}</span>
        </div>
        <div class="flex flex-col mb-3">
          <span>Role:</span>
          <select class="select select-bordered w-full" v-model="newUserForm.role">
            <option disabled selected>Select Role</option>
            <option value="1">Administrator</option>
            <option value="2">Staff</option>
          </select>
          <span v-if="newUserForm.errors.role" class="text-error">{{ newUserForm.errors.role }}</span>
        </div>
        <div class="flex flex-col mb-3">
          <span>Default Password:</span>
          <input type="password" class="input input-bordered" v-model="newUserForm.defaultPassword">
          <span v-if="newUserForm.errors.defaultPassword" class="text-error">{{ newUserForm.errors.defaultPassword }}</span>
        </div>
        <div class="modal-action">
          <form method="dialog">
            <button @click="showCreateModal = false" class="btn mr-3">Close</button>
            <button @click="handleSubmit" class="btn btn-primary">Create New User</button>
          </form>
        </div>
      </div>
    </dialog>
  </div>
</template>