<script setup></script>

<template>
  <div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
      <slot />
    </div> 
    <div class="drawer-side">
      <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label> 
      <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
        <!-- Sidebar content here -->
        <li>
          <a>
            <i class="fa fa-home"></i> Dashboard
          </a>
        </li>
        <li>
          <a>
            <i class="fa fa-calendar"></i>
            Calendar
          </a>
        </li>
        <li>
          <a>
            <i class="fa fa-file"></i>
            Reports
          </a>
        </li>
      </ul>
    
    </div>
  </div>
</template>