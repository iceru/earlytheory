<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <h3 class="evogria">Update Article</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="/admin/faq/update">
                @csrf
                <input type="hidden" name="id" value="{{$faq->id}}">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Question</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateTitle" name="updateTitle" value="{{$faq->title}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Answer</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="updateQuestion" id="updateQuestion" cols="30" rows="4">{{$faq->question}}</textarea>
                    </div>
                </div>
                <button type="submit" class="button primary">Update</button>
            </form>
        </div>
    </div>


    @section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.5/jscolor.min.js" integrity="sha512-YxdM5kmpjM5ap4Q437qwxlKzBgJApGNw+zmchVHSNs3LgSoLhQIIUNNrR5SmKIpoQ18mp4y+aDAo9m/zBQ408g==" crossorigin="anonymous"></script>
    @endsection
</x-admin-layout>

