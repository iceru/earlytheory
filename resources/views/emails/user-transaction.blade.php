<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=PT+Sans&display=swap');
    body {
        max-width: 900px;
        font-family: 'PT Sans', sans-serif;
        padding: 20px;
    }
    .main {
        margin: 10px auto;
        padding: 0 20px;
    }
</style>

<body style="margin:auto">
   <img src="https://earlytheory.com/images/OrderEmailConf.png" alt="Order Confirmation">
   <div>
       <h5>Sales Number: {{ $sales->sales_no }}</h5>
       <h5>Full Name: {{ $sales->name }}</h5>
       <h5>Email: {{ $sales->email }}</h5>
       <h5 style="margin-bottom: 2rem">Phone Number: {{ $sales->phone }}</h5>

       <table class="table" id="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                {{-- <th>Qty</th> --}}
                <th>Duration</th>
                <th>Question</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales->products as $product)
            <tr>
                <td scope="row">{{$loop->iteration}}</td>
                <td>
                    @foreach ((array)json_decode($product->image) as $item)
                        @if($loop->first)
                        <img class="mb-1" src="{{Storage::url('product-image/'.$item)}}" alt="Image" width="100">
                        @endif
                    @endforeach
                </td>
                <td>{{$product->title}}</td>
                <td>idr {{number_format($product->price)}}</td>
                {{-- <td>{{$product->pivot->qty}}</td> --}}
                @if($product->duration > 0)
                <td>{{$product->duration}} menit</td>
                @else
                <td>-</td>
                @endif
                <td>{{$product->pivot->question}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
   </div>
</body>

</html>
