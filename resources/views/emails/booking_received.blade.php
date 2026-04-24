<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f9f9f9; }
    </style>
</head>
<body>
    <div class="container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
                <td align="center" style="padding: 20px;">
                    <img src="https://app.sahariancamp.com/images/logo.png" alt="Saharian Luxury Camp" style="max-width: 200px; height: auto; display: block;">
                </td>
            </tr>
        </table>
        <div class="content">
            <p>Dear {{ $booking->customer_name }},</p>
            <p>Thank you for choosing Saharian Luxury Camp! We have received your booking request (<strong>{{ $booking->booking_number }}</strong>).</p>
            <p>Please note that your booking is currently <strong>Under Review</strong>. Our team will contact you shortly to confirm availability and finalize the reservation.</p>
            
            <h3 style="margin-top: 30px;">Selected Tents:</h3>
            <table>
                <tr>
                    <th>Tent</th>
                    <th>Quantity</th>
                </tr>
                @foreach($booking->items as $item)
                <tr>
                    <td>{{ $item->bookable->name ?? 'Accommodation' }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
                @endforeach
            </table>

            <h3 style="margin-top: 30px;">Booking Summary:</h3>
            <table>
                <tr>
                    <th>Type</th>
                    <td>{{ ucfirst($booking->booking_type) }}</td>
                </tr>
                <tr>
                    <th>Check-in</th>
                    <td>{{ $booking->check_in }}</td>
                </tr>
                <tr>
                    <th>Check-out</th>
                    <td>{{ $booking->check_out ?? 'Not specified' }}</td>
                </tr>
                <tr>
                    <th>Total Estimated Price</th>
                    <td>${{ number_format($booking->total_price, 2) }}</td>
                </tr>
            </table>

            <p style="margin-top: 20px;">If you have any urgent questions, feel free to contact us.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Saharian Luxury Camp. All rights reserved.
        </div>
    </div>
</body>
</html>
