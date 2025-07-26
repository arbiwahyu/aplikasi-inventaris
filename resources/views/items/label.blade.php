<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Label - {{ $item->name }}</title>
    <style>
        @page {
            margin: 0.5cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            text-align: center;
        }

        .label-container {
            border: 1px solid #000;
            padding: 10px;
            display: inline-block;
            min-width: 200px;
            text-align: center;
        }

        .item-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .barcode-wrapper {
            display: inline-block;
            /* Membuat div ini bisa di-center */
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .item-code {
            font-size: 12px;
            letter-spacing: 3px;
            margin-top: 6px;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>

<body>
    <div class="label-container">
        <div class="item-name">{{ $item->name }}</div>

        {{-- Ini bagian yang men-generate QR Code --}}
        <div class="barcode-wrapper">
            {!! DNS2D::getBarcodeHTML($item->item_code, 'QRCODE', 5, 5) !!}
        </div>

        <div class="item-code">{{ $item->item_code }}</div>
    </div>
</body>

</html>
