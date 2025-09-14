<?php
// ตั้งค่าส่วนหัว (header) เพื่อให้เบราว์เซอร์รับรู้ว่าเป็นการตอบกลับด้วย HTML
header('Content-Type: text/html; charset=utf-8');

// รับข้อมูล JSON จากคำขอ POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// ตรวจสอบว่ามีข้อมูลคำสั่งซื้อหรือไม่
if (isset($data['order']) && !empty($data['order'])) {
    $orderItems = $data['order'];
    
    // สร้างหน้า HTML สำหรับพ่อค้าเพื่อแสดงผลคำสั่งซื้อ
    $htmlOutput = '
    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>สรุปคำสั่งซื้อ</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body { font-family: "Inter", sans-serif; }
        </style>
    </head>
    <body class="bg-gray-100 p-8">
        <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-lg">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">คำสั่งซื้อใหม่</h1>
            <div class="space-y-4">
    ';

    // วนลูปเพื่อสร้าง HTML สำหรับแต่ละรายการในคำสั่งซื้อ
    foreach ($orderItems as $item) {
        $htmlOutput .= '
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg shadow">
                    <img src="' . htmlspecialchars($item['imageUrl']) . '" alt="' . htmlspecialchars($item['name']) . '" class="w-20 h-20 rounded-lg">
                    <div>
                        <p class="font-bold text-lg text-gray-800">' . htmlspecialchars($item['name']) . '</p>
                        <p class="text-gray-600">จำนวนที่สั่ง: ' . htmlspecialchars($item['quantity']) . '</p>
                    </div>
                </div>
        ';
    }

    $htmlOutput .= '
            </div>
            <p class="text-center text-gray-500 mt-6">เวลาที่รับคำสั่งซื้อ: ' . date('Y-m-d H:i:s') . '</p>
        </div>
    </body>
    </html>
    ';

    // ส่งผลลัพธ์ HTML กลับไป
    echo $htmlOutput;

} else {
    // กรณีไม่มีข้อมูลคำสั่งซื้อ
    echo '
    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ไม่มีคำสั่งซื้อ</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body { font-family: "Inter", sans-serif; }
        </style>
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-lg text-center">
            <h1 class="text-3xl font-bold text-red-500 mb-4">ไม่มีข้อมูลคำสั่งซื้อ</h1>
            <p class="text-gray-600">โปรดกลับไปที่หน้าเมนูแล้วลองใหม่อีกครั้ง</p>
        </div>
    </body>
    </html>
    ';
}
?>
