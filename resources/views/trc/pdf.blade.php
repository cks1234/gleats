<!DOCTYPE html>
<html>

<head>
    <title>Electrical Contractor's Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        table {
            font-size: 14px;
        }

        table td {
            text-transform: uppercase;
        }

        .header-logo {
            text-align: left;
            font-size: 28px;
            margin-left: 20px;
        }

        .header-logo .gle {
            color: blue;
        }

        .header-logo .a {
            color: green;
        }

        .header-logo .ts {
            color: red;
        }

        .header-logo .electrical {
            color: blue;
        }

        .underline {
            border-bottom: 1px solid black;
            width: 100%;
            margin-top: 20px;
        }

        .report-title {
            text-align: left;
            margin-top: 10px;
        }

        .report-title h1 {
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
            margin-top: -5px
        }

        .report-title p {
            margin: 0;
            font-size: 12px;
            font-weight: normal;
        }

        .job-no-box {
            float: right;
            border: 1px solid black;
            padding: 10px 5px;
            font-size: 14px;
            width: 100px;
            text-align: center;
            font-weight: bold;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .info-table td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
        }

        .full-width {
            width: 70%;
        }

        .small {
            font-size: 12px;
        }

        .justified {
            text-align: justify;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="header-logo">
            <span class="gle">GLE</span><span class="a">a</span><span class="ts">TS</span> <span
                class="electrical">Electrical</span>
        </div>
        <div class="underline"></div>
    </div>

    <div class="report-title">
        <div class="job-no-box">
            {{ $testReport->job->job_no }}
        </div>
        <p>Electrical Safety Act 2002 and Electrical Safety Regulation 2013</p>
        <h1>Electrical Contractors Report Certificate of Test</h1>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Client's Name:</strong></td>
            <td class="full-width">{{ $testReport->job->client->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Client's Postal Address:</strong></td>
            <td class="full-width">{{ $testReport->job->client->postal_address ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Address Where Electrical Work Was Carried Out and Connected:</strong></td>
            <td class="full-width">{{ $testReport->job->address->address ?? 'N/A' }}</td>
        </tr>
    </table>

    <p class="small justified">DETAILS OF ELECTRICAL WORK THAT IS NOT REQUIRED TO BE INSPECTED BY AN INSTALLATION
        INSPECTOR
        AND THAT HAS BEEN TESTED AND CONNECTED</p>

    <table class="info-table">
        <tr>
            <td><strong>Equipment Details:</strong></td>
            <td class="full-width">{{ $testReport->equipment ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Electrical Work Details:</strong></td>
            <td class="full-width">{{ $testReport->electrical_work ?? 'N/A' }}</td>
        </tr>
    </table>

    <table
        style="margin-right: 10px; border: 1px solid gray; border-right: 0; background-color: lightgray; font-size: 14px;">
        <tr>
            <td style="padding: 5px; text-align: center;">
                SUPERVISOR
            </td>
        </tr>
    </table>


    <table class="info-table">
        <tr>
            <td><strong>Name:</strong></td>
            <td class="full-width">{{ $testReport->job->supervisor->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>License:</strong></td>
            <td class="full-width">{{ $testReport->job->license->license ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Signature:</strong></td>
            <td class="full-width small"><img src="{{ $testReport->supervisor_signature }}" alt="Supervisor Signature">
                <p><i>Date: {{ $testReport->supervisor_signature_date->format('d M Y') }}</i></p>
            </td>
        </tr>
    </table>

    <table
        style="margin-right: 10px; border: 1px solid gray; border-right: 0; background-color: lightgray; font-size: 14px;">
        <tr>
            <td style="padding: 5px; text-align: center;">
                CONTRACTOR
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td><strong>Name:</strong></td>
            <td class="full-width">G L ELECTRONIC & TECH SOLUTIONS PTY LTD</td>
        </tr>
        <tr>
            <td><strong>Address:</strong></td>
            <td class="full-width">P.O. BOX 315 NATHAN QLD 4111</td>
        </tr>
        <tr>
            <td><strong>License:</strong></td>
            <td class="full-width">70387</td>
        </tr>
        <tr>
            <td><strong>Phone:</strong></td>
            <td class="full-width">07 3193 9791</td>
        </tr>
        <tr>
            <td><strong>Mobile:</strong></td>
            <td class="full-width">0429 777 668</td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td class="full-width">admin@gleats.com</td>
        </tr>
        <tr>
            <td><strong>Signature:</strong></td>
            <td class="full-width small"><img src="{{ $testReport->contractor_signature }}" alt="Contractor Signature">
                <p><i>Date: {{ $testReport->contractor_signature_date->format('d M Y') }}</i></p>
            </td>
        </tr>
    </table>
</body>

</html>
