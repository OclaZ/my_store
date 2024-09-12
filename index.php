<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Vetrasolution - Shilajit Landing Page</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="container">
    <!-- Image Section -->
    <div class="image-section">
        <img src="img/1.png" alt="Vetrasolution - Shilajit" class="responsive-image">
    </div>

    <!-- Form Section -->
    <div class="form-section">
        <form id="contactForm" action="submit.php" method="POST">
            <label for="name">الاسم:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">العنوان</label>
            <input type="text" id="email" name="email" required>

            <label for="phone">رقم الهاتف:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="packs">اختر عدد الحزم:</label><br>
            <select id="packs" name="packs">
                <option value="1 pack - 199 DH"> حزمة واحدة - 199 درهم</option>
                <option value="2 packs - 349 DH"> حزم 2  - 349 درهم</option>
                <option value="5 packs - 750 DH"> حزم  5  - 750 درهم</option>
            </select>

            <button type="submit">إرسال</button>
        </form>
    </div>

    <!-- Scripts -->
    <script src="script/script.js"></script>
</div>
</body>
</html>
