<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Access Granted - Early Theory</title>
  <style>
    @media only screen and (max-width: 600px) {
      .container {
        width: 100% !important;
      }

      .col-half {
        display: block !important;
        width: 100% !important;
        padding: 0 0 12px 0 !important;
      }

      .hero-img {
        border-radius: 8px !important;
      }
    }
  </style>
</head>

<body style="margin:0;padding:0;background:#f0ece8;font-family:Georgia,'Times New Roman',serif;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f0ece8;">
    <tr>
      <td align="center" style="padding:32px 16px;">

        <table class="container" width="620" cellpadding="0" cellspacing="0" border="0"
          style="background:#1a0f2e;border-radius:16px;overflow:hidden;box-shadow:0 4px 32px rgba(0,0,0,0.25);">

          <!-- Hero Image -->
          <tr>
            <td style="padding:0;">
              <img class="hero-img" src="https://earlytheory.com/images/EMAILGRANTACCESS.jpg" alt="Access Granted"
                width="620" style="display:block;width:100%;border-radius:16px 16px 0 0;">
            </td>
          </tr>

          <!-- Header -->
          <tr>
            <td style="background:#e6ff19;padding:28px 40px;text-align:center;">
              <p
                style="margin:0;color:#1a0f2e;font-family:Helvetica,Arial,sans-serif;font-size:13px;letter-spacing:3px;text-transform:uppercase;font-weight:bold;">
                Early Theory</p>
              <h1
                style="margin:8px 0 0 0;color:#1a0f2e;font-family:Georgia,serif;font-size:28px;font-weight:normal;letter-spacing:1px;">
                Access Granted</h1>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:40px;background:#1a0f2e;">

              <!-- Intro text -->
              <p
                style="margin:0 0 28px 0;font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#c5bada;line-height:1.7;">
                Hi <strong style="color:#e6ff19;">{{ $sales->user->name }}</strong>, your access has been activated.
                Below are your account details for reference.
              </p>

              <!-- Info Cards -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td class="col-half" width="50%" style="padding-right:10px;vertical-align:top;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0"
                      style="background:#2d1a52;border-radius:10px;border-left:4px solid #e6ff19;">
                      <tr>
                        <td style="padding:18px 20px;">
                          <p
                            style="margin:0 0 4px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">
                            Sales Number</p>
                          <p
                            style="margin:0 0 16px 0;font-family:Georgia,serif;font-size:15px;color:#e6ff19;font-weight:bold;">
                            {{ $sales->sales_no }}</p>
                          <p
                            style="margin:0 0 4px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">
                            Full Name</p>
                          <p style="margin:0;font-family:Georgia,serif;font-size:15px;color:#ffffff;">
                            {{ $sales->user->name }}</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td class="col-half" width="50%" style="padding-left:10px;vertical-align:top;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0"
                      style="background:#2d1a52;border-radius:10px;border-left:4px solid #9b7dca;">
                      <tr>
                        <td style="padding:18px 20px;">
                          <p
                            style="margin:0 0 4px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">
                            Email Address</p>
                          <p style="margin:0 0 16px 0;font-family:Georgia,serif;font-size:15px;color:#ffffff;">
                            {{ $sales->user->email }}</p>
                          <p
                            style="margin:0 0 4px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">
                            Phone Number</p>
                          <p style="margin:0;font-family:Georgia,serif;font-size:15px;color:#ffffff;">
                            {{ $sales->user->phone }}</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:32px 40px 40px 40px;text-align:center;background:#1a0f2e;border-top:1px solid #2d1a52;">
              <img src="https://earlytheory.com/images/MainLogo.png" alt="Early Theory" width="160"
                style="display:inline-block;max-width:160px;">
              <p
                style="margin:16px 0 0 0;font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#6b4fa8;letter-spacing:1px;">
                Questions? Reply to this email and we'll be happy to help.</p>
            </td>
          </tr>

        </table>

        <p
          style="margin:20px 0 0 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#a89db8;text-align:center;letter-spacing:1px;">
          Early Theory &mdash; earlytheory.com</p>

      </td>
    </tr>
  </table>

</body>

</html>