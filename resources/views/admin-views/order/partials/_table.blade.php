@foreach($orders as $key=>$order)

    <tr class="status-{{$order['order_status']}} class-all">
        <td class="">
            {{$key+1}}
        </td>
        <td class="table-column-pl-0">
            <a href="{{route('admin.orders.details',['id'=>$order['id']])}}">{{$order['id']}}</a>
        </td>
        <td>{{date('d M Y',strtotime($order['created_at']))}}</td>
        <td>
            @if($order->customer)
                <a class="text-body text-capitalize"
                   href="{{route('admin.customer.view',[$order['user_id']])}}">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</a>
            @else
                <label class="badge badge-danger">{{\App\CentralLogics\translate('invalid')}} {{\App\CentralLogics\translate('customer')}} {{\App\CentralLogics\translate('data')}}</label>
            @endif
        </td>
        <td>
            <label class="badge badge-soft-primary">{{$order->branch?$order->branch->name:'Branch deleted!'}}</label>
        </td>
        <td>
            @if($order->payment_status=='paid')
                <span class="badge badge-soft-success">
                                      <span class="legend-indicator bg-success"></span>{{\App\CentralLogics\translate('paid')}}
                                    </span>
            @else
                <span class="badge badge-soft-danger">
                                      <span class="legend-indicator bg-danger"></span>{{\App\CentralLogics\translate('unpaid')}}
                                    </span>
            @endif
        </td>
        <td>{{ Helpers::set_symbol($order['order_amount']) }}</td>
        <td class="text-capitalize">
            @if($order['order_status']=='pending')
                <span class="badge badge-soft-info ml-2 ml-sm-3">
                                      <span class="legend-indicator bg-info"></span>{{\App\CentralLogics\translate('pending')}}
                                    </span>
            @elseif($order['order_status']=='confirmed')
                <span class="badge badge-soft-info ml-2 ml-sm-3">
                                      <span class="legend-indicator bg-info"></span>{{\App\CentralLogics\translate('confirmed')}}
                                    </span>
            @elseif($order['order_status']=='processing')
                <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                      <span class="legend-indicator bg-warning"></span>{{\App\CentralLogics\translate('processing')}}
                                    </span>
            @elseif($order['order_status']=='out_for_delivery')
                <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                      <span class="legend-indicator bg-warning"></span>{{\App\CentralLogics\translate('out_for_delivery')}}
                                    </span>
            @elseif($order['order_status']=='delivered')
                <span class="badge badge-soft-success ml-2 ml-sm-3">
                                      <span class="legend-indicator bg-success"></span>{{\App\CentralLogics\translate('delivered')}}
                                    </span>
            @else
                <span class="badge badge-soft-danger ml-2 ml-sm-3">
                                      <span class="legend-indicator bg-danger"></span>{{str_replace('_',' ',$order['order_status'])}}
                                    </span>
            @endif
        </td>
        <td>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <i class="tio-settings"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item"
                       href="{{route('admin.orders.details',['id'=>$order['id']])}}"><i
                            class="tio-visible"></i> {{\App\CentralLogics\translate('view')}}</a>
                    <a class="dropdown-item" target="_blank"
                       href="{{route('admin.orders.generate-invoice',[$order['id']])}}"><i
                            class="tio-download"></i> {{\App\CentralLogics\translate('invoice')}}</a>
                </div>
            </div>
        </td>
    </tr>

@endforeach
