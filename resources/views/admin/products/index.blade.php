<x-admin-layout>
    @section('title')
        Products Admin
    @endsection

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Sorry !</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <h3 class="evogria">Products Admin</h3>
    </div>

    <div class="mt-4 mb-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/products/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Order Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputOrdernumber" name="inputOrdernumber">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputTitle" name="inputTitle">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Base Price</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputPrice" name="inputPrice" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Discount Price</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputDiscPrice" name="inputDiscPrice" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Select Category" name="inputCategory">
                            <option selected disabled>Select Category</option>
                            <option value="product">Product</option>
                            <option value="service">Service</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row" id="duration">
                    <label class="col-sm-2 col-form-label">Duration</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputDuration" placeholder="Duration in Minutes"
                            name="inputDuration">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <div class="input-group control-group increment">
                            <input type="file" name="inputImage[]" class="form-control">
                            <div class="input-group-btn">
                                <button class="btn btn-success" type="button"><i class="fas fa-plus    "></i>
                                    Add</button>
                            </div>
                        </div>
                        <div class="clone hide">
                            <div class="control-group input-group" style="margin-top:10px">
                                <input type="file" name="inputImage[]" class="form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger" type="button"><i class="fas fa-times    "></i>
                                        Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Short Description</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="inputShortDesc" id="inputShortDesc" cols="30"
                            rows="2"></input>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="inputDesc" id="inputDesc" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Question Field</label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Select Category" name="inputQuestion">
                            <option selected disabled>Select Question Field</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row" id="question_title">
                    <label class="col-sm-2 col-form-label">Question Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputQuestionTitle" name="inputQuestionTitle">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Stock</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputStock" name="inputStock" min="0">
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
        </div>
    </div>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link button primary-line active" id="services-tab" data-bs-toggle="tab"
                data-bs-target="#services" type="button" role="tab" aria-controls="services"
                aria-selected="true">Services</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link button primary-line" id="products-tab" data-bs-toggle="tab"
                data-bs-target="#products" type="button" role="tab" aria-controls="products"
                aria-selected="false">Products</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="services" role="tabpanel" aria-labelledby="services-tab">
            <div class="py-12 table-overflow">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <table class="table display nowrap" id="table">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Base Price</th>
                                <th>Duration</th>
                                <th>Question Field</th>
                                <th>Question Title</th>
                                <th>Stock</th>
                                <th>Short Description</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service->ordernumber }}</td>
                                    <td>
                                        @foreach ((array) json_decode($service->image) as $item)
                                            <div class="ratio ratio-1x1 mb-2">
                                                <img src="{{ Storage::url('product-image/' . $item) }}" alt="Image"
                                                    width="100">
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>{{ $service->title }}</td>
                                    <td>{{ $service->price }}</td>
                                    <td>{{ $service->discount_price ? $service->base_price : '' }}</td>
                                    <td>{{ $service->duration }}</td>
                                    <td>{{ ucwords($service->question) }}</td>
                                    <td>{{ $service->question_title }}</td>
                                    <td>
                                        {{ $service->stock_data }}
                                    </td>
                                    <td>{{ $service->description_short }}</td>
                                    <td>{{ substr($service->description, 0, 100) . '...' }}</td>
                                    <td>{{ ucfirst($service->category) }}</td>
                                    <td><a class="btn btn-secondary btn-small d-flex align-items-center justify-content-center mb-2"
                                            href="/admin/products/{{ $service->id }}/variant"><i
                                                class="fas fa-list me-1"></i></i>
                                            Variant</a>
                                        <a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2"
                                            href="/admin/products/edit/{{ $service->id }}"><i
                                                class="fas fa-edit me-1"></i>
                                            Edit</a>
                                        @if ($service->hide == false)
                                            <a class="btn btn-warning btn-small d-flex align-items-center justify-content-center mb-2"
                                                href="/admin/products/hide/{{ $service->id }}"><i
                                                    class="fas fa-eye-slash me-1" aria-hidden="true"></i> Hide</a>
                                        @elseif($service->hide == true)
                                            <a class="btn btn-success btn-small d-flex align-items-center justify-content-center mb-2"
                                                href="/admin/products/unhide/{{ $service->id }}"><i
                                                    class="fas fa-eye me-1" aria-hidden="true"></i> Unhide (Show)</a>
                                        @endif
                                        <a class="btn btn-danger btn-small d-flex align-items-center justify-content-center"
                                            href="/admin/products/delete/{{ $service->id }}"><i
                                                class="fa fa-trash me-1" aria-hidden="true"></i> Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
            <div class="tab-pane fade show active" id="services" role="tabpanel" aria-labelledby="services-tab">
                <div class="py-12 table-overflow">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <table class="table table-overflow display nowrap" id="table_second">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Base Price</th>
                                    <th>Question Field</th>
                                    <th>Question Title</th>
                                    <th>Stock</th>
                                    <th>Short Description</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->ordernumber }}</td>
                                        <td>
                                            @foreach ((array) json_decode($product->image) as $item)
                                                <div class="ratio ratio-1x1 mb-2">
                                                    <img src="{{ Storage::url('product-image/' . $item) }}" alt="Image"
                                                        width="100">
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->base_price }}</td>
                                        <td>{{ ucwords($product->question) }}</td>
                                        <td>{{ $product->question_title }}</td>
                                        <td>
                                            {{ $product->stock_data }}
                                        </td>
                                        <td>{{ $product->description_short }}</td>
                                        <td>{{ substr($product->description, 0, 100) . '...' }}</td>
                                        <td>{{ ucfirst($product->category) }}</td>
                                        <td><a class="btn btn-secondary btn-small d-flex align-items-center justify-content-center mb-2"
                                                href="/admin/products/{{ $product->id }}/variant"><i
                                                    class="fas fa-list me-1"></i></i>
                                                Variant</a>
                                            <a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2"
                                                href="/admin/products/edit/{{ $product->id }}"><i
                                                    class="fas fa-edit me-1"></i> Edit</a>
                                            @if ($product->hide == false)
                                                <a class="btn btn-warning btn-small d-flex align-items-center justify-content-center mb-2"
                                                    href="/admin/products/hide/{{ $product->id }}"><i
                                                        class="fas fa-eye-slash me-1" aria-hidden="true"></i> Hide</a>
                                            @elseif($product->hide == true)
                                                <a class="btn btn-success btn-small d-flex align-items-center justify-content-center mb-2"
                                                    href="/admin/products/unhide/{{ $product->id }}"><i
                                                        class="fas fa-eye me-1" aria-hidden="true"></i> Unhide
                                                    (Show)</a>
                                            @endif
                                            <a class="btn btn-danger btn-small d-flex align-items-center justify-content-center"
                                                href="/admin/products/delete/{{ $product->id }}"><i
                                                    class="fa fa-trash me-1" aria-hidden="true"></i> Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="mb-5">
        <a class="button secondary" href="/admin/products/generate-sku">Generate Default SKU for Legacy Products</a>
    </div> --}}

    @section('js')
        <script>
            $(document).ready(function() {
                $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                    $.fn.dataTable.tables({
                        visible: true,
                        api: true
                    }).columns.adjust();
                });
                $('.table').DataTable({
                    responsive: true,
                });

                $('#duration').hide();
                $('#question_title').hide();

                $(".btn-success").click(function() {
                    var html = $(".clone").html();
                    $(".clone").after(html);
                });

                $('body').on("click", ".btn-danger", function() {
                    $(this).parents(".control-group").remove();
                });
            });

            $('select[name=inputCategory]').change(function() {
                if ($(this).val() == 'service') {
                    $('#duration').show();
                } else {
                    $('#duration').hide();
                }
            });

            $('select[name=inputQuestion]').change(function() {
                if ($(this).val() == 'yes') {
                    $('#question_title').show();
                } else {
                    $('#question_title').hide();
                }
            });


            tinymce.init({
                selector: 'textarea',
                toolbar_mode: 'floating',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                height: "480"
            });
        </script>
    @endsection

</x-admin-layout>
