document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contactForm");
  const stickyButton = document.querySelector(".sticky-button");
  const formSection = document.getElementById("shopForm");

  if (formSection && stickyButton) {
    console.log("Elements found");

    if ("IntersectionObserver" in window) {
      console.log("IntersectionObserver is supported");
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              stickyButton.style.opacity = "0";
              stickyButton.style.pointerEvents = "none";
              console.log("Form is in view");
            } else {
              stickyButton.style.opacity = "1";
              stickyButton.style.pointerEvents = "auto";
              console.log("Form is out of view");
            }
          });
        },
        { threshold: 0.1 }
      ); // Trigger when 10% of the form is visible

      observer.observe(formSection);
    } else {
      console.warn("IntersectionObserver is not supported in this browser.");
    }
  } else {
    console.error("Form section or sticky button not found");
  }
});
// Form validation
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
