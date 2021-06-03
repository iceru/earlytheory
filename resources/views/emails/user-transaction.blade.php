<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>

<body style="margin:auto">
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
    
        .col-6 {
            flex: 0 1 50%;
        }
    
        .order-img,
        .img-product {
            width: 100%;
        }
        </style>
    <img class="order-img" src="https://earlytheory.com/images/OrderEmailConf.png" alt="Order Confirmation">
    <div>
        <h3>Sales Number: {{ $sales->sales_no }}</h3>
        <h3>Full Name: {{ $sales->name }}</h3>
        <h3>Email: {{ $sales->email }}</h3>
        <h3 style="margin-bottom: 30px">Phone Number: {{ $sales->phone }}</h3>
        <h3 style="margin-bottom: 10px">Products: </h3>
        <div class="products">
            <div class="row">
                @foreach ($sales->products as $product)
                <div class="col-6" style="margin-bottom: 16px">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="margin-bottom: 4px">{{$product->title}}</h4>
                            <p class="margin-bottom: 4px">idr {{number_format($product->price)}}</p>
                        </div>
                        <p class="question" style="margin-bottom: 20px">
                            <span>Pertanyaan: </span>
                            <span style="margin-left: 6px">{{$product->pivot->question}}</span>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</body>

</html>