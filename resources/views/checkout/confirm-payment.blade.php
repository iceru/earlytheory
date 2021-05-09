<x-app-layout>
    <div class="col-12 checkout">
        <div class="row">
            <div class="col-12 title-page">
                <h1>Confirm Payment</h1>
            </div>
            <div class="col-12 indicator">
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle active"></div>
            </div>
            <form action="/checkout/{{$sales->id}}/confirm-payment/submit" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-payment col-12">
                    {{-- <div class="form-group">
                        <label class="form-label" for="">Full Name</label>
                        <input class="form-control" type="text" >
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control">
                    </div> --}}
                    <input type="text" name="salesId" value="{{$sales->id}}" hidden>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="inputEmail" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Upload Proof of Payment</label>
                        <input type="file" class="form-control" id="inputPayment" name="inputPayment" accept="image/*">
                    </div>
                    <div class="col-12 d-grid gap-2">
                        <button type="submit" class="button secondary">
                            Submit
                        </a>
                    </div>
                </div>
            </form>

    </div>
</x-app-layout>
