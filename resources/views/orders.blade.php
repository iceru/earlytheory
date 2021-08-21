<x-app-layout>
    @section('title')
        My Orders
    @endsection

    <div class="container account">
        <div class="row">
            <div class="col-12 mb-5">
                <h3 class="evogria text-page">My Orders</h3>
            </div>
            @include('layouts.account-navigation')

            <div class="col-9 orders-content">
                @forelse ($orders as $order)
                    <div class="row order-item">
                        <div class="col-6">
                            <h5>{{ $order->sales_no }}</h5>
                        </div>
                        <div class="col-6">
                            <h5>{{ $order->total_price }}</h5>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <a href="" class="button primary">Order Detail</a>
                                @if ($order->payment->isEmpty())
                                    <a href="" class="button secondary">Confirm Payment</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <h5>There is no orders</h5>
                @endforelse
                
            </div>
        </div>

    </div>
</x-app-layout>