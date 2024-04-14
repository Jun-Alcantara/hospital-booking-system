<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daily Census</title>
  @vite('resources/css/app.css')

  <style>
    * {
      font-size: 12px;
      font-family: Arial, Helvetica, sans-serif;
    }

    #main {
      width: 1080px;
    }

    table {
      width: 700px;
      margin-top: 15px;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid black;
    }

    td {
      width: 175px;
    }

    th {
      text-align: left;
    }
  </style>
</head>
<body>
  <div id="main">

    <table>
      <tr>
        <td style="width: 100px !important; border: none;">
          <img src="http://rmb-gh.site/images/qc-logo.png" style="width: 150px;">
        </td>
        <td style="width: 400px !important; padding: 0; border: none;">
          <p style="text-align: center; margin: 0;">
            Republika ng Pilipinas <br>
            Lungson ng Quezon
          </p>
          <h1 style="font-weight: bold; text-align: center; margin: 0;">ROSARIO MACLANG BAUTISTA GENERAL HOSPITAL</h1>
          <p style="text-align: center; margin: 0;">
            1BP Rond Batasan Hilla District 2 Quezon City
            <br>
            Landline Number: (02) 8835-2560 / Email Address: rmbgh@quezoncity.gov.ph
          </p>
          <h3 style="font-weight: bold; text-align: center;">OUT PATIENT DEPARTMENT</h3>
          <h3 style="font-weight: bold; text-align: center;">OPD DAILY CENSUS</h3>
        </td>
        <td style="width: 50px !important; text-align: left; border: none;">
          <img src="http://rmb-gh.site/images/logo.png" style="width: 130px; float: right;">
        </td>
      </tr>
    </table>

    <table id="details">
      <tr>
        <th colspan="2">SERVICE:</th>
        <td colspan="2">{{ $clinic->name }} / {{ $department->name }}</td>
      </tr>

      <tr>
        <th colspan="2">DATE:</th>
        <td colspan="2">{{ now()->format('F d, Y') }}</td>
      </tr>

      <tr>
        <th colspan="2">TOTAL SYMPTOMATIC:</th>
        <td colspan="2"></td>
      </tr>

      <tr>
        <th colspan="2">TOTAL ASYMPTOMATIC:</th>
        <td colspan="2"></td>
      </tr>

      <tr>
        <th colspan="2">TOTAL CENSUS:</th>
        <td colspan="2"></td>
      </tr>
    </table>

    <table>
      <tr>
        <th colspan="2" style="text-align: center;">AGE GROUP</th>
        <th style="text-align: center;">MALE</th>
        <th style="text-align: center;">FEMALE</th>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">< 1</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">1 - 4</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">5 - 9</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">10 - 14</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">15 - 18</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">19</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">20 - 24</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">25 -29</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">30 - 34</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">35 - 39</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">40 - 44</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">45 - 49</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: center;">50 - 54</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>
      
      <tr>
        <th colspan="2" style="text-align: center;">55 - 59</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center;">60 - 64</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center;">65 - 69</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center;">70 <</th>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
      </tr>
    </table>

    <table>
      <tr>
        <th style="border: none;">CASES:</th>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center;">&nbsp;</th>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center;">&nbsp;</th>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center;">&nbsp;</th>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center;">&nbsp;</th>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center;">&nbsp;</th>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center;">&nbsp;</th>
        <td></td>
        <td></td>
      </tr>
    </table>

    <table style="width: 50%">
      <tr>
        <td><strong>TREATED:</strong></td>
        <td></td>
      </tr>
      <tr>
        <td><strong>TO ER:</strong></td>
        <td></td>
      </tr>
      <tr>
        <td><strong>ADMISSION:</strong></td>
        <td></td>
      </tr>
      <tr>
        <td><strong>THOC:</strong></td>
        <td></td>
      </tr>
      <tr>
        <td><strong>TOTAL:</strong></td>
        <td></td>
      </tr>
    </table>

    <table style="width: 50%">
      <tr>
        <td><strong>REFERALS:</strong></td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
      </tr>
    </table>

    <table style="max-width: 700px;">
      <tr>
        <th style="border: none;">NOTIFIABLES:</th>
      </tr>
      <tr>
        <th style="text-align: center;">NAME</th>
        <th style="text-align: center;">AGE</th>
        <th style="text-align: center;">SEX</th>
        <th style="text-align: center;">DIAGNOSIS</th>
        <th style="text-align: center;">PHYSICIAN</th>
      </tr>
      <tr>
        <td style="width: 100px !important;">&nbsp;</td>
        <td style="width: 50px !important;"></td>
        <td style="width: 50px !important;"></td>
        <td style="width: 200px !important;"></td>
        <td style="width: 100px !important;"></td>
      </tr>
    </table>
  </div>
</body>
</html>