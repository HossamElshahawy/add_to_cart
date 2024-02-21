
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

</head>
<body>
<button>
    <a href="{{route('products.index')}}">Go to Products</a>
</button>
<hr>
<div class="container">
    <h1>Your Cart</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cartItems as $cartItem)
            <tr> <!-- Open table row here -->
                <td>{{$cartItem->product->name}}</td>
                <td>
                    <input type="number" class="quantity-input" value="{{$cartItem->quantity}}" min="1"> <!-- Input field for quantity -->
                    <button class="cart-quantity-update" data-id="{{$cartItem->id}}">Update</button>
                </td>
                <td>
                    <button class="cart-delete" data-id="{{$cartItem->id}}">Delete</button>
                </td>
            </tr> <!-- Close table row here -->
        @endforeach
        </tbody>
    </table>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.cart-delete').click(function(e) {
            e.preventDefault(); // Prevent the default click behavior (e.g., following a link)
            var id = $(this).data('id'); // Get the data-id attribute of the clicked element, which likely corresponds to the cart item I
            $.ajax({
                url: "{{route('cartItem.delete', ['id' => ':id'])}}".replace(':id', id), // Pass the id parameter
                type: 'POST', // The HTTP method for the request
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token to prevent cross-site request forgery
                    id: id // The ID of the cart item to delete
                },
                success: function(response) {
                    alert(response); // Display a success message, presumably received from the server
                    location.reload();
                    // You may also want to update the cart table or perform other actions here after successful deletion
                }
            });
        });

        $('.cart-quantity-update').click(function (e) {
            e.preventDefault();
            var cartItemId = $(this).data('id');
            var newQuantity = $(this).closest('tr').find('.quantity-input').val(); // Get new quantity from input field
            var token = '{{ csrf_token() }}';

            $.ajax({
                url: "{{route('cartItem.updateQuantity', ['id' => ':id'])}}".replace(':id', cartItemId),
                type: 'POST',
                data: {
                    _token: token,
                    id: cartItemId,
                    quantity: newQuantity
                },
                success: function(response) {
                    alert(response);
                    location.reload();
                }
            });
        })
    });
</script>

</body>
</html>
