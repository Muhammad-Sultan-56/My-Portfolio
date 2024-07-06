  <!-- Bootstrap js -->
  <script src="./assests/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- fontawsome js -->
  <script src="./assests/fontawesome/js/all.js"></script>

  <script>
      document
          .getElementById("whatsapp-icon")
          .addEventListener("click", function() {
              var phoneNumber = "+923051608550";
              var message = "Hello, I would like to chat with you!"; // Default message
              var whatsappUrl =
                  "https://api.whatsapp.com/send?phone=" +
                  phoneNumber +
                  "&text=" +
                  encodeURIComponent(message);
              window.open(whatsappUrl, "_blank");
          });
  </script>