<html>
    <head>
        <style>
            .table, .table thead, .table tbody, .table thead tr, .table thead tr th, .table tbody tr, .table tbody tr td {
                width: 100%;
                border: 1px solid #000;
                border-collapse: collapse;
            }

            .indent-text {
                border: none;
                padding: 0px;
                margin: 0px;
                padding-left: 30px;
            }

            .signatory {
                display: inline-block;
                padding: 50px;
                width: 200px;
            }

            .text-bottom-border {
                border-bottom: 1px solid #000;
                width: 200px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div style="text-align: center;">
            <b>H100 ECOLODGE RESTOREANT</b>
            <br><br>
            <div style="border: 1px solid #000;"><p>EXPENSE REPORT SUMMARY</p></div>
            <br>
        </div>
        <span style="text-align: left;"><b>Date: </b><u>{{ \Carbon\Carbon::now()->format('Y-m-d') }}</u></span>
        <br><br>
        <table class="table">
            <thead>
                <tr>
                    <th width="30">ACCOUNT CODE</th>
                    <th width="50">ACCOUNT DESCRIPTION</th>
                    <th width="20">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalAmt = 0;
                @endphp
                @foreach($expense_accounts as $account)
                    <tr>
                        <td style="text-align: center;">{{ $account['accountCode'] }}</td>
                        <td>
                            {{ $account['accountDesc'] }}<br>
                            @if($account['accountCode'] == '' || is_null($account['accountCode']))
                                @foreach($account['expenseDesc'] as $expenseDesc)
                                    <p class="indent-text">{{ $expenseDesc }}</p>
                                @endforeach
                            @endif
                        </td>
                        <td style="text-align: right; vertical-align: top;">{{ number_format(floatval($account['amount']), 2) }}</td>
                    </tr>
                    @php
                        $totalAmt += floatval($account['amount']);
                    @endphp
                @endforeach
            </tbody>
        </table>
        <br>
        <div>
            <b style="display: inline-block; float: left;">TOTAL EXPENSES (REPLENISH/REIMBURSE)</b>
            <u style="display: inline-block; float: right;">P {{ number_format($totalAmt, 2) }}</u>
        </div>
        <br>
        <div class="signatory" style="float: left;">
            <p>Prepared by:</p><br>
            <p class="text-bottom-border">{{ $preparedBy }}</p>
        </div>
        <div class="signatory" style="float: right;">
            <p>Reviewed by:</p><br>
            <p class="text-bottom-border">{{ $reviewedBy }}</p>
        </div>
    </body>
</html>