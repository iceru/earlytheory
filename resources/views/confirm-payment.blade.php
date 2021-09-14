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
                @if($order->payment)
                <div class="text-center thank-you mb-3">
                    <h3 class="mb-4">Pembayaran Berhasil</h3>
                    <img src="/images/pay.svg" class="mb-3" width=300 alt="">
                    <h5>Kami akan konfirmasi orderanmu lewat Whatsapp!</h5>
                    <p>Pengiriman file dalam waktu 2-3 hari kerja</p>
                    <a class="button primary inline mt-3" href="{{ route('user.orders')}}">Kembali ke Orders</a>
                </div>
                @else
                @if (session('soldout') || $is_soldout === 1)
                <div class="alert alert-danger">
                    Sorry, the product on your order already sold out, please contact us for a refund.
                </div>
                @endif
                <h5 class="mb-3">Order ID: {{ $order->sales_no }}</h5>
                <form action="{{ route('user.confirm-submit', $order->sales_no) }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                        <button type="submit" class="button primary"
                        @if ($is_soldout === 1)
                            disabled
                        @endif>
                            Submit
                        </button>
                    </div>
                </form>

                @endif
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