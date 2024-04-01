<script>
  import DashboardLayout from '@/Pages/Layouts/DashboardLayout.vue';

  export default {
    layout: DashboardLayout
  }
</script>

<script setup>
  import { useForm, Link } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"

  const toast = useToast()

  const props = defineProps({
    user: Object
  })

  const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role_id,
    status: props.user.status,
    newPassword: '',
    newPassword_confirmation: ''
  })

  const handleSubmit = () => {
    form.patch(`/console/users/${props.user.id}`, {
      onSuccess: () => {
        toast("User details updated!")
      }
    })
  }
</script>

<template>
  <div class="max-w-screen-xl mx-auto">
    <div class="card bg-base-100 shadow-xl border-[1px]">
      <div class="card-body">
        <form autocomplete="off">
          <div class="flex flex-col mb-3">
            <span>Name:</span>
            <input v-model="form.name" type="text" class="input input-bordered">
            <span v-if="form.errors.name" class="text-error">{{ form.errors.name }}</span>
          </div>
          <div class="flex flex-col mb-3">
            <span>Email:</span>
            <input v-model="form.email" type="text" class="input input-bordered">
            <span v-if="form.errors.email" class="text-error">{{ form.errors.email }}</span>
          </div>
          <div class="flex flex-col mb-3">
            <span>Role:</span>
            <select class="select select-bordered w-full" v-model="form.role">
              <option disabled selected>Select Role</option>
              <option value="1">Administrator</option>
              <option value="2">Staff</option>
            </select>
            <span v-if="form.errors.role" class="text-error">{{ form.errors.role }}</span>
          </div>
          <div class="flex flex-col mb-3">
            <span>Status:</span>
            <select class="select select-bordered w-full" v-model="form.status">
              <option disabled selected>Select Status</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
            <span v-if="form.errors.status" class="text-error">{{ form.errors.status }}</span>
          </div>
          
          <hr class="my-3">

          <div role="alert" class="alert alert-warning">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            <span>Leave this fields blank if you don't want to change the password.</span>
          </div>
          <div class="flex flex-col mb-3">
            <span>New Password:</span>
            <input v-model="form.newPassword" type="password" name="asjmncklsdkm32sd239uasdnakj9823rjsakjnasdfh" class="input input-bordered" autocomplete="new-password">
            <span v-if="form.errors.newPassword" class="text-error">{{ form.errors.newPassword }}</span>
          </div>
          <div class="flex flex-col mb-3">
            <span>Confirm New Password:</span>
            <input v-model="form.newPassword_confirmation" type="password" class="input input-bordered">
          </div>
          <div class="flex justify-end gap-3">
            <Link :href="`/console/users`" class="btn btn-default">
              Discard Changes
            </Link>
            <button @click.prevent="handleSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>