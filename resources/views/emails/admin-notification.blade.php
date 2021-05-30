<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>


<style>

    body {
        max-width: 900px;
        font-family: 'PT Sans', sans-serif;
        padding: 20px;
    }

    .main {
        margin: 10px auto;
        padding: 0 20px;
    }

    .row {
        display: flex;
    }

    .col-8 {
        flex: 0 1 70%;
        margin-bottom: 16px;
    }

    .col-4 {
        flex: 0 1 30%;
        margin-bottom: 16px;
    }

    .order-img, .img-product {
        width: 100%;
    }
</style>

<body style="margin:auto">
   <img src="https://earlytheory.com/images/MainLogo.png" width="200" alt="Order Confirmation">
   <div>
       <h5>Sales Number: {{ $sales->sales_no }}</h5>
       <h5>Full Name: {{ $sales->name }}</h5>
       <h5>Email: {{ $sales->email }}</h5>
       <h5 style="margin-bottom: 2rem">Phone Number: {{ $sales->phone }}</h5>

       @foreach ($sales->products as $product)
        <div class="products">
            <div class="row">
                <div class="col-4">
                    @foreach ((array)json_decode($product->image) as $item)
                    @if($loop->first)
                    <img class="img-product" src="{{Storage::url('product-image/'.$item)}}" alt="Image">
                    @endif
                    @endforeach
                </div>
                <div class="col-8">
                    <h6>{{$product->title}}</h6>
                    <p>idr {{number_format($product->price)}}</p>
                </div>
            </div>
            <div class="question" style="margin-top: 12px">
                <p>Pertanyaan: </p>
                <p>{{$product->pivot->question}}</p>
            </div>
        </div>
        @endforeach
   </div>
</body>

</html>
