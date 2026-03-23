<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation - Early Theory</title>
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

      .order-table th,
      .order-table td {
        font-size: 13px !important;
        padding: 10px 8px !important;
      }
    }
  </style>
</head>

<body style="margin:0;padding:0;background:#f0ece8;font-family:Georgia,'Times New Roman',serif;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f0ece8;">
    <tr>
      <td align="center" style="padding:32px 16px;">

        <table class="container" width="620" cellpadding="0" cellspacing="0" border="0"
          style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 32px rgba(74,41,132,0.10);">

          <!-- Hero Image -->
          <tr>
            <td style="padding:0;">
              <img class="hero-img" src="https://earlytheory.com/images/OrderEmailConf.jpg" alt="Order Confirmation"
                width="620" style="display:block;width:100%;border-radius:16px 16px 0 0;">
            </td>
          </tr>

          <!-- Header -->
          <tr>
            <td style="background:#4A2984;padding:28px 40px;text-align:center;">
              <p
                style="margin:0;color:#e8dff7;font-family:Georgia,serif;font-size:13px;letter-spacing:3px;text-transform:uppercase;">
                Thank you for your order</p>
              <h1
                style="margin:8px 0 0 0;color:#ffffff;font-family:Georgia,serif;font-size:28px;font-weight:normal;letter-spacing:1px;">
                Order Confirmed</h1>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:40px 40px 0 40px;">

              <!-- Order Info Cards -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td class="col-half" width="50%" style="padding-right:10px;vertical-align:top;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0"
                      style="background:#f7f4fc;border-radius:10px;border-left:4px solid #4A2984;">
                      <tr>
                        <td style="padding:18px 20px;">
                          <p
                            style="margin:0 0 4px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">
                            Sales Number</p>
                          <p
                            style="margin:0 0 16px 0;font-family:Georgia,serif;font-size:15px;color:#2d1a52;font-weight:bold;">
                            #{{ $sales->sales_no }}</p>
                          <p
                            style="margin:0 0 4px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">
                            Full Name</p>
                          <p style="margin:0;font-family:Georgia,serif;font-size:15px;color:#2d1a52;">
                            {{ $sales->user->name }}
                          </p>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td class="col-half" width="50%" style="padding-left:10px;vertical-align:top;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0"
                      style="background:#f7f4fc;border-radius:10px;border-left:4px solid #9b7dca;">
                      <tr>
                        <td style="padding:18px 20px;">
                          <p
                            style="margin:0 0 4px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">
                            Email Address</p>
                          <p style="margin:0 0 16px 0;font-family:Georgia,serif;font-size:15px;color:#2d1a52;">
                            {{ $sales->user->email }}
                          </p>
                          <p
                            style="margin:0 0 4px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">
                            Phone Number</p>
                          <p style="margin:0;font-family:Georgia,serif;font-size:15px;color:#2d1a52;">
                            {{ $sales->user->phone }}
                          </p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- Order Details -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:32px;">
                <tr>
                  <td>
                    <p
                      style="margin:0 0 16px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;letter-spacing:3px;text-transform:uppercase;color:#4A2984;">
                      Order Details</p>
                  </td>
                </tr>
              </table>

              <table class="order-table" width="100%" cellpadding="0" cellspacing="0" border="0"
                style="border-collapse:collapse;">
                <thead>
                  <tr style="background:#4A2984;">
                    <th
                      style="padding:12px 16px;text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;color:#e8dff7;font-weight:normal;border-radius:8px 0 0 0;">
                      Item</th>
                    <th
                      style="padding:12px 16px;text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;color:#e8dff7;font-weight:normal;">
                      Qty</th>
                    <th
                      style="padding:12px 16px;text-align:right;font-family:Helvetica,Arial,sans-serif;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;color:#e8dff7;font-weight:normal;border-radius:0 8px 0 0;">
                      Price</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($sales->products as $product)
                    <tr style="border-bottom:1px solid #ede9f5;">
                      <td style="padding:14px 16px;font-family:Georgia,serif;font-size:15px;color:#2d1a52;">
                        {{ $product->title }}
                      </td>
                      <td
                        style="padding:14px 16px;text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#6b4fa8;">
                        {{ $product->pivot->qty }}
                      </td>
                      <td
                        style="padding:14px 16px;text-align:right;font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#2d1a52;">
                        IDR {{ number_format($product->price) }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr style="background:#f7f4fc;">
                    <td colspan="2"
                      style="padding:16px 16px;font-family:Helvetica,Arial,sans-serif;font-size:13px;letter-spacing:1px;text-transform:uppercase;color:#4A2984;font-weight:bold;">
                      Total</td>
                    <td
                      style="padding:16px 16px;text-align:right;font-family:Georgia,serif;font-size:17px;color:#4A2984;font-weight:bold;">
                      IDR {{ number_format($sales->total_price) }}</td>
                  </tr>
                </tfoot>
              </table>

            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:40px;text-align:center;">
              <img src="https://earlytheory.com/images/MainLogo.png" alt="Early Theory" width="160"
                style="display:inline-block;max-width:160px;">
            </td>
          </tr>

        </table>

        <!-- Below email note -->
        <p
          style="margin:20px 0 0 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#a89db8;text-align:center;letter-spacing:1px;">
          Early Theory &mdash; earlytheory.com</p>

      </td>
    </tr>
  </table>

</body>

</html>