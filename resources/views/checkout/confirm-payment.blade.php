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
            <form action="/checkout/{{$sales->sales_no}}/confirm-payment/submit" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-payment col-12">
                    <div class="form-group">
                        <label for="inputName">Full Name</label>
                        <input class="form-control" type="text" name="inputName">
                    </div>
                    <input type="text" name="salesId" value="{{$sales->id}}" hidden>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" name="inputEmail" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">Phone Number</label>
                        <input type="tel" class="form-control" name="inputPhone">
                    </div>
                    <div class="form-group">
                        <label for="inputPayType">Payment Type</label>
                        <select class="form-control" name="inputPayType" id="inputPayType">
                            <option selected disabled>Select</option>
                            @foreach ($paymentMethods as $payType)
                            <option value="{{$payType->id}}">{{$payType->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputRelationship">Status Relationship</label>
                        <select class="form-control" name="inputRelationship" id="inputRelationship">
                            <option selected disabled>Select</option>
                            <option value="single">Single</option>
                            <option value="pacaran">Pacaran</option>
                            <option value="tunangan_menikah">Tunangan/Menikah</option>
                            <option value="divorced">Divorced</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="inputPekerjaan">Status Pekerjaan</label>
                      <select class="form-control" name="inputPekerjaan" id="inputPekerjaan">
                            <option selected disabled>Select</option>
                            <option value="unemployed">Unemployed</option>
                            <option value="employed">Employed</option>
                            <option value="business">Business</option>
                            <option value="student">Student</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="inputPayment">Upload Proof of Payment</label>
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
