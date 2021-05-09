<x-app-layout>
    <div class="col-12 checkout">
        <div class="row">
            <div class="col-12 title-page">
                <h1>Payment Success</h1>
            </div>
            {{-- <div class="col-12 indicator">
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle active"></div>
            </div> --}}
            <div class="col-12">
                <h5>Sales Number: {{$sales->sales_no}}</h5>
                <h5>Email: {{$sales->email}}</h5>
                <h5>Proof of Payment:</h5>
                <img src="{{Storage::url('payment-proof/'.$sales->payment)}}">
            </div>

    </div>
</x-app-layout>
