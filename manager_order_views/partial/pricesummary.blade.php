<hr>
<div class="media">
    <div class="media-left media-middle bg-info callout-arrow-left position-relative px-2">
        <i class="icon-money white font-medium-5"></i>
    </div>
    <div class="media-body p-1">
        <strong>{{__('orders.total_price')}}</strong>
        <div class="row" style="max-width: 600px">
            <div class="col-md-6">
                <table class="table" style="max-width: 250px">
                    <tr><td>{{__('orders.package_price')}}</td><td>:</td><td>{{number_format($model->defaultprice >0 ? $model->defaultprice : $model->specialprice,2)}}</td></tr>
                    <tr><td>{{__('orders.tax')}}</td><td>:</td><td>{{number_format($model->defaultpriceTax >0 ? $model->defaultpriceTax : $model->specialpriceTax,2)}}</td></tr>
                    <tr class="success"><td><b>{{__('orders.total')}}</b></td><td>:</td><td>{{number_format($model->defaultpriceGrossPrice >0 ? $model->defaultpriceGrossPrice : $model->specialpriceGrossPrice,2)}}</td></tr>
                </table>
            </div>
            <div class="col-md-6">

                <table class="table" style="max-width: 250px">
                    <tr><th>{{__('orders.extra_name')}}</th><th>{{__('orders.price')}}</th><th>{{__('orders.tax')}}</th><th>{{__('orders.total')}}</th></tr>
                    <?php $grandTotal=0; ?>

                    @if(isset($model->extras))
                        @foreach($model->extras as $extra)
                            <tr><td>{{$extra->name}}</td><td>{{number_format($extra->price,2)}}</td><td>{{number_format($extra->TaxValue,2)}}</td><td>{{number_format($extra->GrossPrice,2)}}</td></tr>
                            <?php $grandTotal+=number_format($extra->GrossPrice,2); ?>
                        @endforeach
                    @endif
                    <tr><td colspan="3"><b>{{__('orders.total')}}</b></td><td >{{$grandTotal}}</td></tr>
                </table>

            </div>
        </div>

    </div>
</div>
<br>
<div class="alert alert-success round alert-icon-left alert-arrow-left alert-dismissible fade in mb-2" role="alert">
    <strong>{{__('orders.grand_total')}}:</strong> {{number_format($model->defaultpriceGrossPrice >0 ? $grandTotal+$model->defaultpriceGrossPrice : $grandTotal+$model->specialpriceGrossPrice,2)}}
</div>
<script type="text/javascript">
     grad_total_amount=" {{number_format($model->defaultpriceGrossPrice >0 ? $grandTotal+$model->defaultpriceGrossPrice : $grandTotal+$model->specialpriceGrossPrice,2)}}"
</script>