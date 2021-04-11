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
                    <div class="col-6 type bank active">
                        <p>Bank Transfer</p>
                    </div>
                    <div class="col-6 type qr">
                        <p>QR Payment (Gopay, OVO)</p>
                    </div>
                </div>
                <div class="bank-detail payment-detail">
                    <div class="bank-method-item row">
                        <div class="bank-image">
                            <img src="" alt="">
                        </div>
                        <div class="bank-text">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <a class="button primary" href="/checkout/summary">
                    Confirm your Payment
                </a>
            </div>
    </div>
</x-app-layout>
