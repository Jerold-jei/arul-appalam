<div style="width:410px;">
    <div class="text-center pt-4 mb-3">
        <h2 style="line-height: 1">{{\App\Model\BusinessSetting::where(['key'=>'restaurant_name'])->first()->value}}</h2>
        <h5 style="font-size: 20px;font-weight: lighter;line-height: 1">
            {{\App\Model\BusinessSetting::where(['key'=>'address'])->first()->value}}
        </h5>
        <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
            {{\App\CentralLogics\translate('Phone')}}
            : {{\App\Model\BusinessSetting::where(['key'=>'phone'])->first()->value}}
        </h5>
    </div>

    <span>---------------------------------------------------------------------------------</span>
    <div class="row mt-3">
        <div class="col-6">
            <h5>{{\App\CentralLogics\translate('lorem')}} : {{$order['id']}}</h5>
        </div>
        <div class="col-6">
            <h5 style="font-weight: lighter">
                {{date('d/M/Y h:i a',strtotime($order['created_at']))}}
            </h5>
        </div>
        @if($order->customer)
            <div class="col-12">
                <h5>{{\App\CentralLogics\translate('Customer Name')}} : {{$order->customer['f_name'].' '.$order->customer['l_name']}}</h5>
                <h5>{{\App\CentralLogics\translate('Phone')}} : {{$order->customer['phone']}}</h5>
                <h5>
                    {{\App\CentralLogics\translate('Address')}}
                    : {{isset($order->delivery_address)?json_decode($order->delivery_address, true)['address']:''}}
                </h5>
            </div>
        @endif
    </div>
    <h5 class="text-uppercase"></h5>
    <span>---------------------------------------------------------------------------------</span>
    <table class="table table-bordered mt-3" style="width: 98%">
        <thead>
        <tr>
            <th style="width: 10%">{{\App\CentralLogics\translate('QTY')}}</th>
            <th class="">{{\App\CentralLogics\translate('DESC')}}</th>
            <th class="">{{\App\CentralLogics\translate('Price')}}</th>
        </tr>
        </thead>

        <tbody>
        @php($sub_total=0)
        @php($total_tax=0)
        @php($total_dis_on_pro=0)
        @foreach($order->details as $detail)
            @if($detail->product)
                <tr>
                    <td class="">
                        {{$detail['quantity']}}
                    </td>
                    <td class="">
                        <span style="word-break: break-all;"> {{ Str::limit($detail->product['name'], 200) }}</span><br>
                        @if(count(json_decode($detail['variation'],true))>0)
                            <strong><u>Variation : </u></strong>
                            @foreach(json_decode($detail['variation'],true)[0] ?? json_decode($detail['variation'],true) as $key1 =>$variation)
                                <div class="font-size-sm text-body" style="color: black!important;">
                                    <span>{{$key1}} :  </span>
                                    <span
                                        class="font-weight-bold">{{$variation}} {{$key1=='price'?\App\CentralLogics\Helpers::currency_symbol():''}}</span>
                                </div>
                            @endforeach
                        @endif
                        {{\App\CentralLogics\translate('Discount')}}
                        : {{ Helpers::set_symbol($detail['discount_on_product']*$detail['quantity']) }}
                    </td>
                    <td style="width: 28%">
                        @php($amount=($detail['price']-$detail['discount_on_product'])*$detail['quantity'])
                        {{ Helpers::set_symbol($amount) }}
                    </td>
                </tr>
                @php($sub_total+=$amount)
                @php($total_tax+=$detail['tax_amount']*$detail['quantity'])
            @endif
        @endforeach
        </tbody>
    </table>
    <span>---------------------------------------------------------------------------------</span>

    <div class="row justify-content-md-end">
        <div class="col-md-7 col-lg-7">
            <dl class="row text-right" style="color: black!important;">
                <dt class="col-6">{{\App\CentralLogics\translate('Items Price')}}:</dt>
                <dd class="col-6">{{ Helpers::set_symbol($sub_total) }}</dd>
                <dt class="col-6">{{\App\CentralLogics\translate('Tax')}} / {{\App\CentralLogics\translate('VAT')}}:</dt>
                <dd class="col-6">{{ Helpers::set_symbol($total_tax) }}</dd>

                <dt class="col-6">{{\App\CentralLogics\translate('Subtotal')}}:</dt>
                <dd class="col-6">{{ Helpers::set_symbol($order->order_amount) }}</dd>
                <dt class="col-6">{{\App\CentralLogics\translate('Coupon Discount')}}:</dt>
                <dd class="col-6">
                    - {{ Helpers::set_symbol($order['coupon_discount_amount']) }}</dd>
                <dt class="col-6">{{\App\CentralLogics\translate('Delivery Fee')}}:</dt>
                <dd class="col-6">
                    @if($order['order_type']=='take_away')
                        @php($del_c=0)
                    @else
                        @php($del_c=$order['delivery_charge'])
                    @endif
                    {{ Helpers::set_symbol($del_c) }}
                    <hr>
                </dd>

                <dt class="col-6" style="font-size: 20px">{{\App\CentralLogics\translate('Total')}}:</dt>
                <dd class="col-6"
                    style="font-size: 20px">{{ Helpers::set_symbol($order->order_amount) }}</dd>
            </dl>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-between border-top">
        <span>{{\App\CentralLogics\translate('Paid_by')}}: {{$order->payment_method}}</span>
    </div>
    <span>---------------------------------------------------------------------------------</span>
    <h5 class="text-center pt-3">
        """{{\App\CentralLogics\translate('THANK YOU')}}"""
    </h5>
    <span>---------------------------------------------------------------------------------</span>
</div>
