<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .product-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .card {
            padding: 20px;
            width: 30%;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            margin-bottom: 20px;
        }

        .card:hover {
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        }

        .card h2 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 10px;
        }

        .card button {
            background-color: #0066cc;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .card button:hover {
            background-color: #0052a3;
        }
    </style>
</head>
<body>
<div class="product-cards">

    @foreach($products as $product)
        <div class="card">
            <h2>{{$product->name}}</h2>
            <p>{!! $product->description !!}</p>
            <p>Quantity: {{$product->quantity}}</p>
            <input type="number" class="quantity-input" value="1" min="1"> <!-- Input field for quantity -->
            <button class="add-to-cart-btn"
                    data-product-id="{{ $product->id }}">
                Add to Cart
            </button>
        </div>
    @endforeach



</div>
<hr>
<!-- Cart table -->
<button>
    <a href="{{route('cartItemsPage')}}">Go to Cart</a>
</button>
<div class="container">
    <h1>Your Cart</h1>
    <table class="cart-table">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var token = "{{ csrf_token() }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Load initial cart items when the page loads
        updateCartTable();

        $('.add-to-cart-btn').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            // var quantity = $(this).data('quantity');
            var quantity = $(this).closest('.card').find('.quantity-input').val(); // Get quantity from input field

            var token = '{{ csrf_token() }}'; // Get CSRF token

            $.ajax({
                url: "{{ route('add_to_cart') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    quantity: quantity,
                    _token: token // Include CSRF token in the data
                },
                success: function(response) {
                    // Update the cart table in real-time
                    alert(response)
                    updateCartTable();
                },
                error: function(xhr) {
                    // Handle errors
                    console.log(xhr.responseText);
                }
            });
        });

        // Function to update the cart table in real-time
        function updateCartTable() {
            $.ajax({
                url: "{{ route('listCartItems') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // Clear existing cart items
                    $('.cart-table tbody tr').empty();

                    // Append new cart items
                    $.each(response, function(index, cartItem) {
                        var row = '<tr>' +
                            '<td>' + cartItem.product.name + '<br>' + '</td>' +
                            '<td>' + cartItem.quantity + '</td>' +
                            '</tr>';
                        $('.cart-table tbody').append(row);
                    });
                },
                error: function(xhr) {
                    // Handle errors
                    console.log(xhr.responseText);
                }
            });
        }
    });
</script>

</body>
</html>
