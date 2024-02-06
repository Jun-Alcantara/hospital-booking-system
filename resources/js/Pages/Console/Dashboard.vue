<script>
  import DashboardLayout from '../Layouts/DashboardLayout.vue';

  // export default {
  //   layout: (h, page) => h(DashboardLayout, [page]),
  //   layout: DashboardLayout,
  // }
</script>

<template>
  <div class="navbar bg-base-100 mb-5 bg-gray-200 shadow-xl">
    <div class="flex-1">
      <a class="btn btn-ghost text-xl">Booking Dashboard</a>
    </div>
    <div class="flex-none">
      <ul class="menu menu-horizontal px-1">
        <li><a>Bookings</a></li>
        <li><a>Reports</a></li>
        <li>
          <details>
            <summary>
              My Account
            </summary>
            <ul class="p-2 bg-base-100 rounded-t-none">
              <li><a>Update Details</a></li>
              <li><a>Logout</a></li>
            </ul>
          </details>
        </li>
      </ul>
    </div>
  </div>
  <div class="max-w-screen-xl mx-auto pt-5">
    <div role="alert" class="alert alert-info">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      <span>You have 4 bookings today.</span>
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
            <th></th>
            <th>Name</th>
            <th>Email</th>
            <th>Booked Date</th>
            <th class="flex gap-3 justify-end">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>1</th>
            <td>Cy Ganderton</td>
            <td>cy.ganderton@example.com</td>
            <td>February 15, 2024 11:00 AM</td>
            <th class="flex gap-3 justify-end">
              <button class="btn btn-xs btn-primary">Approve</button>
              <button class="btn btn-xs btn-warning">Reschedule</button>
              <button class="btn btn-xs btn-error">Cancel</button>
            </th>
          </tr>
          <tr>
            <th>2</th>
            <td>Hart Hagerty</td>
            <td>heart.hagerty@example.com</td>
            <td>February 18, 2024 11:00 AM</td>
            <th class="flex gap-3 justify-end">
              <button class="btn btn-xs btn-primary">Approve</button>
              <button class="btn btn-xs btn-warning">Reschedule</button>
              <button class="btn btn-xs btn-error">Cancel</button>
            </th>
          </tr>
          <tr>
            <th>3</th>
            <td>Brice Swyre</td>
            <td>brice.swyre@example.com</td>
            <td>February 20, 2024 08:00 AM</td>
            <th class="flex gap-3 justify-end">
              <button class="btn btn-xs btn-primary">Approve</button>
              <button class="btn btn-xs btn-warning">Reschedule</button>
              <button class="btn btn-xs btn-error">Cancel</button>
            </th>
          </tr>
          <tr>
            <th>3</th>
            <td>Brice Swyre</td>
            <td>brice.swyre@example.com</td>
            <td>February 20, 2024 08:00 AM</td>
            <th class="flex gap-3 justify-end">
              <button class="btn btn-xs btn-primary">Approve</button>
              <button class="btn btn-xs btn-warning">Reschedule</button>
              <button class="btn btn-xs btn-error">Cancel</button>
            </th>
          </tr>
          <tr>
            <th>3</th>
            <td>Brice Swyre</td>
            <td>brice.swyre@example.com</td>
            <td>February 20, 2024 08:00 AM</td>
            <th class="flex gap-3 justify-end">
              <button class="btn btn-xs btn-primary">Approve</button>
              <button class="btn btn-xs btn-warning">Reschedule</button>
              <button class="btn btn-xs btn-error">Cancel</button>
            </th>
          </tr>
          <tr>
            <th>3</th>
            <td>Brice Swyre</td>
            <td>brice.swyre@example.com</td>
            <td>February 20, 2024 08:00 AM</td>
            <th class="flex gap-3 justify-end">
              <button class="btn btn-xs btn-primary">Approve</button>
              <button class="btn btn-xs btn-warning">Reschedule</button>
              <button class="btn btn-xs btn-error">Cancel</button>
            </th>
          </tr>
          <tr>
            <th>3</th>
            <td>Brice Swyre</td>
            <td>brice.swyre@example.com</td>
            <td>February 20, 2024 08:00 AM</td>
            <th class="flex gap-3 justify-end">
              <button class="btn btn-xs btn-primary">Approve</button>
              <button class="btn btn-xs btn-warning">Reschedule</button>
              <button class="btn btn-xs btn-error">Cancel</button>
            </th>
          </tr>
        </tbody>
      </table>

      <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
          <h3 class="font-bold text-lg">Hello!</h3>
          <p class="py-4">Press ESC key or click the button below to close</p>
          <div class="modal-action">
            <form method="dialog">
              <!-- if there is a button in form, it will close the modal -->
              <button class="btn">Close</button>
            </form>
          </div>
        </div>
      </dialog>
    </div>
  </div>
</template>