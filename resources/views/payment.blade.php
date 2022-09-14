@extends('layouts.app')
@section('content')

<a href="{{ route('home') }}" class="btn btn-primary" style="margin-left: 100px;">Back</a>

    @if (Session::has('success'))
        <center>
            <div class="alert alert-success alert-dismissible" style="width: 300px;">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Payement Successfull !</strong>
            </div>
        </center>
    @endif
    @if (Session::has('fail'))
        <center>
            <div class="alert alert-success alert-dismissible" style="width: 300px;">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Payement Failed !</strong>
            </div>
        </center>
    @endif

    <form action="{{route('processPayment', [$product, $price])}}" method="POST" id="subscribe-form">
    <div class="form-group">
    <div class="row">

    <table class="table table-bordered" style="width: 50%;margin-left:300px; background-color:aquamarine">
        <tbody>
        <tr>
            <td colspan="2" style="text-align: center;font-weight:bold">Make Payment</td>
        </tr>
        <tr>
            <td>Product Name</td>
            <td>{{$product}}</td>
        </tr>
        <tr>
            <td>Price</td>
            <td>INR. {{$price}}</td>
        </tr>
        <tr>
            <td>Card Holder Name</td>
            <td><input id="card-holder-name" type="text" value="{{$user->name}}">
            @csrf</td>
        </tr>
        <tr>
            <td colspan="2">
            <div class="form-row">
                <label for="card-element">Credit or debit card</label>
            <div id="card-element" class="form-control" style="width: 500px;margin-left:85px;background-color:white">   </div>
            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert"></div>
            </div>
            <div class="stripe-errors"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <button type="button"  id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-sm btn-success btn-block">Pay Now</button>
            </td>
        </tr>
        </tbody>
    </table>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

</form>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
            }
    };

    var card = elements.create('card', {hidePostalCode: true, style: style});
    card.mount('#card-element');
    console.log(document.getElementById('card-element'));

    card.addEventListener('change', function(event) 
    {
        var displayError = document.getElementById('card-errors');

        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
        console.log("attempting");
        const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: card,
                billing_details: { name: cardHolderName.value }
            }
        }
        );
        if (error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        }
        else {
            paymentMethodHandler(setupIntent.payment_method);
        }
    });

    function paymentMethodHandler(payment_method) 
    {
        var form = document.getElementById('subscribe-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', payment_method);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>

@endsection