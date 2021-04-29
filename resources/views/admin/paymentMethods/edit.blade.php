<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

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
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

</x-admin-layout>

