<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .receipt {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .header p {
            margin: 5px 0 0;
            color: #666;
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 5px 0;
            color: #333;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items th,
        .items td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items th {
            background-color: #f5f5f5;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <h1>My Store</h1>
            <p>123 Main Street, City, Country</p>
            <p>Phone: (123) 456-7890</p>
        </div>

        <!-- Order Details -->
        <div class="details">
            <p><strong>Order ID:</strong> #123456</p>
            <p><strong>Date:</strong> October 10, 2023</p>
            <p><strong>Customer:</strong> John Doe</p>
        </div>

        <!-- Items Table -->
        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product 1</td>
                    <td>2</td>
                    <td>$20.00</td>
                </tr>
                <tr>
                    <td>Product 2</td>
                    <td>1</td>
                    <td>$30.00</td>
                </tr>
                <tr>
                    <td>Product 3</td>
                    <td>3</td>
                    <td>$15.00</td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <div class="total">
            <p>Total: $95.00</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p>Visit us again soon.</p>
        </div>
    </div>
</body>

</html>
