<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Products Admin
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="/admin/products/update">
                @csrf
                <input type="hidden" name="id" value="{{$product->id}}">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateTitle" name="updateTitle" value="{{$product->title}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="updateDesc" id="updateDesc" cols="30" rows="2">{{$product->description}}</textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Time to Read</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="updatePrice" name="updatePrice" min="0" value="{{$product->price}}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
    
</x-admin-layout>

