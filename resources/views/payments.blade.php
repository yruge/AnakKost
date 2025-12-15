<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Your Payments</h1>

    @foreach ($payments as $payment)
        <div>
            <p>Amount: {{ $payment->amount }}</p>
            <p>Status: {{ $payment->status }}</p>
            <p>Period: {{ $payment->for_period }}</p>
        </div>
    @endforeach
</body>
</html>