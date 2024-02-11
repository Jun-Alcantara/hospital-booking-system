<script setup>
  import { useForm } from '@inertiajs/vue3';
  import flatPickr from 'vue-flatpickr-component'
  import 'flatpickr/dist/flatpickr.css'

  const form = useForm({
    
  })
</script>

<template>
  <section>
    <div class="max-w-screen-xl mx-auto">
      <div class="card w-full shadow">
        <div class="card-body">

          <div class="flex gap-3">
            <div class="basis-1/3">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Firstname:</span>
                </div>

                <input 
                  type="text" 
                  class="input input-bordered w-full"
                />
              </label>
            </div>
            <div class="basis-1/3">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Middlename:</span>
                </div>

                <input 
                  type="text" 
                  class="input input-bordered w-full"
                />
              </label>
            </div>
            <div class="basis-1/3">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Lastname:</span>
                </div>

                <input 
                  type="text" 
                  class="input input-bordered w-full"
                />
              </label>
            </div>
          </div>

          <div class="flex gap-3">
            <div class="basis-1/4">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Gender:</span>
                </div>
                <select 
                  class="select select-bordered w-full"
                >
                  <option value="10">Male</option>
                  <option value="11">Female</option>
                </select>
              </label>
            </div>
            <div class="basis-1/4">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Date of Birth:</span>
                </div>

                <flat-pickr 
                  placeholder="Select date of visit"
                  class="input input-bordered w-full cursor-pointer"
                />
              </label>
            </div>
            <div class="basis-1/4">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Age:</span>
                </div>

                <input 
                  type="text" 
                  class="input input-bordered w-full"
                  readonly
                />
              </label>
            </div>
            <div class="basis-1/4">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Contact Number:</span>
                </div>

                <input 
                  type="text" 
                  class="input input-bordered w-full"
                  readonly
                />
              </label>
            </div>
          </div>

          <div class="flex gap-3">
            <div class="basis-1/4">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Nationality:</span>
                </div>

                <input 
                  type="text" 
                  class="input input-bordered w-full"
                />
              </label>
            </div>
            <div class="basis-3/4">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Address:</span>
                </div>

                <input 
                  type="text" 
                  class="input input-bordered w-full"
                />
              </label>
            </div>
          </div>

          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Naglakbay or nanirahan sa isang lugar na may ulat ng local na transmisyon ng sakit sa COVID-19 sa loob ng 14 araw bago magpakonsulta o bago lumabas ang sintomas?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input type="radio" name="radio-1" class="radio" />
                  Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input type="radio" name="radio-1" class="radio" />
                  Hindi
                </label>
              </div>
            </div>
          </div>

          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Nagkaroon ng close contact sa isang CONFIRMED o PROBABLE na kaso ng COVID-19 sa loob ng 14 araw?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input type="radio" name="radio-1" class="radio" />
                  Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input type="radio" name="radio-1" class="radio" />
                  Hindi
                </label>
              </div>
            </div>
          </div>

          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Nakaranas ng mga sumusunod na sintomas? (Lagyan ng tsek)
              </div>
              <div class="mt-3 flex flex-wrap">

                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input type="checkbox" class="checkbox" /> Lagnat/Sinat
                </label>
                
                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input type="checkbox" class="checkbox" /> Ubo
                </label>

                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input type="checkbox" class="checkbox" /> Sipon
                </label>

                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input type="checkbox" class="checkbox" /> Pangangati ng lalamunan
                </label>

                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input type="checkbox" class="checkbox" /> Nahihirapan huminga
                </label>

                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input type="checkbox" class="checkbox" /> Pagtatae
                </label>

                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input type="checkbox" class="checkbox" /> Pananakit ng katawan
                </label>

                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input type="checkbox" class="checkbox" /> Nawalan ng panlasa/pang-amoy
                </label>

              </div>
            </div>
          </div>

          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Ikaw ba ay nagkaroon ng COVID-19 sa nakalipas na tatlong buwan?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input type="radio" name="radio-1" class="radio" />
                  Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input type="radio" name="radio-1" class="radio" />
                  Hindi
                </label>
                
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</template>