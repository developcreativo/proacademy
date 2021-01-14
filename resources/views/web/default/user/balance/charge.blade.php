@extends($user['vendor'] == 1 ? getTemplate() . '.user.layout.balancelayout' : getTemplate() . '.user.layout_user.balancelayout')

@if($user['vendor'] == 1)
    @section('tab4','active')
@else
    @section('tab7','active')
@endif
@section('tab')
    <div class="h-20"></div>
    <div class="row ucp-top-panel">
        <div class="col-md-3 col-xs-12 tab-con">
            <div class="top-panel-box-balance sbox3 sbox3-s">
                <span>{{ trans('main.account_charge') }}</span>
                <label>{{ currencySign() }}{{ $user['credit'] }}</label>
            </div>
        </div>
        <div class="col-md-3 col-xs-12 tab-con">
            @if($user['vendor'] == 1)
                <div class="top-panel-box-balance sbox3 sbox3-r">
                    <span>{{ trans('main.withdrawable_amount') }}</span>
                    <label>{{ currencySign() }}{{ $user['income'] }}</label>
                </div>
            @endif
        </div>
        <div class="col-md-6 col-xs-12 tab-con mart-10">
           {{-- <form method="post" action="/user/balance/charge/pay" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label col-md-2 tab-con ta-r">{{ trans('main.gateway') }}</label>
                    <div class="col-md-10">
                        <select name="type" class="form-control font-s">
                            @if(get_option('gateway_paypal') == 1)
                                <option value="paypal">paypal</option>
                            @endif
                            @if(get_option('gateway_paytm') == 1)
                                <option value="paytm">paytm</option>
                            @endif
                            @if(get_option('gateway_payu') == 1)
                                <option value="payu">payu</option>
                            @endif
                            @if(get_option('gateway_paystack') == 1)
                                <option value="paystack">paystack</option>
                            @endif
                            @if(get_option('gateway_razorpay') == 1)
                                <option value="razorpay">razorpay</option>
                            @endif
                            @if(get_option('gateway_stripe') == 1)
                                <option value="stripe">stripe</option>
                            @endif
                            <option value="income">{{ trans('main.income') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 tab-con ta-r">{{ trans('main.amount') }} ({{ currencySign() }})</label>
                    <div class="col-md-6 tab-con">
                        <input type="text" placeholder="{{ currencySign() }}" name="price" class="form-control text-center" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" name="submit" class="btn btn-custom pull-left btn-100-p">{{ trans('main.charge_account') }}</button>
                    </div>
                </div>
            </form> --}}

            <form id="payment-form">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="control-label col-md-2 tab-con ta-r">{{ trans('main.amount') }} ({{ currencySign() }})</label>
                    <div class="col-md-6 tab-con">
                        <input type="text" placeholder="{{ currencySign() }}" name="price" class="form-control text-center" required>
                    </div>
                    <div class="col-md-4">
                        <button id="checkout-button" type="button" name="submit" class="btn btn-custom pull-left btn-100-p">{{ trans('main.charge_account') }}</button>
                    </div>
                </div>
              </form>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        // Create a Stripe client.
        var stripe = Stripe('pk_test_51I8niWDGmggSbM4RB5RyspUmRdAJUN5rWxjxUPpB6CKpetncLkMKsSg2DuxNIrUX9mxO7JI8kXDRJfcPiS96wcWK00ZSTgd9rN');

        var checkoutButton = document.getElementById('checkout-button');

        checkoutButton.addEventListener('click', function() {
            const data = new FormData(document.getElementById('payment-form'));
            // Create a new Checkout Session using the server-side endpoint you
            // created in step 3.
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            fetch('/user/balance/charge/stripe', {
                method: 'POST',
                body: data
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(session) {
                console.log(session);
                console.log(stripe);
                return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(function(result) {
                // If `redirectToCheckout` fails due to a browser or network
                // error, you should display the localized error message to your
                // customer using `error.message`.
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function(error) {
                console.log(error)
               // console.error('Error:', error);
            });
        });
    </script>
@endsection

