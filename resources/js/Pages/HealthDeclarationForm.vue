<script setup>
  import { ref } from 'vue'
  import dayjs from 'dayjs'
  import { useForm } from '@inertiajs/vue3';
  import flatPickr from 'vue-flatpickr-component'
  import 'flatpickr/dist/flatpickr.css'

  const props = defineProps({
    patient: Object,
    booking: Object
  })

  const form = useForm({
    firstname: props.patient.firstname,
    middlename: props.patient.middlename,
    lastname: props.patient.lastname,
    gender: null,
    dob: null,
    age: null,
    contact_number: null,
    occupation: null, 
    address: null,
    answers: {
      q1: null,
      q2: null,
      q3: null,
      q4: {
        o1: false,
        o1selected: null,
        o2: false,
        o2selected: null,
        o3: false,
        o3selected: null,
        o4: false,
        o5: false,
        o6: false,
        o7: false,
        o8: false,
        o9: false,
        o10: false,
        o11: false
      },
      q5: null,
      q6: null,
      q7: null,
      q8: null,
      q9: null,
      q10: null,
      q11: null
    }
  })

  const flatpickrConfig = ref({
    maxDate: dayjs().format('YYYY-MM-DD')
  })

  const resetRadio = (optionselected) => {
    form.answers.q4[optionselected] = null
  }

  const calculateAge = (e) => {
    const dob = dayjs(e.target.value)
    const age = dayjs().diff(dob, 'year')

    form.age = age
  }

  const submit = () => {
    form.post(`/booking/${props.booking.reference_number}/health-declaration-form`, {
      onSuccess: (repsonse) => console.log(response)
    })
  }

</script>

<template>
  <section class="bg-gray-100 py-[90px]" style="background: url('/images/backgrounds/booking-form.jpg'); background-repeat: no-repeat; background-size: cover; background-attachment: fixed;">
    <div class="max-w-screen-xl mx-auto">
      <div class="card bg-white w-full shadow">
        <div class="card-body">

          <div class="mb-[50px]">
            <h1 class="font-bold text-4xl text-center">
              ROSARIO MACLANG BAUTISTA GENERAL HOSPITAL
            </h1>
            <h3 class="font-semibold text-2xl text-center">
              HOSPITAL INFORMATION MANAGEMENT COVID 19 - TB SCREENING TOOL
            </h3>
          </div>

          <div>
            <h3>COMPLETE NAME: (PANGALAN)</h3>
          </div>
          <div class="flex gap-3">
            <div class="basis-1/3">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Firstname:</span>
                </div>

                <input 
                  v-model="form.firstname"
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
                  v-model="form.middlename"
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
                  v-model="form.lastname"
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
                  <span class="label-text">Gender (Kasarian):</span>
                </div>
                <select 
                  v-model="form.gender"
                  class="select select-bordered w-full"
                >
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
              </label>
            </div>
            <div class="basis-1/4">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Date of Birth (Kaarawan):</span>
                </div>

                <flat-pickr 
                  v-model="form.dob"
                  @change="calculateAge"
                  :config="flatpickrConfig"
                  class="input input-bordered w-full cursor-pointer"
                />
              </label>
            </div>
            <div class="basis-1/4">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Age (Edad):</span>
                </div>

                <input 
                  v-model="form.age"
                  type="text" 
                  class="input input-bordered w-full"
                  readonly
                />
              </label>
            </div>
            <div class="basis-1/4">
              <label class="form-control w-full">
                <div class="label">
                  <span class="label-text">Contact Number (Telepono):</span>
                </div>

                <input 
                  v-model="form.contact_number"
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
                  <span class="label-text">Occupation (Trabaho):</span>
                </div>

                <input 
                  v-model="form.occupation"
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
                  v-model="form.address"
                  type="text" 
                  class="input input-bordered w-full"
                />
              </label>
            </div>
          </div>

          <div role="alert" class="alert alert-info mt-5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>MGA TAGUBILIN: LAGYAN NG TSEK ANG NAANGKOP SA INYONG SITWASYON.</span>
          </div>

          <!-- Q1 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Meron ka bang bakuna sa COVID-19?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input type="radio" name="q1" value="1" class="radio" v-model="form.answers.q1" />
                  Meron, Kumpleto
                </label>
                <label for="yes2" class="flex gap-1">
                  <input type="radio" name="q1" value="2" class="radio" v-model="form.answers.q1" />
                  Meron, 'Di kumpleto'
                </label>
                <label for="yes2" class="flex gap-1">
                  <input type="radio" name="q1" value="3" class="radio" v-model="form.answers.q1" />
                  Wala
                </label>
              </div>
            </div>
          </div>

          <!-- Q2 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Meron ka bang booster ng COVID-19 Vaccine?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input
                    v-model="form.answers.q2"
                    type="radio"
                    name="q2"
                    value="1"
                    class="radio"
                  />
                  Meron
                </label>
                <label for="yes2" class="flex gap-1">
                  <input
                    v-model="form.answers.q2"
                    type="radio"
                    name="q2"
                    value="2"
                    class="radio"
                  />
                  Wala
                </label>
              </div>
            </div>
          </div>

          <!-- Q3 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Nagkaroon ng close contact sa isang CONFIRMED o PROBABLE na kaso ng COVID-19 sa loob ng 14 araw?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input
                    v-model="form.answers.q3"
                    type="radio"
                    name="q3"
                    value="1"
                    class="radio"
                  />
                  Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input
                    v-model="form.answers.q3"
                    type="radio"
                    name="q3"
                    value="2"
                    class="radio"
                  />
                  Hindi
                </label>
              </div>
            </div>
          </div>

          <!-- Q4 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Nakaranas ng mga sumusunod na sintomas? (Lagyan ng tsek)
              </div>
              <div class="mt-3 flex flex-wrap">
                
                <!-- o1 -->
                <div class="basis-1/2 my-2">
                  <label for="#" class="flex gap-2">
                    <input 
                      v-model="form.answers.q4.o1"
                      @change="resetRadio('o1selected')"
                      type="checkbox" 
                      name="symptoms" 
                      class="checkbox"
                    /> Lagnat/Sinat
                  </label>
                  <label for="#" class="flex gap-2 mt-1 pl-[50px]" :class="{'text-gray-300': !form.answers.q4.o1}">
                    <input 
                      v-model="form.answers.q4.o1selected"
                      type="radio" 
                      name="symptoms-1" 
                      value="yes1" 
                      class="radio" 
                      :disabled="!form.answers.q4.o1" 
                    /> Kulang sa dalawang lingo
                  </label>
                  <label for="#" class="flex gap-2 mt-1 pl-[50px]" :class="{'text-gray-300': !form.answers.q4.o1}">
                    <input 
                      v-model="form.answers.q4.o1selected"
                      :disabled="!form.answers.q4.o1" 
                      type="radio" 
                      name="symptoms-1" 
                      value="yes2" 
                      class="radio" 
                    /> Sakto o Lagpas sa dalawang lingo
                  </label>
                </div>

                <!-- o2 -->
                <div class="basis-1/2 my-2">
                  <label for="#" class="flex gap-2">
                    <input 
                      v-model="form.answers.q4.o2"
                      @change="resetRadio('o2selected')"
                      type="checkbox" 
                      name="symptoms" 
                      value="2"
                      class="checkbox" 
                    /> Ubo
                  </label>
                  <label for="#" class="flex gap-2 mt-1 pl-[50px]" :class="{'text-gray-300': !form.answers.q4.o2}">
                    <input
                      v-model="form.answers.q4.o2selected"
                      :disabled="!form.answers.q4.o2" 
                      type="radio" 
                      value="yes1" 
                      class="radio"
                    /> Kulang sa dalawang lingo
                  </label>
                  <label for="#" class="flex gap-2 mt-1 pl-[50px]" :class="{'text-gray-300': !form.answers.q4.o2}">
                    <input 
                      v-model="form.answers.q4.o2selected"
                      :disabled="!form.answers.q4.o2" 
                      type="radio"
                      value="yes2" 
                      class="radio"
                    /> Sakto o Lagpas sa dalawang lingo
                  </label>
                </div>

                <!-- o3 -->
                <div class="basis-full my-2">
                  <label for="#" class="flex gap-2">
                    <input 
                      v-model="form.answers.q4.o3"
                      @change="resetRadio('o3selected')"
                      type="checkbox" 
                      name="symptoms" 
                      value="3" 
                      class="checkbox"
                    /> Hindi maipaliwanag na pagpapawis sa gabi
                  </label>
                  <label for="#" class="flex gap-2 mt-1 pl-[50px]" :class="{'text-gray-300': !form.answers.q4.o3}">
                    <input
                      v-model="form.answers.q4.o3selected"
                      :disabled="!form.answers.q4.o3"
                      type="radio"
                      value="1"
                      class="radio"
                    /> Kulang sa dalawang lingo
                  </label>
                  <label for="#" class="flex gap-2 mt-1 pl-[50px]" :class="{'text-gray-300': !form.answers.q4.o3}">
                    <input
                      v-model="form.answers.q4.o3selected"
                      :disabled="!form.answers.q4.o3"
                      type="radio"
                      value="2"
                      class="radio"
                    /> Sakto o Lagpas sa dalawang lingo
                  </label>
                </div>

                <!-- o4 -->
                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input v-model="form.answers.q4.o4" type="checkbox" name="symptoms" value="4" class="checkbox" /> Hindi maipaliwanag na pangangayat o pagbaba ng timbang
                </label>
                
                <!-- o5 -->
                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input v-model="form.answers.q4.o5" type="checkbox" name="symptoms" value="5" class="checkbox" /> Sipon
                </label>

                <!-- o6 -->
                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input v-model="form.answers.q4.o6" type="checkbox" name="symptoms" value="6" class="checkbox" /> Pangangati ng lalamunan
                </label>

                <!-- o7 -->
                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input v-model="form.answers.q4.o7" type="checkbox" name="symptoms" value="7" class="checkbox" /> Nahihirapan huminga
                </label>

                <!-- o8 -->
                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input v-model="form.answers.q4.o8" type="checkbox" name="symptoms" value="8" class="checkbox" /> Pagtatae
                </label>

                <!-- o9 -->
                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input v-model="form.answers.q4.o9" type="checkbox" name="symptoms" value="9" class="checkbox" /> Pananakit ng katawan
                </label>

                <!-- o10 -->
                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input v-model="form.answers.q4.o10" type="checkbox" name="symptoms" value="10" class="checkbox" /> Nawalan ng panlasa/pang-amoy
                </label>

                <!-- o11 -->
                <label for="#" class="flex gap-2 basis-1/2 mt-2">
                  <input v-model="form.answers.q4.o11" type="checkbox" name="symptoms" value="11" class="checkbox" /> Nanghihina / Nawalan ng gana kumain / Nawalan ng ganan maglaro (para sa mga bata na 15 taong gulang pababa)
                </label>

              </div>
            </div>
          </div>

          <!-- Q5 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Ikaw ba ay meron XRAY na nagmumungkahi na ikaw ay may Tuberculosis o TB sa loob ng nakalipas na taon?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input
                    v-model="form.answers.q5"
                    type="radio"
                    value="1"
                    class="radio"
                  /> Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input
                    v-model="form.answers.q5"
                    type="radio"
                    value="2"
                    class="radio"
                  /> Hindi
                </label>
              </div>
            </div>
          </div>

          <!-- Q6 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Ikaw ba ay kasalukuyang nanggagamot para sa sakit na Tuberculosis?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input
                    v-model="form.answers.q6"
                    type="radio"
                    value="1"
                    class="radio"
                  /> Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input
                    v-model="form.answers.q6"
                    type="radio"
                    value="2"
                    class="radio"
                  /> Hindi
                </label>
              </div>
            </div>
          </div>

          <!-- Q7 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Ikaw ba ay naggamot dati sa sakit na Tuberculosis or TB?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input
                    v-model="form.answers.q7"
                    type="radio"
                    value="1"
                    class="radio"
                  /> Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input
                    v-model="form.answers.q7"
                    type="radio"
                    value="2"
                    class="radio"
                  /> Hindi
                </label>
              </div>
            </div>
          </div>

          <!-- Q8 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Ikaw ba ay may nakasalamuhang tao na merong Tuberculosis o TB?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input
                    v-model="form.answers.q8"
                    type="radio"
                    value="1"
                    class="radio"
                  /> Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input
                    v-model="form.answers.q8"
                    type="radio"
                    value="2"
                    class="radio"
                  /> Hindi
                </label>
              </div>
            </div>
          </div>

          <!-- Q9 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Ikaw ba ay may HIV/AIDS?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input
                    v-model="form.answers.q9"
                    type="radio"
                    value="1"
                    class="radio"
                  /> Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input
                    v-model="form.answers.q9"
                    type="radio"
                    value="2"
                    class="radio"
                  /> Hindi
                </label>
              </div>
            </div>
          </div>

          <!-- Q10 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Ikaw ba ay nasa edad na 60 na gulang at pataas at merong sakit na Diabetes, Cancer, End Stage Renal disease o nagdadialysis, sakit sa Atay o Cirrhosis, Emphysema o COPD, Autoimmune Disease?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input
                    v-model="form.answers.q10"
                    type="radio"
                    value="1"
                    class="radio"
                  /> Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input
                    v-model="form.answers.q10"
                    type="radio"
                    value="2"
                    class="radio"
                  /> Hindi
                </label>
              </div>
            </div>
          </div>

          <!-- Q11 -->
          <div class="mt-5">
            <div class="card bg-base-200 rounded-box px-3 py-5 flex flex-col">
              <div>
                Ikaw ba ay nahahanay sa mga Indigent o Myembro ng 4Ps o CCT?
              </div>
              <div class="flex flex-row gap-5 mt-3">
                <label for="yes1" class="flex gap-1">
                  <input
                    v-model="form.answers.q11"
                    type="radio"
                    value="1"
                    class="radio"
                  /> Oo
                </label>
                <label for="yes2" class="flex gap-1">
                  <input
                    v-model="form.answers.q11"
                    type="radio"
                    value="2"
                    class="radio"
                  /> Hindi
                </label>
              </div>
            </div>
          </div>

          <div class="mt-5 flex">
            <div class="flex justify-center items-start pr-3 pt-3">
              <input type="checkbox" class="checkbox">
            </div>
            <div>
              <p class="italic">
                Lahat ng impormasyong ibinigay ko ay totoo, tama at kumpleto. Naiintindihan ko na ang pagbibigay ng maling sagot ay maaring parusahan ayon sa batas
              </p>
              <p class="italic">
                Kusang loob at malayang pumapayag ako sa koleksyon at pagbabahagi ng nasa itaas na personal na impormasyon na may kaugnayan sa RMBGH COVID-19 protocol.
              </p>
            </div>
          </div>

          <div class="mt-5 flex justify-end">
            <button @click="submit" class="btn btn-primary">
              <i class="fa fa-paper-plane"></i>
              Submit Form
            </button>
          </div>

        </div>
      </div>
    </div>
  </section>
</template>