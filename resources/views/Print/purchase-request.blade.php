<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Purchase Requisition | {{ $record->code }}</title>
    <style>
        /* 1. Aturan Global agar perhitungan lebar presisi */
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        /* 2. Container Utama */
        .table-container {
            width: 99%;
            /* Jangan gunakan 100% agar ada ruang untuk border */
            margin: 0 auto;
            /* Tengah-tengah kertas */
            border: 1px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* Memaksa lebar kolom sesuai pengaturan kita */
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            /* word-wrap: break-word; */
            /* Mencegah teks panjang mendorong tabel ke kanan */
        }

        .company-title {
            text-align: center;
            font-weight: bold;
            font-size: 20px;
        }

        .content-center {
            text-align: center;
        }

        /* 3. Pengaturan Khusus Saat Dicetak */
        @media print {

            /* Trik untuk menghilangkan Header & Footer otomatis browser */
            @page {
                margin: 0;
                /* Menghilangkan teks otomatis di pinggir kertas */
            }

            body {
                /* Berikan margin manual di body agar konten tidak mepet ke pinggir kertas fisik */
                margin: 1.5cm;
            }

            .no-print {
                display: none;
            }

            /* Pastikan container tabel kamu tetap rapi */
            .table-container {
                width: 100%;
                border: 1px solid #000 !important;
            }

            .logo-cell {
                width: 15%;
                align-items: center;
                border-bottom: 2px solid #000;
            }

            .form-info {
                width: 20%;
                border-bottom: 2px solid #000;
            }

            .company-title {
                font-size: 14px;
                border-bottom: 2px solid #000;
            }
        }
    </style>
</head>

<body>
    <div class="table-container">
        <!-- header -->
        <table>
            <tr>
                <td rowspan="3" width="5%" class="logo-cell" align="center" style="border-right: 2px solid #000;">
                    <img src="{{ asset('storage/logo.png') }}" alt="logo" style="width: 60px;">
                </td>
                <td rowspan="3" class="company-title">
                    PT Schlemmer Automotive Indonesia<br>
                    Purchase Requisition
                </td>
                <td class="form-info" width="15%" style="border-left: 2px solid #000;">表格编号 No: 07-05-07-01</td>
            </tr>
            <tr>
                <td class="form-info" style="border-left: 2px solid #000;">Form No.</td>
            </tr>
            <tr>
                <td class="form-info" style="border-left: 2px solid #000;">版本号 Revision No: 1.0</td>
            </tr>
        </table>

        <!-- Information -->
        <table>
            <tr style="height: 50px;">
                <td width="20%" style="border-right:none;" class="header-bg">Department : <br><br> {{ $record->department?->name }}</td>
                <td width="20%" style="border-left:none; border-right:none;" class="header-bg">Requested By : <br><br> {{ $record->requestor?->name }}</td>
                <td width="20%" style="border-left:none; border-right:none;" class="header-bg">Date : <br><br> {{ $record->doc_date?->format('d-M-Y') }}</td>
                <td width="40%" style="border-left:none; text-align:right;" class="header-bg">Purchase Requisition No. : <br>
                    <h3>{{ $record->code }}</h3>
                </td>
            </tr>
            <tr style="height: 50px;">
                <td colspan="4">
                    Reason:<br><br>
                    {{ $record->reason }}
                </td>

                <!-- <td style="border-right:none;" class="header-bg">Reason : </td> -->
                <!-- <td>{{ $record->reason }}</td> -->
            </tr>
        </table>

        <!-- Details -->
        <table>
            <tr class="header-bg" style="text-align: center; font-weight: bold;">
                <td width="5%">No.</td>
                <td width="15%">Material Code</td>
                <td width="10%">Material Name</td>
                <td width="20%">Specification</td>
                <td width="6%">Unit</td>
                <td width="6%">Qty</td>
                <td width="10%">Arrival Date</td>
                <td width="10%">Suggested Supplier</td>
                <td width="15%">Remarks</td>
            </tr>
            @foreach($record->details as $index => $item)
            <tr>
                <td class="content-center">{{ $index + 1 }}</td>
                <td>{{ $item->material?->code }}</td>
                <td>{{ $item->material?->name }}</td>
                <td>{{ $item->material?->specification }}</td>
                <td class="content-center">{{ $item->units?->code }}</td>
                <td class="content-center">{{ number_format($item->qty) }}</td>
                <td class="content-center" align="center">{{ date("d-M-Y", strtotime($item?->arrival_date)) }}</td>
                <td>{{ $item->supplier?->name }}</td>
                <td>{{ $item->remark }}</td>
            </tr>
            @endforeach
            <!-- Padding baris kosong jika perlu -->
            @for ($i = count($record->details); $i <10; $i++)
                <tr>
                <td style="color: white;">.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                @endfor
        </table>

        <!-- Footer / Approval Section -->
        <table style="border-top: none;">
            <tr style="height: 60px; vertical-align: top;">
                <td valign="top" width="33%">
                    Prepared By:
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    {{ $record->requestor?->name }}
                    Date:
                </td>
                <td valign="top" width="34%">Checked By:
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    Date:
                </td>
                <td valign="top" width="33%">Approved By:
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    Date:
                </td>
            </tr>
        </table>
    </div>
    <div class="no-print" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Print Document</button>
    </div>
</body>

</html>
