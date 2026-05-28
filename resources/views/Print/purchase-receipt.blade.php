<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Purchase Receipt - {{ $record->code ?? '' }}</title>
    <link rel="icon" href="{{ asset('storage/favicon.png') }}" type="image/x-icon">
    <style>
        /* --- SYSTEM BOX MODEL --- */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            font-family: 'Arial', 'Helvetica', 'SimSun', sans-serif;
            color: #000000;
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 10pt;
            background-color: #ffffff;
        }

        /* --- SCREEN VIEW (Tampilan di Monitor) --- */
        @media screen {
            body {
                background-color: #e5e7eb;
                /* Background abu-abu soft */
                padding: 30px 0;
            }

            .page-container {
                background: #ffffff;
                width: 210mm;
                /* Lebar A4 */
                height: 297mm;
                /* Tinggi A4 */
                margin: 0px auto 25px auto;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                /* Efek kertas melayang */
                border-radius: 4px;
                padding: 15mm 12mm;
                position: relative;
            }
        }

        /* --- PRINT VIEW (Tampilan saat di-Print / PDF) --- */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
                /* PENTING: Menghilangkan URL, Tanggal, dan Judul bawaan browser */
            }

            body {
                background-color: #ffffff;
                margin: 0;
                padding: 0;
                width: 100%;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* Sembunyikan semua elemen yang memiliki class no-print */
            .no-print {
                display: none !important;
            }

            .page-container {
                width: 210mm;
                height: 297mm;
                page-break-after: always;
                /* Gunakan padding internal agar isi tabel tidak mepet ke ujung kertas fisik */
                padding: 15mm 12mm !important;
                position: relative;
                overflow: hidden;
                background: #ffffff !important;
                box-shadow: none !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }

            .page-container:last-child {
                page-break-after: avoid;
            }
        }

        /* --- LAYOUT COMPONENT STYLING --- */
        .page-container {
            position: relative;
            width: 100%;
            height: 270mm;
            overflow: hidden;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .header-table td {
            border: 2px solid #000000;
            padding: 6px;
            vertical-align: middle;
        }

        .logo-box {
            width: 15%;
            text-align: center;
        }

        .title-box {
            width: 60%;
            text-align: center;
        }

        .title-cn {
            font-size: 20pt;
            font-weight: bold;
            letter-spacing: 4px;
            margin: 0;
        }

        .title-en {
            font-size: 16pt;
            font-weight: bold;
            margin: 2px 0 0 0;
        }

        .meta-box {
            width: 25%;
            font-size: 8.5pt;
            line-height: 1.4;
        }

        .profile-table {
            width: 100%;
            border: 2px solid #000;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
            min-height: 150px;
        }

        .profile-table td {
            border: 1px solid #000000;
            padding: 6px 8px;
            font-size: 9.5pt;
            vertical-align: middle;
        }

        .label-cell {
            font-size: 9pt;
            text-align: left;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .items-table th {
            border: 1px solid #000000;
            background-color: #ffffff;
            font-weight: bold;
            font-size: 8.5pt;
            text-align: center;
            padding: 4px 2px;
            height: 35px;
            vertical-align: middle;
            line-height: 1.2;
        }

        .items-table td {
            border: 1px solid #000000;
            padding: 4px 6px;
            font-size: 9pt;
            height: 38px;
            /* Mengunci tinggi baris */
            vertical-align: middle;
            word-wrap: break-word;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .footer-container {
            position: absolute;
            bottom: 15mm;
            left: 12mm;
            right: 12mm;
            width: calc(100% - 24mm);
            font-size: 11pt;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            border: none;
            width: 50%;
            padding: 5px;
        }

        .page-counter {
            position: absolute;
            bottom: -5mm;
            right: 0;
            font-size: 8pt;
        }
    </style>
</head>

<body>

    @php
    // Memecah koleksi item menjadi beberapa bagian (10 item per halaman)
    $detailsCollection = collect($record->details ?? []);
    $chunks = $detailsCollection->chunk(12);

    if($chunks->isEmpty()) {
    $chunks = collect([collect([])]);
    }

    $totalPages = $chunks->count();
    @endphp

    @foreach($chunks as $pageIndex => $items)
    <div class="page-container">

        <table class="header-table">
            <tr>
                <td class="logo-box" align="center">
                    <img src="{{ asset('storage/logo_panjang.png') }}" alt="logo" style="width: 100%; display: block;">
                </td>
                <td class="title-box">
                    <div class="title-cn">外购入库单</div>
                    <div class="title-en">Purchase Receipt</div>
                </td>
                <td class="meta-box">
                    <div><strong>Form No.:</strong> </div>
                    <div><strong>Ver.:</strong> </div>
                </td>
            </tr>
        </table>

        <table class="profile-table">
            <tr>
                <td class="label-cell" style="width: 12%;">Supplier</td>
                <td style="width: 43%; font-weight: bold;">{{ $record->supplier->name ?? '' }}</td>
                <td class="label-cell" style="width: 12%;">Document No.</td>
                <td style="width: 33%; font-family: monospace; font-size: 11pt; font-weight: bold;">{{ $record->code ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Receive Date</td>
                <td>{{ \Carbon\Carbon::parse($record->received_date)->format('Y-m-d') }}</td>
                <td class="label-cell">Biz.Rep.</td>
                <td></td>
            </tr>
            <tr>
                <td class="label-cell">Remark</td>
                <td colspan="3">{{ $record->remark }}</td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 4%;">No.</th>
                    <th style="width: 14%;">Material Code</th>
                    <th style="width: 16%;">Material Name</th>
                    <th style="width: 29%;">Specification</th>
                    <th style="width: 5%;">Unit</th>
                    <th style="width: 10%;">Received Qty</th>
                    <th style="width: 22%;">Remark</th>
                </tr>
            </thead>
            <tbody>
                {{-- 1. Mengisi Data Real --}}
                @foreach($items as $currentIndex => $item)
                <tr>
                    <td class="text-center">{{ ($pageIndex * 10) + $currentIndex + 1 }}</td>
                    <td class="text-left" style="font-size: 8pt; font-family: monospace;">{{ $item->material?->code }}</td>
                    <td class="text-left" style="font-size: 8.5pt;">{{ $item->material?->name }}</td>
                    <td class="text-left" style="font-size: 8pt;">{{ $item->material?->specification }}</td>
                    <td class="text-center">{{ $item->units?->code }}</td>
                    <td class="text-right" style="font-weight: bold;">{{ number_format($item->qty_received, 2) }}</td>
                    <td class="text-left" style="font-size: 8pt;">{{ $item->remark }}</td>
                </tr>
                @endforeach

                {{-- 2. Baris Kosong Penyeimbang (Sesuai jumlah kekurangan) --}}
                @for($i = count($items); $i < 12; $i++)
                    <tr>
                    <td class="text-center">{{ ($pageIndex * 12) + $i + 1 }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                    @endfor
            </tbody>
        </table>

        <div class="footer-container">
            <table class="footer-table">
                <tr>
                    <td align="left" style="vertical-align: top;">
                        <strong>Receiver：</strong><br>
                        <span style="font-size: 10pt; padding-left: 10px;">{{ $record->creator?->name ?? '' }}</span><br>
                        <span style="font-size: 9pt; padding-left: 10px; color: #4b5563;">{{ $record->created_at ?? '' }}</span>
                    </td>
                    <td align="right" style="vertical-align: top;">
                        <strong style="float: left; padding-left: 100px;">Approver：</strong><br>
                        <span style="font-size: 10.5pt; padding-right: 30px;">{{ $record->approved_by ?? '____________________' }}</span>
                    </td>
                </tr>
            </table>

            <div class="page-counter">
                Page {{ $pageIndex + 1 }} of {{ $totalPages }}
            </div>
        </div>

    </div>
    @endforeach
    <div class="no-print" style="text-align: right; max-width: 210mm; margin: 0 auto 10px auto;">
        <button type="button"
            id="btnPrintDoc"
            data-url="{{ route('purchase-receipt.increment-print', $record) }}"
            style="
                padding: 8px 18px;
                background: #000000;
                color: #ffffff;
                border: 1px solid #000000;
                cursor: pointer;
                font-weight: bold;
                font-size: 9.5pt;
                border-radius: 4px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            ">
            PRINT DOCUMENT
        </button>
    </div>
</body>

<script>
    document.getElementById('btnPrintDoc').addEventListener('click', function() {
        let url = this.getAttribute('data-url');
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
                window.print(); // Fallback tetap mencetak dokumen jika hit API bermasalah
            });
    }
</script>

</html>