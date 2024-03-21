<script setup>
  const props = defineProps({
    form: Object
  })

  const displayOption = (checked, text) => {
    if (! checked) {
      return `<span class="underlined">___</span> ${text}`
    }

    return `<span class="underlined"><i class="fa fa-check"></i></span> ${text}`
  }
</script>

<template>
  <div class="flex">
    <div class="basis-1/5">
      <img src="http://rmb-gh.site/images/qc-logo.png" alt="" class="aspect-square max-w-[193px] object-contain">
    </div>
    <div class="basis-3/5">
      <span class="text-center block w-full text-xl font-semibold">
        Republika ng Pilipinas
      </span>
      <span class="text-center block w-full text-xl font-semibold">
        Lungsod ng Quezon
      </span>
      <h1 class="font-bold text-2xl text-center font-tnr">ROSARIO MACLANG BAUTISTA GENERAL HOSPITAL</h1>
      <span class="text-center block w-full text">
        1BP Rond Batasan Hilla District 2 Quezon City
        <br>
        Landline Number: (02) 8835-2560 / Email Address: rmbgh@quezoncity.gov.ph
      </span>
      <h3 class="font-semibold text-xl text-center">HOSPITAL INFORMATION MANAGEMENT <br> COVID 19 - TB SCREENING TOOL</h3>
    </div>
    <div class="basis-1/5">
      <img src="http://rmb-gh.site/images/logo.png" alt="" class="aspect-square max-w-[193px]">
    </div>
  </div>
  <table>
    <tr>
      <th class="text-left" rowspan="2">
        COMPLETE NAME
        <br>
        (PANGALAN)
      </th>
      <td class="text-center">{{ form.lastname }}</td>
      <td class="text-center">{{ form.firstname }}</td>
      <td class="text-center">{{ form.middlename }}</td>
    </tr>
    <tr>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Middle Name</th>
    </tr>
    <tr>
      <td class="text-left">
        <span class="font-bold">AGE (Edad):</span>
        <br>
        {{ form.age }}
      </td>
      <td class="text-left">
        <span class="font-bold">GENDER (Kasarian):</span>
        <br>
        {{ form.gender }}
      </td>
      <td class="text-left" colspan="2">
        <span class="font-bold">BIRTHDATE (Kaarawan):</span>
        <br>
        {{ form.dob }}
      </td>
    </tr>
    <tr>
      <td class="text-left" colspan="2">
        <span class="font-bold">CONTACT NUMBER (Telepono):</span>
        <br>
        {{ form.contact_number }}
      </td>
      <td class="text-left" colspan="2">
        <span class="font-bold">OCCUPATION (Trabaho)</span>
        <br>
        {{ form.occupation }}
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <span class="font-bold">Unit No. Building / No. Block Street</span>
        <br>
        {{ form.unit_number }}
      </td>
      <td colspan="2">
        <span class="font-bold">Subdivision / Village / Barangay</span>
        <br>
        {{ form.barangay }}
      </td>
    </tr>
    <tr>
      <td>
        <span class="font-bold">City / Municipality</span>
        <br>
        {{ form.municipality }}
      </td>
      <td>
        <span class="font-bold">Province / State</span>
        <br>
        {{ form.province }}
      </td>
      <td>
        <span class="font-bold">Country</span>
        <br>
        {{ form.country }}
      </td>
      <td>
        <span class="font-bold">Zip Code</span>
        <br>
        {{ form.zip_code }}
      </td>
    </tr>
  </table>
  <h3 class="font-bold text-[16px] pl-2">MGA TAGUBILIN: LAGYAN NG TSEK AND NAAANGKOP SA INYONG SITWASYON</h3>
  <table>
    <tr>
      <td colspan="4" class="flex">
        <div class="basis-1/2">
          1. Meron ka bang bakuna sa COVID-19?
        </div>
        <div class="basis-1/2 flex justify-end gap-[30px] pr-5">
          <div>
            <span v-html="displayOption(form.questions.q1 == 1, 'MERON, KUMPLETO')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q1 == 2, 'MERON, \'DI KUMPLETO')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q1 == 3, 'WALA')"></span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="flex">
        <div class="basis-1/2">
          2. Meron ka bang booster ng COVID-19 Vaccine?
        </div>
        <div class="basis-1/2 flex justify-end gap-[30px] pr-5">
          <div>
            <span v-html="displayOption(form.questions.q2 == 1, 'MERON')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q2 == 2, 'WALA')"></span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="flex">
        <div class="basis-1/2">
          3. Nagkaroon ng close contact sa isang CONFIRMED o PROBABLE na kaso ng COVID-19 sa loob ng 14 araw?
        </div>
        <div class="basis-1/2 flex justify-end items-center gap-[30px] pr-5">
          <div>
            <span v-html="displayOption(form.questions.q3 == 1, 'OO')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q3 == 2, 'HINDI')"></span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="4">
        4. Nakaranas ng mga sumusunod na sintomas?
        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            a. <span v-html="displayOption(form.questions.q4.o1, 'Lagnat/Sinat')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q4.o1selected == 'yes1', 'Kulang sa dalawang lingo')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q4.o1selected == 'yes2', 'Sakto o Lagpas sa dalawang lingo')"></span>
          </div>
        </div>

        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            b. <span v-html="displayOption(form.questions.q4.o2, 'Ubo')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q4.o2selected == 'yes1', 'Kulang sa dalawang lingo')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q4.o2selected == 'yes2', 'Sakto o Lagpas sa dalawang lingo')"></span>
          </div>
        </div>

        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            c. <span v-html="displayOption(form.questions.q4.o3, 'Hindi maipaliwanag na pagpapawis sa gabi')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q4.o3selected == 'yes1', 'Kulang sa dalawang lingo')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q4.o3selected == 'yes2', 'Sakto o Lagpas sa dalawang lingo')"></span>
          </div>
        </div>

        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            d. <span v-html="displayOption(form.questions.q4.o4, 'Hindi maipaliwanag na pangangayat')"></span>
          </div>
        </div>

        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            e. <span v-html="displayOption(form.questions.q4.o5, 'Sipon')"></span>
          </div>
        </div>

        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            f. <span v-html="displayOption(form.questions.q4.o6, 'Pangangati ng lalamunan')"></span>
          </div>
        </div>

        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            g. <span v-html="displayOption(form.questions.q4.o7, 'Nahihirapan huminga')"></span>
          </div>
        </div>

        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            h. <span v-html="displayOption(form.questions.q4.o8, 'Pagtatae')"></span>
          </div>
        </div>

        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            i. <span v-html="displayOption(form.questions.q4.o9, 'Pananakit ng katawan')"></span>
          </div>
        </div>

        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            j. <span v-html="displayOption(form.questions.q4.o10, 'Nawalan ng panlasa/pangamoy')"></span>
          </div>
        </div>

        <div class="px-7 flex gap-[50px] mb-2">
          <div>
            k. <span v-html="displayOption(form.questions.q4.o11, 'Nanghihina / nawalan ng ganan kumain / nawalan ng gana maglaro (para sa mga bata ng 15 taong gulang pababa)')"></span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="flex">
        <div class="basis-1/2">
          5. Ikaw ba ay merong XRAY na nagmumungkahi na ikaw ay may Tuberculosis o TB sa loob ng nakalipas na taon?
        </div>
        <div class="basis-1/2 flex justify-end items-center gap-[30px] pr-5">
          <div>
            <span v-html="displayOption(form.questions.q5 == 1, 'OO')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q5 == 2, 'HINDI')"></span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="flex">
        <div class="basis-1/2">
          6. Ikaw ba ay kasalukuyang nanggagamot para sa sakit ng Tuberculosis?
        </div>
        <div class="basis-1/2 flex justify-end items-center gap-[30px] pr-5">
          <div>
            <span v-html="displayOption(form.questions.q6 == 1, 'OO')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q6 == 2, 'HINDI')"></span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="flex">
        <div class="basis-1/2">
          7. Ikaw ba ay naggamot dati sa sakit na Tuberculosis o TB?
        </div>
        <div class="basis-1/2 flex justify-end items-center gap-[30px] pr-5">
          <div>
            <span v-html="displayOption(form.questions.q7 == 1, 'OO')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q7 == 2, 'HINDI')"></span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="flex">
        <div class="basis-1/2">
          8. Ikaw ba ay may nakasalamuhang tao na merong Tuberculosis o TB?
        </div>
        <div class="basis-1/2 flex justify-end items-center gap-[30px] pr-5">
          <div>
            <span v-html="displayOption(form.questions.q8 == 1, 'OO')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q8 == 2, 'HINDI')"></span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="flex">
        <div class="basis-1/2">
          9. Ikaw ba ay may HIV / AIDS?
        </div>
        <div class="basis-1/2 flex justify-end items-center gap-[30px] pr-5">
          <div>
            <span v-html="displayOption(form.questions.q9 == 1, 'OO')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q9 == 2, 'HINDI')"></span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="flex">
        <div class="basis-1/2">
          10. Ikaw ba ay nasa edad na 60 na gulang at pataas at merong sakit na Diabetes, Cancer, End Stage Renal disease o nagdadialysis, sakit sa Atay o Cirrhosis, Emphysema o COPD, Autoimmune Disease?
        </div>
        <div class="basis-1/2 flex justify-end items-center gap-[30px] pr-5">
          <div>
            <span v-html="displayOption(form.questions.q10 == 1, 'OO')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q10 == 2, 'HINDI')"></span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="flex">
        <div class="basis-1/2">
          11. Ikaw ba ay nahahanay sa mga Indigent o membro ng 4Ps o CCT?          
        </div>
        <div class="basis-1/2 flex justify-end items-center gap-[30px] pr-5">
          <div>
            <span v-html="displayOption(form.questions.q11 == 1, 'OO')"></span>
          </div>
          <div>
            <span v-html="displayOption(form.questions.q11 == 2, 'HINDI')"></span>
          </div>
        </div>
      </td>
    </tr>
  </table>

  <div class="mt-5">
    <p class="italic indent-[50px]">
      Lahat ng impormasyong ibinigay ko ay totoo, tama at kumpleto. Naiintindihan ko na ang pagbibigay ng maling sagot ay maaring parusahan ayon sa batas
    </p>
    <br>
    <p class="italic indent-[50px]">
      Kusang loob at malayang pumapayag ako sa koleksyon at pagbabahagi ng nasa itaas na personal na impormasyon na may kaugnayan sa RMBGH COVID-19 protocol.
    </p>
  </div>
</template>

<style scoped>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    border: 1px solid black;
    padding: 5px 10px;
  }
</style>