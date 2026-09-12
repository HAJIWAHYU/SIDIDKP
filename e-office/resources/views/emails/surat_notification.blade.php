<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat / Disposisi Baru</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            background-color: #f8fafc;
            padding: 40px 0;
        }
        .container {
            max-width: 580px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #4f46e5;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .content {
            padding: 30px;
        }
        .content h2 {
            color: #1e293b;
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 12px;
            font-weight: 600;
        }
        .content p {
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .btn-container {
            text-align: center;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
            transition: background-color 0.2s;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <h1>E-Office System</h1>
            </div>

            <!-- Content -->
            <div class="content">
                <h2>Halo {{ $surat->penerima->name }},</h2>
                <p>Ada surat atau disposisi baru nih yang masuk ke akun E-Office kamu.</p>

                <!-- Call to Action -->
                <div class="btn-container">
                    <a href="sididkpsumsel.web.id" class="btn" target="_blank">Cek E-Office Sekarang</a>
                </div>
                
                <p style="margin-top: 25px; margin-bottom: 0;">Terima kasih ya!</p>
            </div>
        </div>
    </div>
</body>
</html>
