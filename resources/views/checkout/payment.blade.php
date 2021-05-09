<x-app-layout>
    <div class="col-12 checkout">
        <div class="row">
            <div class="col-12 title-page">
                <h1>Payment</h1>
            </div>
            <div class="col-12 indicator">
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle active"></div>
                <div class="line"></div>
                <div class="circle"></div>
            </div>
            <div class="payment-method col-12">
                <div class="row payment-method-container">
                    <div class="col-6 type active" id="bank">
                        <p>Bank Transfer</p>
                    </div>
                    <div class="col-6 type" id="qr">
                        <p>QR Payment (Gopay, OVO)</p>
                    </div>
                </div>
                <div class="bank-detail payment-detail show">
                    @foreach ($paymethods_bank as $item)
                    <div class="bank-method-item d-flex justify-content-center align-items-center mb-3">
                        <div class="bank-image">
                            <img src="{{Storage::url('payment-logo/'.$item->logo)}}" alt="">
                        </div>
                        <div class="bank-text">
                            <span class="bank-number">{{$item->account_number}}</span> <br>
                            <span> a/n {{$item->account_owner}}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="qr-detail payment-detail">
                    <div class="bank-method-item d-flex justify-content-center align-items-center mb-3">
                        <div class="bank-image">
                            <img src="{{Storage::url('payment-logo/'.$paymethods_qr->logo)}}" alt="">
                        </div>
                        {{-- <div class="bank-text">
                            <span class="bank-number">16651232132</span> <br>
                            <span> a/n John Doe</span>
                        </div> --}}
                    </div>
                </div>

            <div class="col-12">
                <a class="button secondary" href="/checkout/{{$sales->id}}/confirm-payment">
                    Confirm your Payment
                </a>
            </div>
            </div>
    </div>

    @section('js')
    <script>
        $(document).ready(function(){
            $('#bank').click(function() {
                $('.bank-detail').addClass('show');
                $('.qr-detail').removeClass('show');
                $('#qr').removeClass('active');
                $(this).addClass('active');
            });

            $('#qr').click(function() {
                $('.bank-detail').removeClass('show');
                $('.qr-detail').addClass('show');
                $(this).addClass('active');
                $('#bank').removeClass('active');
            })
        });
    </script>
    @endsection
</x-app-layout>
