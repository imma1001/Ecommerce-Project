@extends('layout.app')
@section('title', 'Payment')
@section('content')



<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Our Payment</p>
                    <h1>Check Out Product</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-accordion-wrap">
                    <div class="accordion" id="accordionExample">
                      <div class="card single-accordion">
                        <div class="card-header" id="headingOne">
                          <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              Billing Address
                            </button>
                          </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                          <div class="card-body">
                            <div class="billing-address-form">
                                <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" required class="form-control" placeholder="Enter your name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" required class="form-control" placeholder="Enter your email">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Address</label>
                                        <input type="text" name="address" required class="form-control" placeholder="Enter your address">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Phone</label>
                                        <input  type="tel" placeholder="phone" required class="form-control" placeholder="Enter your phone">
                                    </div>
                                    
                                    <div id="card-element"></div>
                                    <div id="card-errors" role="alert"></div>
                                    <button type="submit" class="btn btn-primary">Pay</button>
                                </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                
                                <script src="https://js.stripe.com/v3/"></script>
                                <script>
                                    var stripe = Stripe('{{ config('services.stripe.key') }}');
                                    var elements = stripe.elements();
                                    var card = elements.create('card');
                                    card.mount('#card-element');
                                
                                    card.on('change', function(event) {
                                        var displayError = document.getElementById('card-errors');
                                        if (event.error) {
                                            displayError.textContent = event.error.message;
                                        } else {
                                            displayError.textContent = '';
                                        }
                                    });
                                
                                    var form = document.getElementById('payment-form');
                                    form.addEventListener('submit', function(event) {
                                        event.preventDefault();
                                        stripe.createToken(card).then(function(result) {
                                            if (result.error) {
                                                var errorElement = document.getElementById('card-errors');
                                                errorElement.textContent = result.error.message;
                                            } else {
                                                stripeTokenHandler(result.token);
                                            }
                                        });
                                    });
                                
                                    function stripeTokenHandler(token) {
                                        var form = document.getElementById('payment-form');
                                        var hiddenInput = document.createElement('input');
                                        hiddenInput.setAttribute('type', 'hidden');
                                        hiddenInput.setAttribute('name', 'stripeToken');
                                        hiddenInput.setAttribute('value', token.id);
                                        form.appendChild(hiddenInput);
                                        form.submit();
                                    }
                                </script>
                                
@endsection