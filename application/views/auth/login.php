<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php echo lang('login_heading'); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f4f4;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;

      background-image: url("<?= base_url('assets/images/auth_image.jpeg'); ?>");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;

      position: relative;
      z-index: 1;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;

      background: rgba(0, 0, 0, 0.3);
      z-index: -1;
    }

    .login-box {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .toggle-password {
      position: absolute;
      right: 15px;
      top: 38px;
      cursor: pointer;
      color: #6c757d;
      font-size: 0.9rem;
    }

    #infoMessage {
      color: red;
    }

    .form-check-label,
    .forgot-link {
      font-size: 0.85rem;
    }

    .register-link {
      text-decoration: underline;
    }

    .register {
      font-size: 0.875rem;
      text-align: center;
      margin-top: 1rem;
    }

    .alert-success {
      background-color: #d1e7dd;
      color: #0f5132;
      border: 1px solid #badbcc;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #842029;
      border: 1px solid #f5c2c7;
    }

    .alert p {
      margin-bottom: 0 !important;
    }
  </style>
</head>

<body>

  <div class="container text-center">
    <!-- <div class="logo mb-3">
      <img src="<?= base_url('assets/images/nav_logo_dark.png'); ?>" alt="BATNF Logo" style="height: 80px;">
    </div> -->

    <div class="login-box mx-auto">
      <h1 class="h4 mb-2"><?php echo lang('login_heading'); ?></h1>
      <p class="text-muted mb-4"><?php echo lang('login_subheading'); ?></p>

      <!-- <div id="infoMessage" class="mb-3"><?php echo $message; ?></div> -->

      <?php if (isset($message) && !empty($message)): ?>
        <?php
        $is_error = isset($message) ? (
          stripos($message, 'invalid') !== false ||
          stripos($message, 'inactive') !== false ||
          stripos($message, 'failed') !== false ||
          stripos($message, 'incorrect') !== false ||
          stripos($message, 'error') !== false
        ) : false;

        $alert_class = $is_error ? 'alert-danger' : 'alert-success';
        ?>
        <div class="alert <?= $alert_class ?> alert-dismissible fade show" role="alert">
          <?= $message; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php echo form_open("auth/login"); ?>

      <div class="mb-3 text-start">
        <label for="identity" class="form-label"><?php echo lang('login_identity_label', 'identity'); ?></label>
        <?php echo form_input(array_merge($identity, ['class' => 'form-control', 'id' => 'identity'])); ?>
      </div>

      <div class="mb-3 text-start position-relative">
        <label for="password" class="form-label"><?php echo lang('login_password_label', 'password'); ?></label>
        <?php echo form_input(array_merge($password, ['class' => 'form-control', 'id' => 'password'])); ?>
        <span class="toggle-password" onclick="togglePassword()">Show</span>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <?php echo form_checkbox('remember', '1', FALSE, 'id="remember" class="form-check-input"'); ?>
          <label class="form-check-label" for="remember"><?php echo lang('login_remember_label', 'remember'); ?></label>
        </div>
        <div>
          <a class='forgot-link'
            href="<?= site_url('forgot_password'); ?>"><?php echo lang('login_forgot_password'); ?></a>
        </div>
      </div>

      <div class="d-grid">
        <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-primary btn-block"'); ?>
      </div>

      <div class="register mt-3">
        Don't have an account? <a class="register-link" href="<?= site_url('register') ?>"
          class="text-decoration-none">Register here</a>
      </div>

      <?php echo form_close(); ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById("password");
      const toggleBtn = document.querySelector(".toggle-password");

      if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleBtn.textContent = "Hide";
      } else {
        passwordField.type = "password";
        toggleBtn.textContent = "Show";
      }
    }
  </script>

</body>

</html>