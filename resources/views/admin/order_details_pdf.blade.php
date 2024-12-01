<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>
    <h1>Order Details for Order #{{ $order->id }}</h1>

    <p><strong>Customer Name:</strong> {{ $order->user->name }}</p>
    <p><strong>Order Date:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
    <p><strong>Total Amount:</strong> ${{ $order->total_amount }}</p>

    <h2>Items</h2>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Quantity</th>
                <th>Payment</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
           
                <tr>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>${{ number_format($order->total_amount) }}</td>
                </tr>
            
        </tbody>
    </table>
</body>
</html>
