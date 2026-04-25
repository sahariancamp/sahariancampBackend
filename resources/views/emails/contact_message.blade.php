<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .info-box { background: #f9f9f9; padding: 15px; border-radius: 5px; border-left: 4px solid #C4A35A; margin-bottom: 20px; }
        .label { font-weight: bold; color: #0F0F1E; }
    </style>
</head>
<body>
    <div class="container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
                <td align="center" style="padding: 20px;">
                    <img src="https://app.sahariancamp.com/images/logo.png" alt="Saharian Luxury Camp" style="max-width: 150px; height: auto; margin-bottom: 10px; display: block;">
                    <h2 style="margin: 0; color: #C4A35A; font-family: Arial, sans-serif;">New Contact Message</h2>
                </td>
            </tr>
        </table>
        <div class="content">
            <p>Hello {{ \App\Models\User::first()->name ?? 'Admin' }},</p>
            <p>You have received a new message from the contact form on the website.</p>
            
            <div class="info-box">
                <p><span class="label">Sender Name:</span> {{ $data['name'] }}</p>
                <p><span class="label">Sender Email:</span> {{ $data['email'] }}</p>
                <p><span class="label">Subject:</span> {{ $data['subject'] }}</p>
            </div>

            <div style="margin-top: 20px;">
                <h3 style="color: #C4A35A; border-bottom: 1px solid #eee; pb: 5px;">Message:</h3>
                <p style="white-space: pre-wrap;">{{ $data['message'] }}</p>
            </div>

            <p style="margin-top: 30px; font-size: 12px; color: #999;">
                This message was sent from the Saharian Camp contact form.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Saharian Luxury Camp. All rights reserved.
        </div>
    </div>
</body>
</html>
