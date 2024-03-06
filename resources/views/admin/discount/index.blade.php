<x-admin-layout>

    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    @endsection

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

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <h3 class="evogria">Discount</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="/admin/discount/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Code Discount" id="inputCode"
                            name="inputCode">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Nominal</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputNominal" placeholder="Nominal Discount"
                            name="inputNominal" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Minimum Purchase</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" placeholder="Minimum Purchase for Discount"
                            id="inputMin" name="inputMin" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Quota Redeem</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="quotaRedeem" placeholder="Total Quota Redeem"
                            name="quotaRedeem" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Bulk Input</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="bulk" name="bulk"
                            placeholder="Input Bulk. Ex: 10" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Product</label>
                    <div class="col-sm-10">
                        <div class="discountProduct">
                            <div>
                                <input type="checkbox" name="products[]" id="all_item" value="0">
                                <label for="all_item">All Products</label>
                            </div>
                            @foreach ($products as $product)
                                <div>
                                    <input type="checkbox" name="products[]" id="product{{ $product->id }}"
                                        value="{{ $product->id }}">
                                    <label for="product{{ $product->id }}">{{ $product->title }}</label>
                                    </input>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Nominal</th>
                        <th>Minimum Purchase</th>
                        <th>Quota Redeem</th>
                        <th>Product</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($discount as $disc)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $disc->code }}</td>
                            <td>{{ $disc->nominal }}</td>
                            <td>{{ $disc->min_total }}</td>
                            <td>{{ $disc->quota_redeem < 1 ? 'Habis' : $disc->quota_redeem }}</td>
                            <td>
                                @forelse ($disc->products as $product)
                                    {{ $product->title }}<br>
                                @empty
                                    All Products
                                @endforelse
                            </td>

                            <td><a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2"
                                    href="/admin/discount/edit/{{ $disc->id }}"><i class="fas fa-edit me-1"></i>
                                    Edit</a>
                                <a href="/admin/discount/delete/{{ $disc->id }}"
                                    onclick="return confirm('Are you sure you want to delete this item?');"
                                    class="btn btn-danger btn-small d-flex align-items-center justify-content-center"><i
                                        class="fa fa-trash me-1" aria-hidden="true"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @section('js')
        <script>
            $(document).ready(function() {
                $('#table').DataTable();
            });
        </script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function() {
                var availableTags = [
                    @foreach ($products as $product)
                        "{{ $product->title }}",
                    @endforeach
                ];

                function split(val) {
                    return val.split(/,\s*/);
                }

                function extractLast(term) {
                    return split(term).pop();
                }

                $("#inputProduct")
                    // don't navigate away from the field on tab when selecting an item
                    .on("keydown", function(event) {
                        if (event.keyCode === $.ui.keyCode.TAB &&
                            $(this).autocomplete("instance").menu.active) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        minLength: 0,
                        source: function(request, response) {
                            // delegate back to autocomplete, but extract the last term
                            response($.ui.autocomplete.filter(
                                availableTags, extractLast(request.term)));
                        },
                        focus: function() {
                            // prevent value inserted on focus
                            return false;
                        },
                        select: function(event, ui) {
                            var terms = split(this.value);
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push(ui.item.value);
                            // add placeholder to get the comma-and-space at the end
                            terms.push("");
                            this.value = terms.join(", ");
                            return false;
                        }
                    });
            });
        </script>
    @endsection

</x-admin-layout>
