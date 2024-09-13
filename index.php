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
        <img src="img/2.png" alt="Vetrasolution - Shilajit" class="responsive-image">
    </div>

    <!-- Form Section -->
    <div class="form-section" id="shopForm">
        <form id="contactForm" action="submit.php" method="POST">
            <label for="name">الاسم:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">العنوان:</label>
            <input type="text" id="email" name="email" required>

            <label for="phone">رقم الهاتف:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="packs">اختر عدد الحزم:</label><br>
            <select id="packs" name="packs">
                <option value="1 pack - 199 DH"> حزمة واحدة - 199 درهم</option>
                <option value="2 packs - 349 DH"> حزم 2 - 349 درهم</option>
                <option value="5 packs - 750 DH"> حزم 5 - 750 درهم</option>
            </select>

            <button type="submit">إرسال</button>
        </form>
    </div>

    <!-- Sticky Shop Now Button -->
    <a href="#shopForm" class="sticky-button">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        <span>تسوق الآن</span>
        <span class="discount-text">خصم 20٪</span>
    </a>

    <!-- Scripts -->
    <script src="script/script.js"></script>
</div>
</body>
</html>
