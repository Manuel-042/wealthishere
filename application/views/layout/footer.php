<footer class="footer">
  <div class="container">
    <div class="row text-center text-lg-start">
      <!-- <div class="col-lg-3 mb-4 mb-lg-0">
            <img
              src="./assets/images/nav_logo.png"
              alt="Wealth is Here Logo White"
              class="img-fluid mb-3"
              style="max-height: 60px" loading="lazy"
              onerror="this.onerror=null;this.src='https://placehold.co/220x70/FFFFFF/003366?text=Logo';" />
            <p>
              Empowering the next generation of agricultural leaders in Nigeria.
            </p>
          </div> -->
      <div class="col-12 col-lg-4 mb-4 mb-lg-0">
        <h5>Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="<?= site_url('index') ?>">Home</a></li>
          <li><a href="<?= site_url('about') ?>">About</a></li>
          <li><a href="<?= site_url('f4f') ?>">Farmers for the Future</a></li>
          <li>
            <a href="<?= site_url('gap') ?>">Graduate Agripreneur Program</a>
          </li>
          <li><a href="<?= site_url('faq') ?>">FAQs</a></li>
          <li class="mb-lg-4">
            <a href="<?= base_url('assets/files/Privacy Policy for the Farmers for Future.pdf') ?>"
              target="_blank">Privacy policy</a>
          </li>
          <li class="mb-lg-4">
            <a href="<?= base_url('assets/files/YEEP Support Guide.pdf') ?>"
              target="_blank">YEEP Support Guide</a>
          </li>
        </ul>
      </div>

      <div class="col-12 col-lg-4 mb-4 mb-lg-0">
        <h5>Contact Us</h5>
        <div class="social-icons mt-3">
          <a href="https://www.instagram.com/batnfoundation/"><i class="fab fa-instagram"></i></a>
          <a href="https://web.facebook.com/BATNFoundation/?_rdc=1&_rdr#"><i class="fab fa-facebook-f"></i></a>
          <a href="https://x.com/BATNFoundation/"><i class="fa-brands fa-x-twitter"></i></a>
          <a href="https://www.linkedin.com/showcase/batn-foundation/about/"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://www.youtube.com/channel/UCektzc9hBeVRLPqEsQuqfzQ"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      <div class="col-12 col-lg-4 mb-4 mb-lg-0">
        <h5>Sign up for our newsletter</h5>
        <p>Stay up to date with our programs</p>
        <form class="newsletter-form">
          <div class="input-group">
            <input type="email" name="email" class="form-control" placeholder="Your email address" autocomplete="email"
              required />
            <span id="subscribe_btn" class="btn btn-dark" type="submit">Sign Up
              <img src="<?= base_url('assets/images/sign_up_button.png') ?>" alt="" class="img-fluid ms-2" /></span>
          </div>
        </form>
      </div>
    </div>
    <div class="border-top text-center pt-1">
      <p>
        &copy; <?= date('Y') ?> British American Tobacco
        Nigeria Foundation. All Rights Reserved.
      </p>
    </div>
  </div>
</footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<!-- Custom JS -->
<script src="<?= base_url('assets/js/script.js') ?>"></script>

<script>
  // Declare the base URL in JS from PHP
  const baseUrl = "<?php echo base_url(); ?>";
</script>


<script>
  // Newsletter subscription placeholder (as in previous pages)
  document.getElementById("subscribe_btn").addEventListener("click", async function () {
    const emailInput = this.closest(".input-group").querySelector('input[type="email"]');

    if (emailInput.checkValidity()) {
      try {
        const response = await fetch(`${baseUrl}/api/subscribe`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "API-key": "d84f2a9e7c4b5e1a3f2d7e4b6c8a9012",
          },
          body: JSON.stringify({
            email: emailInput.value,
          }),
        });

        const responseData = await response.json();

        if (response.ok) {
          Swal.fire({
            title: "Successful",
            text: responseData.message || "You have successfully subscribed for our newsletter",
            icon: "success",
          }).then(() => {
            emailInput.value = "";
            window.location.reload();
          });
        } else {
          Swal.fire({
            title: "Newsletter subscription failed",
            text: `${responseData.error || response.statusText}`,
            icon: "error",
          }).then(() => {
            emailInput.value = "";
            window.location.reload();
          });
        }
      } catch (error) {
        Swal.fire({
          title: "Network or Submission Error",
          text: "An error occurred during submission. Please try again.",
          icon: "error",
        }).then(() => {
          emailInput.value = "";
          window.location.reload();
        });
      }
    } else {
      Swal.fire({
        title: "Invalid Email",
        text: "Please enter a valid email.",
        icon: "error",
      }).then(() => {
        emailInput.value = "";
      });
    }
  });


</script>
</body>

</html>