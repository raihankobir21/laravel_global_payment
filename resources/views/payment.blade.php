<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GlobalPay Payment</title>
</head>
<body>
    <h1>Make a Payment</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <label>Card Number:</label><br>
        <input type="text" name="card_number" required><br><br>

        <label>Expiry Date (MMYY):</label><br>
        <input type="text" name="expiry_date" required><br><br>

        <label>CVV:</label><br>
        <input type="text" name="cvv" required><br><br>

        <label>Amount (USD):</label><br>
        <input type="number" name="amount" required><br><br>

        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
