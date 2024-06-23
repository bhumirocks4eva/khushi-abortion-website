document.addEventListener("DOMContentLoaded", function () {
  let forms = document.querySelectorAll(".php-email-form");

  forms.forEach(function (form) {
    form.addEventListener("submit", function (event) {
      event.preventDefault();

      let thisForm = this;

      // Show loading indicator
      let loadingElement = thisForm.querySelector(".loading");
      if (loadingElement) {
        loadingElement.classList.add("d-block");
      }

      // Hide any previous messages
      let sentMessageElement = thisForm.querySelector(".sent-message");
      let errorMessageElement = thisForm.querySelector(".error-message");
      if (sentMessageElement) {
        sentMessageElement.classList.remove("d-block");
      }
      if (errorMessageElement) {
        errorMessageElement.classList.remove("d-block");
      }

      // Validate form fields
      if (!validateForm()) {
        // Hide loading indicator if form validation fails
        if (loadingElement) {
          loadingElement.classList.remove("d-block");
        }
        return false;
      }

      // Proceed with form submission
      let formData = new FormData(thisForm);
      let action = thisForm.getAttribute("action");

      fetch(action, {
        method: "POST",
        body: formData,
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
      })
        .then((response) => {
          if (response.ok) {
            return response.text();
          } else {
            throw new Error(
              `${response.status} ${response.statusText} ${response.url}`
            );
          }
        })
        .then((data) => {
          // Hide loading indicator after submission
          if (loadingElement) {
            loadingElement.classList.remove("d-block");
          }

          // Show success message
          if (data.trim() === "OK") {
            if (sentMessageElement) {
              sentMessageElement.classList.add("d-block");
            }
            thisForm.reset(); // Reset the form after successful submission
          } else {
            throw new Error(
              data
                ? data
                : "Form submission failed and no error message returned from: " +
                  action
            );
          }
        })
        .catch((error) => {
          // Hide loading indicator on error
          if (loadingElement) {
            loadingElement.classList.remove("d-block");
          }

          // Show error message
          if (errorMessageElement) {
            errorMessageElement.classList.add("d-block");
            errorMessageElement.textContent =
              "Failed to send appointment request. Please try again later.";
          }
          console.error("Form submission error:", error);
        });
    });
  });
});

function validateForm() {
  let email = document.getElementById("email").value;
  let phone = document.getElementById("phone").value;
  let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
  let phonePattern = /^(?:\+977)?9[78]\d{8}$/;

  // if (!email.match(emailPattern)) {
  //   alert("Please enter a valid email address.");
  //   return false;
  // }

  if (!phone.match(phonePattern)) {
    alert("Please enter a valid Nepali phone number.");
    return false;
  }

  return true;
}
