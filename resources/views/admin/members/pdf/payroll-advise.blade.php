<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Advise Report</title>
    <style>
        /* Define your styles here */
        body {
            font-family: 'Fira Sans', sans-serif;
        }
        table {
        border-collapse: collapse;
        width: 100%;
        }
        th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
        }
        th {
        background-color: lightgrey;
        }
    </style>
</head>
<body>
<h1>Payroll Advise Report</h1>
  <table>
    <thead>
      <tr>
        <th>Payroll No</th>
        <th>Subject</th>
        <th>Members ID No.</th>
        <th>Employee No.</th>
        <th>Contribution Type</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($table_data as $row)
        <tr>
          <td>{{ $row['payroll_no'] }}</td>
          <td>{{ $row['subject'] }}</td>
          <td>{{ $row['members_id_no'] }}</td>
          <td>{{ $row['employee_no'] }}</td>
          <td>{{ $row['contribution_type'] }}</td>
          <td>{{ $row['amount'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>


</body>
</html>