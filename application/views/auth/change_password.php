<!-- <h1><?php echo lang('change_password_heading'); ?></h1>

<div id="infoMessage"><?php echo $message; ?></div>

<?php echo form_open("auth/change_password"); ?>

      <p>
            <?php echo lang('change_password_old_password_label', 'old_password'); ?> <br />
            <?php echo form_input($old_password); ?>
      </p>

      <p>
            <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length); ?></label> <br />
            <?php echo form_input($new_password); ?>
      </p>

      <p>
            <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm'); ?> <br />
            <?php echo form_input($new_password_confirm); ?>
      </p>

      <?php echo form_input($user_id); ?>
      <p><?php echo form_submit('submit', lang('change_password_submit_btn')); ?></p>

<?php echo form_close(); ?> -->

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <title><?php echo lang('change_password_heading'); ?></title>
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

            .change-box {
                  background: #fff;
                  padding: 2rem;
                  border-radius: 10px;
                  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                  width: 100%;
                  max-width: 500px;
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
      </style>
</head>

<body>
      <div class="container text-center">
            <!-- <div class="mb-3 text-center">
                  <img src="<?= base_url('assets/images/nav_logo_dark.png'); ?>" alt="Logo" style="height: 70px;">
            </div> -->

            <div class="change-box mx-auto">
                  <h1 class="h4 mb-4"><?php echo lang('change_password_heading'); ?></h1>

                  <div id="infoMessage" class="mb-3"><?php echo $message; ?></div>

                  <?php echo form_open("auth/change_password"); ?>

                  <div class="mb-3 text-start position-relative">
                        <label for="old_password" class="form-label">
                              <?php echo lang('change_password_old_password_label', 'old_password'); ?>
                        </label>
                        <?php echo form_input(array_merge($old_password, ['class' => 'form-control', 'id' => 'old_password'])); ?>
                        <span class="toggle-password" onclick="togglePassword('old_password', this)">Show</span>
                  </div>

                  <div class="mb-3 text-start position-relative">
                        <label for="new_password" class="form-label">
                              <?php echo sprintf(lang('change_password_new_password_label'), $min_password_length); ?>
                        </label>
                        <?php echo form_input(array_merge($new_password, ['class' => 'form-control', 'id' => 'new_password'])); ?>
                        <span class="toggle-password" onclick="togglePassword('new_password', this)">Show</span>
                  </div>

                  <div class="mb-3 text-start position-relative">
                        <label for="new_password_confirm" class="form-label">
                              <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm'); ?>
                        </label>
                        <?php echo form_input(array_merge($new_password_confirm, ['class' => 'form-control', 'id' => 'new_password_confirm'])); ?>
                        <span class="toggle-password" onclick="togglePassword('new_password_confirm', this)">Show</span>
                  </div>

                  <?php echo form_input($user_id); ?>

                  <div class="d-grid mt-4">
                        <?php echo form_submit('submit', lang('change_password_submit_btn'), 'class="btn btn-primary btn-block"'); ?>
                  </div>

                  <?php echo form_close(); ?>
            </div>
      </div>

      <script>
            function togglePassword(id, el) {
                  const field = document.getElementById(id);
                  if (field.type === 'password') {
                        field.type = 'text';
                        el.textContent = 'Hide';
                  } else {
                        field.type = 'password';
                        el.textContent = 'Show';
                  }
            }
      </script>

</body>

</html>