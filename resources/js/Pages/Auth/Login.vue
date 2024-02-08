<script setup>
  import { useForm } from '@inertiajs/vue3'

  const loginForm = useForm({
    email: null,
    password: null
  })

  const login = () => {
    loginForm.post('login', {
      onSuccess: (response) => {
        console.log(response)
      }
    })
  }
</script>

<template>
  <div>
    <div class="card w-1/3 mx-auto mt-[100px] bg-base-100 shadow-xl">
      <div class="card-body">
        <h2 class="card-title">Login to Dashboard</h2>
        <form @submit.prevent="login">
          
          <label class="form-control w-full">
            <div class="label">
              <span class="label-text" :class="{'text-error': loginForm.errors.email}">Email:</span>
            </div>
            <input 
              v-model="loginForm.email"
              type="email" 
              class="input input-bordered w-full"
              :class="{'input-error text-error': loginForm.errors.email}"
            />
            <div 
              v-if="loginForm.errors.email"
              class="text-error"
            >{{ loginForm.errors.email }}</div>
          </label>

          <label class="form-control w-full">
            <div class="label">
              <span class="label-text" :class="{'text-error': loginForm.errors.password}">Password:</span>
            </div>
            <input 
              v-model="loginForm.password"
              type="password" 
              class="input input-bordered w-full"
              :class="{'input-error text-error': loginForm.errors.password}"
            />
            <div 
              v-if="loginForm.errors.password"
              class="text-error"
            >{{ loginForm.errors.password }}</div>
          </label>

          <button type="submit" class="btn btn-primary mt-5">Login</button>

        </form>
      </div>
    </div>
  </div>
</template>