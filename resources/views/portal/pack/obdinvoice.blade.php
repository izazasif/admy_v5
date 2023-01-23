<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>A simple, clean, and responsive HTML invoice template</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path('assets/images/top-logo-new.png') }}"
                                    style="width: 100%; max-width: 300px" />
                            </td>

                            <td>
                                Invoice #: OBD_{{ $data->invoice }}<br />
                                Created: {{ date('d-m-Y', strtotime($data->created)) }}<br />
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Road # 19/A, House # 8<br />
                                Banani, Dhaka-1213<br />
                                +88 0187 2634 967
                            </td>

                            <td>
                                {{ $data->uname }}<br />
                                {{ $data->mobile }}<br />
                                {{ $data->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>

                <td>OBD Credit</td>
            </tr>

            <tr class="item">
                <td>{{ $data->name }} </td>

                <td>{{ number_format($data->amount) }}</td>
            </tr>
            <tr class="heading">
                <td>Payment Method(bKash)</td>

                <td>Amount(BDT)</td>
            </tr>
            <tr class="">
                <td>Price</td>

                <td>{{ number_format($data->price) }}BDT</td>
            </tr>
            <tr class="">
                <td>Vat(0%)</td>

                <td>0BDT</td>
            </tr>
            <tr class="">
                <td>bKash Charge(0%)</td>

                <td>0BDT</td>
            </tr>

            <tr class="total">
                <td></td>

                <td>Total: {{ number_format($data->price) }}BDT</td>
            </tr>
        </table>
        <p style="font-size: 10px;">*Validity: {{ $data->validity }} Days & Valid Till
            {{ date('d-m-Y h:i A', strtotime($data->validTill)) }}</p>
    </div>
</body>

</html>
