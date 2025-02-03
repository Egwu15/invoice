<div
    style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; background-color: #f9f9f9;">
    <h1 style="color: #333; text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px;">Invoice
        #{{ $invoice->invoice_number }}</h1>

    @if ($invoice->due_date)
        <p style="font-size: 14px; color: #555;"><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
    @endif

    <p style="font-size: 14px; color: #555;"><strong>Total:</strong> ${{ number_format($invoice->total_amount, 2) }}</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th
                    style="background-color: #333; color: #fff; padding: 10px; text-align: left; border: 1px solid #ddd;">
                    Description</th>
                <th
                    style="background-color: #333; color: #fff; padding: 10px; text-align: right; border: 1px solid #ddd;">
                    Quantity</th>
                <th
                    style="background-color: #333; color: #fff; padding: 10px; text-align: right; border: 1px solid #ddd;">
                    Unit Price</th>
                <th
                    style="background-color: #333; color: #fff; padding: 10px; text-align: right; border: 1px solid #ddd;">
                    Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->invoiceItems as $item)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $item->description }}</td>
                    <td style="padding: 10px; text-align: right; border: 1px solid #ddd;">{{ $item->quantity }}</td>
                    <td style="padding: 10px; text-align: right; border: 1px solid #ddd;">
                        ${{ number_format($item->price, 2) }}</td>
                    <td style="padding: 10px; text-align: right; border: 1px solid #ddd;">
                        ${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="font-size: 14px; color: #555; margin-top: 20px;"><strong>Paid:</strong>
        ${{ number_format($invoice->total_paid, 2) }} / <strong>Total:</strong>
        ${{ number_format($invoice->total_amount, 2) }}</p>
</div>
