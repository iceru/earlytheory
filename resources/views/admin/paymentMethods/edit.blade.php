<x-admin-layout>
    @if (count($errors) > 0)
    <div class="alert alert-danger mt-3">
      <strong>Sorry !</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif

    <div class="py-12">
        <h3 class="evogria">Update Payment Method</h3>
    </div>


    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/payment-methods/update">
                @csrf
                <input type="hidden" name="id" value="{{$paymentMethod->id}}">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateName" name="updateName" value="{{$paymentMethod->name}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Logo</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="updateLogo" name="updateLogo" value="{{$paymentMethod->logo}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Account Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateAccNum" name="updateAccNum" value="{{$paymentMethod->account_number}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Account Owner</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateAccOwn" name="updateAccOwn" value="{{$paymentMethod->account_owner}}">
                    </div>
                </div>
                <button type="submit" class="button primary">Update</button>
            </form>
        </div>
    </div>

</x-admin-layout>

