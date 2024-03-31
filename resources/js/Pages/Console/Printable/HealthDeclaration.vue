<script setup>
  import HealthDeclarationFormView from '@/Pages/Components/HealthDeclarationFormView.vue'
  import { onMounted } from 'vue'

  const props = defineProps({
    healthDeclarationForm: Object
  })

  onMounted(() => {
    window.print()
  })
</script>

<template>
  <div>
    <HealthDeclarationFormView :form="healthDeclarationForm" />
  </div>
</template>