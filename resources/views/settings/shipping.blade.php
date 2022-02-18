@extends('layouts.default')

@section('card-content')

<form id="setting-form" method="POST" action="{{route('shopify.update-shipping')}}">

    <article>
        <div class="card">
            <h2>{{trans('app.settings.shipment_settings')}}</h2>

            <div class="row" style="margin-bottom: 2em">
                <div class="columns four rate-name-column">
                    {{trans('app.settings.default_shipping_method')}}

                </div>
                <div class="columns eight">
                    <div class="row">
                        {{--<div class="input-group">--}}
                        {{--<span class="append">{{trans('app.settings.shipping_method')}}</span>--}}
                        <select name="default_shipping_method">
                            <option value="">—</option>
                            @foreach($shipping_methods as $key => $service_provider)
                            @if(count($service_provider) > 0)
                            <optgroup label="{{$key}}">
                                @foreach($service_provider as $product)
                                <option value="{{ $product['shipping_method_code'] }}" data-services="{{json_encode($product['additional_services'])}}"
                                        @if($shop->default_service_code == $product['shipping_method_code']) selected @endif>
                                    {{ $product['name'] }}
                                </option>
                                @endforeach
                            </optgroup>
                            @endif
                            @endforeach
                        </select>
                        {{--</div>--}}
                    </div>
                </div>
            </div>

            <div>
                <div class="columns four">
                    <h5>{{trans('app.settings.shopify_method')}}</h5>
                </div>
                <div class="columns eight">
                    <h5>{{trans('app.settings.'.$type.'_method')}}</h5>
                </div>
            </div>

            @foreach($shipping_rates as $rate)
            @if(!$rate['same'])
            <div class="row">
                <div class="columns four rate-name-column">
                    {{$rate['zone']}}: {{$rate['name']}}
                </div>
                <div class="columns eight">
                    <div class="row">
                        <select name="shipping_method[{{$rate['name']}}]">
                            <option value="">{{trans('app.settings.default_shipping')}}</option>
                            @if(!$rate['duplicate'])
                            <option value="NO_SHIPPING"  @if($rate['product_code'] == 'NO_SHIPPING') selected @endif>{{trans('app.settings.no_shipping_method')}}</option>
                            @foreach($shipping_methods as $key => $service_provider)
                            @if(count($service_provider) > 0)
                            <optgroup label="{{$key}}">
                                @foreach($service_provider as $product)
                                <option value="{{ $product['shipping_method_code'] }}" data-services="{{json_encode($product['additional_services'])}}"
                                        @if($rate['product_code'] == $product['shipping_method_code']) selected @endif>
                                    {{ $product['name'] }}
                                </option>
                                @endforeach
                            </optgroup>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="columns twelve">
                    @if($rate['duplicate'])
                    <small>
                        {{trans('app.settings.only_default')}}
                    </small>
                    @endif
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </article>

    @include('settings.shipping_services')

</form>

@endsection
