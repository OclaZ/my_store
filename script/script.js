document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contactForm");

  form.addEventListener("submit", function (event) {
    let isValid = true;

    // Custom form validation
    const phoneInput = document.getElementById("phone");
    const phoneRegex = /^[0-9]+$/; // Ensures phone is only numbers

    if (!phoneRegex.test(phoneInput.value)) {
      isValid = false;
      alert("يرجى إدخال رقم هاتف صحيح.");
      event.preventDefault(); // Stop form submission if invalid
    }

    if (isValid) {
      alert("تم إرسال بياناتك بنجاح!");
    }
  });
});
