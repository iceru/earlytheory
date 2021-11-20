<x-app-layout>
    @section('title')
        My Orders
    @endsection

    <div class="container account">
        <div class="row">
            <div class="col-12 mb-5">
                <h3 class="evogria text-page">Confirm Payment</h3>
            </div>
            @include('layouts.account-navigation')

            <div class="col-12 col-md-9 orders-content">
                <h5 class="mb-3">Order ID: {{ $order->sales_no }}</h5>
                <form action="{{ route('user.confirm-submit') }}" >
                    <div class="form-group mb-3">
                        <label for="inputPayType">Tipe Pembayaran</label>
                        <select class="form-select" name="inputPayType" id="inputPayType">
                            <option selected disabled>Select</option>
                            @foreach ($paymentMethods as $payType)
                            <option {{old('inputPayType') == $payType->id ? 'selected' : ''}} value="{{$payType->id}}">
                                {{$payType->name}}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="form-group mb-3">
                        <label for="inputPayment">Upload Bukti Transfer (Max. 5MB)</label>
                        <input type="file" class="form-control" id="inputPayment" name="inputPayment"
                            accept="image/jpeg,image/png,image/svg+xml" required>
                    </div>

                    <div class="col-12 d-grid gap-2">
                        <button type="submit" class="button primary">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script>
          $(document).ready(function(){
            $('.product-image').slick({
                dots: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
            });
        });
    </script>
</x-app-layout>