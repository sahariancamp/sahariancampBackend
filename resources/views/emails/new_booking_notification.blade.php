<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        /* .header { background: #0F0F1E; color: #C4A35A; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; } */
        .content { padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f9f9f9; }
        .btn { display: inline-block; background: #25D366; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
                <td align="center" style="padding: 20px;">
                    <img src="https://app.sahariancamp.com/images/logo.png" alt="Saharian Luxury Camp" style="max-width: 150px; height: auto; margin-bottom: 10px; display: block;">
                    <h2 style="margin: 0; color: #C4A35A; font-family: Arial, sans-serif;">New Booking Request Received !</h2>
                </td>
            </tr>
        </table>
        <div class="content">
            <p>Hello Admin,</p>
            <p>A new booking request has just been submitted on the website.</p>
            
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

            <h3 style="margin-top: 30px;">Customer Details:</h3>
            <table>
                <tr>
                    <th>Type</th>
                    <td><strong>{{ strtoupper($booking->booking_type) }}</strong></td>
                </tr>
                <tr>
                    <th>Name / Agency</th>
                    <td>{{ $booking->customer_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $booking->customer_email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $booking->customer_phone ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Check-in</th>
                    <td>{{ $booking->check_in }}</td>
                </tr>
                <tr>
                    <th>Check-out</th>
                    <td>{{ $booking->check_out ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Total Price</th>
                    <td>${{ number_format($booking->total_price, 2) }}</td>
                </tr>
            </table>

            @php
                // Format phone for WhatsApp link (remove +, spaces, leading 0s)
                $cleanPhone = preg_replace('/[^0-9]/', '', $booking->customer_phone);
                // Basic message
                $message = urlencode("Hello " . $booking->customer_name . ",\nWe have received your booking request (" . $booking->booking_number . ") for Saharian Camp.");
                $waLink = "https://wa.me/" . $cleanPhone . "?text=" . $message;
            @endphp

            @if($booking->customer_phone)
                <div style="text-align: center;">
                    <a href="{{ $waLink }}" class="btn">Contact via WhatsApp</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
