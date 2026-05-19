<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Purchase Order | {{ $record->code }}</title>
    <link rel="icon" href="{{ asset('storage/favicon.png') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* 1. Aturan Global agar perhitungan lebar presisi */
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 9.5pt;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            /* Ubah ke 100% agar memenuhi container cetak */
            border-collapse: collapse;
            margin-bottom: 8px;
            table-layout: fixed;
        }

        .header-table td {
            vertical-align: top;
        }

        .company-group {
            font-size: 9pt;
            font-weight: bold;
            color: #444;
            margin: 0;
        }

        .company-title {
            font-size: 13pt;
            font-weight: bold;
            margin: 0;
        }

        .company-address {
            font-size: 7.5pt;
            color: #000;
            margin: 2px 0;
            line-height: 1.4;
        }

        .po-title {
            font-size: 15pt;
            font-weight: bold;
            text-align: right;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .info-grid {
            margin-top: 10px;
        }

        .info-box {
            border: 1px solid #000;
            padding: 5px;
            font-size: 8.5pt;
            min-height: 85px;
            vertical-align: top;
            word-wrap: break-word;
            word-break: normal;
            overflow: hidden;
        }

        .info-title {
            font-weight: bold;
            border-bottom: 1px solid #000;
            margin-bottom: 4px;
            padding-bottom: 2px;
            font-size: 8pt;
        }

        .items-table {
            margin-top: 12px;
        }

        .items-table th {
            border: 1px solid #000;
            padding: 5px 3px;
            font-size: 8pt;
            font-weight: bold;
            text-align: center;
            background-color: #f5f5f5;
        }

        .items-table td {
            border: 1px solid #000;
            padding: 5px 4px;
            font-size: 8.5pt;
            vertical-align: top;
            word-wrap: break-word;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-section td {
            padding: 4px;
            font-size: 9pt;
        }

        .terbilang-box {
            font-style: italic;
            font-size: 8.5pt;
            padding-top: 2px;
        }

        .terms-section {
            font-size: 7.5pt;
            line-height: 1.4;
            margin-top: 10px;
        }

        .signature-section {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .signature-table td {
            border: 1px solid #000;
            text-align: center;
            font-size: 8pt;
            vertical-align: top;
            width: 25%;
        }

        .signature-title {
            border-bottom: 1px solid #000;
            padding: 2px;
            font-weight: bold;
        }

        .signature-space {
            height: 55px;
        }

        .signature-date {
            font-size: 7.5pt;
            padding: 2px;
            text-align: left;
        }

        /* ================= SOLUSI KEPOTONG PAS PRINT ================= */
        @media print {
            @page {
                size: A4 portrait;
                /* Gunakan margin minimal bawaan browser agar area cetak maksimal & tidak memotong header atas */
                margin: 8mm;
            }

            body {
                /* Reset semua margin body agar mengikuti setingan ukuran printable area dari @page */
                /* margin: 0;
                padding: 0;
                width: 100%;
                -webkit-print-color-adjust: exact; */
                padding-top: 12mm;
                padding-bottom: 12mm;
                padding-left: 2mm;
                padding-right: 2mm;

                margin: 0;
                width: 100%;
                -webkit-print-color-adjust: exact;
            }

            /* Memastikan tabel utama tidak meluber melewati batas kanan kertas */
            .header-table,
            .info-grid,
            .items-table,
            .terms-section,
            .signature-section {
                width: 100% !important;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <!-- <button onclick="window.print()" style="padding: 6px 14px; background: #000; color: white; border: 1px solid #000; cursor: pointer; font-weight: bold; font-size: 9pt;">
            PRINT DOCUMENT
        </button> -->

        <button type="button"
            id="btnPrintDoc"
            data-url="{{ route('purchase-orders.increment-print', $record) }}"
            style="padding: 6px 14px; background: #000; color: white; border: 1px solid #000; cursor: pointer; font-weight: bold; font-size: 9pt;">
            PRINT DOCUMENT
        </button>
    </div>

    <table class="header-table" style="border-bottom: 2px solid #000; width: 99%; margin: 0 auto; table-layout: fixed;">
        <tr>
            <td style="width: 25%; vertical-align: middle; border: none; padding: 5px;">
                <img src="{{ asset('storage/logo_panjang.png') }}" alt="logo" style="width: 100%; max-width: 180px; display: block;">
            </td>
            <td style="width: 75%; vertical-align: middle; text-align: right; border: none; padding: 5px;">
                <div style="font-size: 14pt; font-weight: bold; line-height: 1.2; color: #000;">
                    PT. Schlemmer Automotive Indonesia
                </div>
                <div class="company-address" style="font-size: 7.5pt; color: #000; margin-top: 3px; line-height: 1.4;">
                    Manufacture: Kawasan Industri Delta Silicon 3, Jl. Johar, Blok F8 No.6, Desa Cicau, Kec. Cikarang Pusat, Kab. Bekasi<br>
                    Phone : (021) 9891-3741
                </div>
            </td>
        </tr>
    </table>

    <table class="info-grid" cellspacing="0" cellpadding="0">
        <tr>
            <td class="info-box" style="width: 50%;">
                <div class="info-title" style="font-weight: bold;">PURCHASE ORDER</div><br>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    Purchase Order No. : {{ $record->code }}<br>
                    Revision No. : 0<br>
                    Order Date : {{ \Carbon\Carbon::parse($record->doc_date)->format('d/M/Y') }}<br>
                </span>
            </td>
            <td style="width: 1%;"></td>
            <td class="info-box" style="width: 49%;">
                <div class="info-title">Supplier:</div>
                <strong>{{ $record->supplier?->name }}</strong><br>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    {{ $record->supplier?->address }}<br>
                </span>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    {{ $record->supplier?->phone }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="height: 5px;" colspan="3"></td>
        </tr>
        <tr>
            <td class="info-box" style="width: 50%">
                <div class="info-title">Ship To :</div>
                @if (blank($record->shipping_address))
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    <strong>PT. Schlemmer Automotive Indonesia</strong>
                </span><br>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    Kawasan Industri Delta Silicon 3, Jl. Johar, Blok F8 No.6
                </span><br>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    Desa Cicau, Kec. Cikarang Pusat, Kab. Bekasi
                </span><br>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    Jawa Barat, 17530
                </span><br>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    Indonesia
                </span>
                @else
                <span style="font-size: 7.5pt; line-height: 1.3; white-space: pre-wrap;">
                    {!! nl2br(e($record->shipping_address)) !!}
                </span>
                @endif
            </td>
            <td style="width: 1%"></td>
            <td class="info-box" style="width: 49%;">
                <div class="info-title">Invoice To :</div>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    <strong>PT. Schlemmer Automotive Indonesia</strong>
                </span><br>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    Kawasan Industri Delta Silicon 3, Jl. Johar, Blok F8 No.6
                </span><br>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    Desa Cicau, Kec. Cikarang Pusat, Kab. Bekasi
                </span><br>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    Jawa Barat, 17530
                </span><br>
                <span style="font-size: 7.5pt; line-height: 1.3;">
                    Indonesia
                </span>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 4%;">No.</th>
                <th style="width: 15%;">Name</th>
                <th style="width: 15%;">Description</th>
                <th style="width: 12%;">Date Promised</th>
                <th style="width: 5%;">Qty</th>
                <th style="width: 5%;">Units</th>
                <th style="width: 15%;">Unit Price</th>
                <th style="width: 15%;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($record->details as $index => $detail)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $detail->material_name ?? ($detail->material?->name) }}</strong><br>
                    <span style="font-size: 7.5pt; color: #333;">{!! nl2br(e($detail->remark)) !!}</span>
                </td>
                <td style="font-size: 8pt;">
                    {{ $detail->material?->specification }}
                </td>
                <td class="text-center" style="font-size: 8pt;">
                    {{ $detail->delivery_date ? \Carbon\Carbon::parse($detail->delivery_date)->format('d/M/Y') : '' }}
                </td>
                <td class="text-right">
                    {{ number_format($detail->qty, 0) }}
                </td>
                <td class="text-center">
                    {{ $detail->units?->code }}
                </td>
                <td class="text-right">
                    <div style="display: flex; justify-content: space-between; width: 100%;">
                        <span>{{ $record->currency?->symbol }}</span>
                        <span>{{ number_format($detail->unit_price, 0) }}</span>
                    </div>
                </td>
                <td class="text-right">
                    <div style="display: flex; justify-content: space-between; width: 100%;">
                        <span>{{ $record->currency?->symbol }}</span>
                        <span>{{ number_format($detail->amount, 0) }}</span>
                    </div>
                </td>
            </tr>
            @endforeach

            @for ($i = count($record->details); $i < 10; $i++)
                <tr>
                <td style="color: white;">.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                @endfor

                <tr style="border-top: 2px solid #000;">
                    <td colspan="5" rowspan="4" style="border: 1px solid #000; padding: 5px; vertical-align: top;">
                        <div style="font-size: 7.5pt; font-weight: bold;">Terbilang / Say:</div>
                        <div class="terbilang-box">
                            {{ ucwords(terbilang($record->total_amount)) }} Rupiah
                        </div>
                    </td>
                    <td colspan="2" style="border: 1px solid #000; font-size: 8pt; font-weight: bold;" class="text-right">Total</td>
                    <td style="border: 1px solid #000; font-weight: bold;" class="text-right">
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <span>{{ $record->currency?->symbol }}</span>
                            <span>{{ number_format($record->amount, 0) }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 1px solid #000; font-size: 8pt; font-weight: bold;" class="text-right">
                        Discount ({{ ($record->total_discount / $record->amount) * 100 }} %)
                    </td>
                    <td style="border: 1px solid #000;" class="text-right">
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <span>{{ $record->currency?->symbol }}</span>
                            <span>{{ number_format($record->total_discount, 0) }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 1px solid #000; font-size: 8pt; font-weight: bold;" class="text-right">
                        VAT ({{ round(($record->tax_amount / ($record->amount - $record->total_discount)) * 100) }} %)
                    </td>
                    <td style="border: 1px solid #000;" class="text-right">
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <span>{{ $record->currency?->symbol }}</span>
                            <span>{{ number_format($record->tax_amount, 0) }}</span>
                        </div>
                    </td>
                </tr>
                <tr style="background-color: #f9f9f9; font-weight: bold;">
                    <td colspan="2" style="border: 1px solid #000; font-size: 8.5pt;" class="text-right">Grand Total</td>
                    <td style="border: 1px solid #000; font-size: 8.5pt;" class="text-right">
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <span>{{ $record->currency?->symbol }}</span>
                            <span>{{ number_format($record->total_amount, 0) }}</span>
                        </div>
                    </td>
                </tr>
        </tbody>
    </table>

    <table class="terms-section">
        <tr>
            <td style="width: 60%; vertical-align: top;">
                <strong>Exchange Rate:</strong> Rp {{ number_format($record->exchange_rate, 0) ?? '1' }}<br>
                <strong>Term Of Payment:</strong> {{ $record->term_of_payment ?? '30 days from Invoice received' }}<br>
                <strong>Remarks:</strong> {{ nl2br(e($record->remark)) }}<br><br>
                <div style="font-size: 7pt; line-height: 1.3; color: #111;">
                    * PO Number must be listed in all invoices, street letters and Letters relating to this PO<br>
                    * Street mail and Invoice Tax must be sent 3 sheets (1 original, 2 copies)<br>
                    * Exchange invoices every Tuesday Wednesday Thursday (09:00 am to 11:00 am) -Received receipt <br>
                    * <strong>Note:</strong> This electronic document is already valid evidence as a Purchase Order
                </div>
            </td>
        </tr>
    </table>

    <div class="signature-section">
        <table class="signature-table" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <div class="signature-title">Dibuat (Prepared By):</div>
                    <div class="signature-space"></div>
                    <div style="font-weight: bold; border-bottom: 1px solid #000; margin: 0 5px;">Purchasing Staff</div>
                    <div class="signature-date">Date: </div>
                </td>
                <td>
                    <div class="signature-title">Diperiksa (Checked By):</div>
                    <div class="signature-space"></div>
                    <div style="font-weight: bold; border-bottom: 1px solid #000; margin: 0 5px;">Purchasing Supervisor</div>
                    <div class="signature-date">Date: </div>
                </td>
                <td>
                    <div class="signature-title">Disetujui (Approved By):</div>
                    <div class="signature-space"></div>
                    <div style="font-weight: bold; border-bottom: 1px solid #000; margin: 0 5px;">Purchasing Manager</div>
                    <div class="signature-date">Date: </div>
                </td>
                <td style="background-color: #fafafa;">
                    <div class="signature-title" style="border-bottom: 1px dashed #000;">Supplier Approved</div>
                    <div class="signature-space" style="height: 40px;"></div>
                    <div style="font-size: 7.5pt; color: #444; font-style: italic; padding: 0 2px;">
                        Note: This column must be approved by Supplier
                    </div>
                    <div class="signature-date" style="border-top: 1px solid #000; margin-top: 5px;">
                        Signature:<br>
                        Date:
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="vertical-align: bottom; text-align: right; font-size: 7.5pt; font-style: italic; padding-right: 10px;">
                    Date of Print: {{ now()->format('d/m/Y') }}
                </td>
            </tr>
        </table>
    </div>

</body>

</html>

<script>
    document.getElementById('btnPrintDoc').addEventListener('click', function() {
        // Ambil URL dengan aman dari data attribute tanpa takut bentrok tanda kutip
        let url = this.getAttribute('data-url');

        // Jalankan fungsi fetch/print yang sudah kita buat kemarin
        handlePrint(url);
    });

    function handlePrint(url) {
        fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.print();
                }
            })
            .catch(error => {
                console.error('Error updating print count:', error);
                window.print(); // Fallback tetap print jika hit log error
            });
    }
</script>
