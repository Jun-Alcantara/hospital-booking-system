<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosario Macapagal Bautista General Hospital</title>
    <style>
      * {
        padding: 0;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      body {
        background-color: rgb(242, 242, 242);
      }

      #main-container-table {
        width: 700px;
        margin: 0 auto;
        background-color: white;
        border-radius: 10px;
        margin-top: 30px;
      }

      #booking-details-table {
        background-color: white;
        width: 100%;
        border-radius: 10px;
      }

      #booking-details-table th,
      #booking-details-table td {
        text-align: left;
        padding: 2px 15px;
      }

      #booking-details-table th {
        width: 120px;
      }

      .email-body {
        padding: 20px;
        padding-top: 0;
      }

      .email-body > div {
        background-color: rgb(235, 235, 235);
        border-radius: 10px;
        padding: 20px;
      }

      .logo-container {
        width: 150px;
        padding: 20px;
      }

      .title {
        font-weight: 700;
        font-size: 25px;
      }

      /* Utilities */
      .mb-3 { margin-bottom: 15px; }

      .w-full { width: 100%; }
      
      .h-auto { height: auto; }
      .h-full { height: 100% }

      .p-1 { padding: 5px; }

      .text-left { text-align: left; }
    </style>
  </head>
  <body>
    <table id="main-container-table">
      <tr>
        <td class="logo-container">
          <img class="w-full h-full object-cover" src="http://rmb-gh.site/images/logo.png" alt="Rosario Macapagal Bautista General Hospital">
        </td>
        <td>
          <h1 class="title">You appointment at Rosario Macapagal Bautista General Hospital is confirmed!</h1>
        </td>
      </tr>
      <tr>
        <td class="email-body" colspan="2">
          <div>
            <p class="mb-3 ">Hi {{ $notifiable->firstname }} {{ $notifiable->lastname }}!</p>
            <p class="mb-3">
              Rosario Macapagal Bautista General Hospital has <strong>CONFIRMED</strong> you booking request. Please don't be a no show, the hospital reserved that spot for you.
            </p>
            <p class="mb-3">
              You may see your booking request details below:
            </p>
            <table id="booking-details-table" class="mb-3">
              <tr>
                <th>Name:</th>
                <td>
                  {{ $notifiable->firstname }} {{ $notifiable->lastname }}
                </td>
              </tr>
              <tr>
                <th>Booked Date:</th>
                <td>
                  {{ $booking->booking_date->format('F d, Y h:i A') }}
                </td>
              </tr>
              <tr>
                <th>Email:</th>
                <td>
                  {{ $notifiable->email }}
                </td>
              </tr>
              <tr>
                <th>Status:</th>
                <td>
                  Approved
                </td>
              </tr>
            </table>
            <p>
              If you wish to cancel, please contact us at Rosario Maclang Bautista General Hospital with your booking details.
            </p>
          </div>
        </td>
      </tr>
    </table>
  </body>
</html>