<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Order - Early Theory Admin</title>
  <style>
    @media only screen and (max-width: 600px) {
      .container { width: 100% !important; }
      .col-half { display: block !important; width: 100% !important; padding: 0 0 12px 0 !important; }
      .order-table th, .order-table td { font-size: 12px !important; padding: 8px 6px !important; }
    }
  </style>
</head>
<body style="margin:0;padding:0;background:#f0ece8;font-family:Helvetica,Arial,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f0ece8;">
    <tr>
      <td align="center" style="padding:32px 16px;">

        <table class="container" width="620" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 32px rgba(74,41,132,0.10);">

          <!-- Header -->
          <tr>
            <td style="background:#4A2984;padding:24px 40px;">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="vertical-align:middle;">
                    <img src="https://earlytheory.com/images/MainLogo.png" alt="Early Theory" width="120" style="display:block;max-width:120px;">
                  </td>
                  <td style="vertical-align:middle;text-align:right;">
                    <p style="margin:0;color:#e8dff7;font-size:11px;letter-spacing:2px;text-transform:uppercase;">Admin Notification</p>
                    <p style="margin:4px 0 0 0;color:#e6ff19;font-family:Georgia,serif;font-size:20px;font-weight:normal;">New Order Received</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:36px 40px 0 40px;">

              <!-- Info Cards -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                <tr>
                  <td class="col-half" width="50%" style="padding-right:10px;vertical-align:top;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f7f4fc;border-radius:10px;border-left:4px solid #4A2984;">
                      <tr>
                        <td style="padding:16px 18px;">
                          <p style="margin:0 0 3px 0;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">Sales Number</p>
                          <p style="margin:0 0 14px 0;font-family:Georgia,serif;font-size:15px;color:#2d1a52;font-weight:bold;">{{ $sales->sales_no }}</p>
                          <p style="margin:0 0 3px 0;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">Full Name</p>
                          <p style="margin:0;font-size:15px;color:#2d1a52;">{{ $sales->user->name }}</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td class="col-half" width="50%" style="padding-left:10px;vertical-align:top;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f7f4fc;border-radius:10px;border-left:4px solid #9b7dca;">
                      <tr>
                        <td style="padding:16px 18px;">
                          <p style="margin:0 0 3px 0;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">Email Address</p>
                          <p style="margin:0 0 14px 0;font-size:15px;color:#2d1a52;">{{ $sales->user->email }}</p>
                          <p style="margin:0 0 3px 0;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#9b7dca;">Phone Number</p>
                          <p style="margin:0;font-size:15px;color:#2d1a52;">{{ $sales->user->phone }}</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- Section Label -->
              <p style="margin:0 0 14px 0;font-size:10px;letter-spacing:3px;text-transform:uppercase;color:#4A2984;">Order Details</p>

              <!-- Order Table -->
              <table class="order-table" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                <thead>
                  <tr style="background:#4A2984;">
                    <th style="padding:11px 14px;text-align:left;font-size:11px;letter-spacing:1px;text-transform:uppercase;color:#e8dff7;font-weight:normal;">Item</th>
                    <th style="padding:11px 8px;text-align:center;font-size:11px;letter-spacing:1px;text-transform:uppercase;color:#e8dff7;font-weight:normal;">Qty</th>
                    <th style="padding:11px 14px;text-align:right;font-size:11px;letter-spacing:1px;text-transform:uppercase;color:#e8dff7;font-weight:normal;">Price</th>
                    <th style="padding:11px 14px;text-align:left;font-size:11px;letter-spacing:1px;text-transform:uppercase;color:#e8dff7;font-weight:normal;">Question</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($sales->skus as $item)
                      <tr style="border-bottom:1px solid #ede9f5;">
                        <td style="padding:13px 14px;font-size:14px;color:#2d1a52;">{{ $item->products->title }}</td>
                        <td style="padding:13px 8px;text-align:center;font-size:14px;color:#6b4fa8;">{{ $item->pivot->qty }}</td>
                        <td style="padding:13px 14px;text-align:right;font-size:14px;color:#2d1a52;">IDR {{ number_format($item->products->price) }}</td>
                        <td style="padding:13px 14px;font-size:13px;color:#5a5068;font-style:italic;">{{ $item->pivot->question }}</td>
                      </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr style="background:#f7f4fc;">
                    <td colspan="2" style="padding:14px;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#4A2984;font-weight:bold;">Subtotal</td>
                    <td style="padding:14px;text-align:right;font-family:Georgia,serif;font-size:17px;color:#4A2984;font-weight:bold;">IDR {{ number_format($sales->total_price) }}</td>
                    <td style="padding:14px;"></td>
                  </tr>
                </tfoot>
              </table>

            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:28px 40px 36px 40px;text-align:center;border-top:1px solid #ede9f5;margin-top:32px;">
              <p style="margin:0;font-size:13px;color:#5a5068;">
                Seluruh data penjualan bisa dilihat di
                <a href="https://earlytheory.com/admin/sales" style="color:#4A2984;font-weight:bold;text-decoration:none;">Early Theory &rarr; Sales</a>
              </p>
            </td>
          </tr>

        </table>

        <p style="margin:20px 0 0 0;font-size:11px;color:#a89db8;text-align:center;letter-spacing:1px;">Early Theory &mdash; earlytheory.com</p>

      </td>
    </tr>
  </table>

</body>
</html>