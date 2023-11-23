<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $purchaseOrder->purchase_no }}</title>
    <style>
        body{
            font-family:Arial, Helvetica, sans-serif;
        }
        .container{
            margin: 0 auto;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .bio td{
            vertical-align: top;
        }
        .p-1{
            padding:5px;
        }
        .fs-5{
            font-size: 0.8rem;
        }
        .page-break{
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <table class="bio" border="2" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="20%" class="text-center"><img src="{{ Helper::imgToBase64(public_path('assets/img/a.webp')) }}" style="width:70px;display:inline-block;" alt=""></td>
                <td width="60%" colspan="2" class="text-center"><h2>Purchase Order</h2></td>
                <td width="20%"></td>
            </tr>
            <tr>
                <td colspan="2" width="100%" style="border-right-style:hidden;padding:10px">
                    <table class="bio" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td class="p-1" width="20%">Office</td>
                            <td class="p-1" width="2%">:</td>
                            <td class="p-1">{{ $purchaseOrder->branch->detail }}</td>
                        </tr>
                        <tr>
                            <td class="p-1" width="20%">NPWP</td>
                            <td class="p-1" width="2%">:</td>
                            <td class="p-1">02.192.595.3-005.000</td>
                        </tr>
                    </table>
                </td>
                <td colspan="2" width="50%" border="0" style="border-left-style:hidden;padding:10px;">
                    <table class="bio" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td class="p-1">Date</td>
                            <td class="p-1" width="2%">:</td>
                            <td class="p-1">{{ date('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td class="p-1">No</td>
                            <td class="p-1" width="2%">:</td>
                            <td class="p-1">{{ $purchaseOrder->purchase_no }}</td>
                        </tr>
                        <tr>
                            <td class="p-1">To</td>
                            <td class="p-1" width="2%">:</td>
                            <td class="p-1">JNE <br> Jakarta</td>
                        </tr>
                        <tr>
                            <td class="p-1">Due Date</td>
                            <td class="p-1" width="2%">:</td>
                            <td class="p-1">3 hari</td>
                        </tr>
                        <tr>
                            <td class="p-1">Project</td>
                            <td class="p-1" width="2%">:</td>
                            <td class="p-1">{{ $purchaseOrder->project_name }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border-style=none;">
                    <table border="2" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <th>No</th>
                            <th>DESCRIPTION</th>
                            <th>QTY</th>
                            <th>UOM</th>
                            <th>UNIT PRICE</th>
                            <th>AMOUNT</th>
                        </tr>
                        @php
                            $page = 1;
                            $i = 1;
                            $total = 0;
                        @endphp
                        @foreach ($purchaseOrder->details as $item)
                            <tr class="{{ $loop->iteration % 20 == 0 ? 'page-break' : '' }}">
                                <td class="p-1 text-center">{{ $loop->iteration }}</td>
                                <td class="p-1">{{ $item->item->name }}</td>
                                <td class="p-1 text-center">{{ $item->qty }}</td>
                                <td class="p-1 text-center">{{ $item->item->unit->name }}</td>
                                <td class="p-1 text-right">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="p-1 text-right">Rp. {{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                            </tr>
                            @php
                                $i++;
                                $total += $item->qty * $item->price;
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="4" style="border-bottom-style:none;"></td>
                            <td class="p-1">Total</td>
                            <td class="p-1 text-right">Rp. {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                        @if ($disc !== 0)

                            <tr>
                                <td colspan="4" style="border-bottom-style:none;border-top-style:none;"></td>
                                <td class="p-1">Disc {{ $disc }}%</td>
                                <td class="p-1 text-right">Rp. {{ number_format($total*$disc/100, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-top-style:none;"></td>
                                <td class="p-1">Subtotal</td>
                                <td class="p-1 text-right">Rp. {{ number_format($total - ($total*$disc/100), 0, ',', '.') }}</td>
                            </tr>

                        @endif
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table border="0" width="100%">
                        <tr>
                            <td width="5%"></td>
                            <td>
                                Delivery Point : <br>{{ $purchaseOrder->branch->name }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div style="width:30%;text-align:center;display:inline-block;margin-top:50px;">
                        <div>Dipesan oleh</div>
                        <div style="height: 80px">
                            <img src="{{ Helper::imgToBase64('storage/'.$purchaseOrder->created_by_user->ttd) }}" style="width:100%;display:inline-block;max-height:80px" alt="">
                        </div>
                        <div style="visibility:{{ $purchaseOrder->created_by ? 'visible' : 'hidden' }};">{{ $purchaseOrder->created_by ? $purchaseOrder->created_by_user->name : 'null' }}</div>
                        <div style="visibility:{{ $purchaseOrder->created_by ? 'visible' : 'hidden' }};" class="fs-5">{{ $purchaseOrder->created_by ? $purchaseOrder->created_by_user->role->name : 'null' }}</div>
                    </div>
                    <div style="width:30%;text-align:center;display:inline-block;margin-top:50px;">
                        <div>Diperiksa oleh</div>
                        <div style="height: 80px">
                            @if ($purchaseOrder->known_by)
                            <img src="{{ Helper::imgToBase64('storage/'.$purchaseOrder->known_by_user->ttd) }}" style="width:100%;display:inline-block;max-height:80px" alt="">
                            @endif
                        </div>
                        <div style="visibility:{{ $purchaseOrder->known_by ? 'visible' : 'hidden' }};">{{ $purchaseOrder->known_by ? $purchaseOrder->known_by_user->name : 'null' }}</div>
                        <div style="visibility:{{ $purchaseOrder->known_by ? 'visible' : 'hidden' }};" class="fs-5">{{ $purchaseOrder->known_by ? $purchaseOrder->known_by_user->role->name : 'null' }}</div>
                    </div>
                    <div style="width:30%;text-align:center;display:inline-block;margin-top:10px;float:right">
                        <div>Mengetahui</div>
                        <div style="height: 80px">
                            @if ($purchaseOrder->approved_by)
                            <img src="{{ Helper::imgToBase64('storage/'.$purchaseOrder->approved_by_user->ttd) }}" style="width:100%;display:inline-block;max-height:80px" alt="">
                            @endif
                        </div>
                        <div style="visibility:{{ $purchaseOrder->approved_by ? 'visible' : 'hidden' }};">{{ $purchaseOrder->approved_by ? $purchaseOrder->approved_by_user->name : 'null' }}</div>
                        <div style="visibility:{{ $purchaseOrder->approved_by ? 'visible' : 'hidden' }};" class="fs-5">{{ $purchaseOrder->approved_by ? $purchaseOrder->approved_by_user->role->name : 'null' }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
