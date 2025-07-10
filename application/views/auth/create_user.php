<!-- <h1><?php echo lang('create_user_heading'); ?></h1>
<p><?php echo lang('create_user_subheading'); ?></p>

<div id="infoMessage"><?php echo $message; ?></div>

<?php echo form_open("auth/create_user"); ?>

      <p>
            <?php echo lang('create_user_fname_label', 'first_name'); ?> <br />
            <?php echo form_input($first_name); ?>
      </p>

      <p>
            <?php echo lang('create_user_lname_label', 'last_name'); ?> <br />
            <?php echo form_input($last_name); ?>
      </p>
      
      <?php
      if ($identity_column !== 'email') {
            echo '<p>';
            echo lang('create_user_identity_label', 'identity');
            echo '<br />';
            echo form_error('identity');
            echo form_input($identity);
            echo '</p>';
      }
      ?>

      <p>
            <?php echo lang('create_user_company_label', 'company'); ?> <br />
            <?php echo form_input($company); ?>
      </p>

      <p>
            <?php echo lang('create_user_email_label', 'email'); ?> <br />
            <?php echo form_input($email); ?>
      </p>

      <p>
            <?php echo lang('create_user_phone_label', 'phone'); ?> <br />
            <?php echo form_input($phone); ?>
      </p>

      <p>
            <?php echo lang('create_user_password_label', 'password'); ?> <br />
            <?php echo form_input($password); ?>
      </p>

      <p>
            <?php echo lang('create_user_password_confirm_label', 'password_confirm'); ?> <br />
            <?php echo form_input($password_confirm); ?>
      </p>


      <p><?php echo form_submit('submit', lang('create_user_submit_btn')); ?></p>

<?php echo form_close(); ?> -->

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <title><?php echo lang('create_user_heading'); ?></title>
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

            .form-wrapper {
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  height: 100vh;
                  flex-direction: column;
                  padding: 20px;
            }

            .form-box {
                  background: #fff;
                  padding: 30px;
                  border-radius: 10px;
                  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                  width: 100%;
                  max-width: 800px;
            }

            .toggle-password {
                  position: absolute;
                  right: 20px;
                  top: 38px;
                  cursor: pointer;
                  color: #6c757d;
                  font-size: 0.9rem;
            }

            /*  .toggle-password {
                  cursor: pointer;
                  font-size: 0.9rem;
                  color: #007bff;
                  user-select: none;
                  position: absolute;
                  right: 15px;
                  top: 50%;
                  transform: translate(-10%, 15%);
            }*/

            .position-relative input {
                  padding-right: 70px;
            }

            #infoMessage {
                  color: red;
            }

            .createbtn {
                  margin-top: 3rem;
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

      <div class="form-wrapper">
            <!-- <div class="mb-3 text-center">
                  <img src="<?= base_url('assets/images/nav_logo_dark.png'); ?>" alt="Logo" style="height: 70px;">
            </div> -->

            <div class="form-box">
                  <h2 class="mb-3 text-center"><?php echo lang('create_user_heading'); ?></h2>
                  <p class="mb-3 text-center"><?php echo lang('create_user_subheading'); ?></p>

                  <!-- <div id="infoMessage"><?php echo $message; ?></div> -->

                  <?php if (isset($message) && !empty($message)): ?>
                        <?php
                        $is_error = $message_type === 'danger';

                        $alert_class = $is_error ? 'alert-danger' : 'alert-success';
                        ?>
                        <div class="alert <?= $alert_class ?> alert-dismissible fade show" role="alert">
                              <?= $message; ?>
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                  <?php endif; ?>

                  <?php echo form_open("auth/create_user"); ?>

                  <div class="row">
                        <div class="col-md-6 mb-3">
                              <label
                                    class="form-label"><?php echo lang('create_user_fname_label', 'first_name'); ?></label>
                              <?php echo form_input($first_name, '', 'class="form-control"'); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                              <label
                                    class="form-label"><?php echo lang('create_user_lname_label', 'last_name'); ?></label>
                              <?php echo form_input($last_name, '', 'class="form-control"'); ?>
                        </div>

                        <?php if ($identity_column !== 'email'): ?>
                              <div class="col-md-12 mb-3">
                                    <label
                                          class="form-label"><?php echo lang('create_user_identity_label', 'identity'); ?></label>
                                    <?php echo form_error('identity'); ?>
                                    <?php echo form_input($identity, '', 'class="form-control"'); ?>
                              </div>
                        <?php endif; ?>

                        <div class="col-md-6 mb-3">
                              <label class="form-label"><?php echo lang('create_user_email_label', 'email'); ?></label>
                              <?php echo form_input($email, '', 'class="form-control"'); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                              <label class="form-label"><?php echo lang('create_user_phone_label', 'phone'); ?></label>
                              <?php echo form_input($phone, '', 'class="form-control"'); ?>
                        </div>

                        <div class="col-md-6 mb-3 position-relative">
                              <label
                                    class="form-label"><?php echo lang('create_user_password_label', 'password'); ?></label>
                              <?php echo form_input(array_merge($password, ['id' => 'password', 'class' => 'form-control'])); ?>
                              <span class="toggle-password" onclick="togglePassword('password', this)">Show</span>
                        </div>

                        <div class="col-md-6 mb-3 position-relative">
                              <label
                                    class="form-label"><?php echo lang('create_user_password_confirm_label', 'password_confirm'); ?></label>
                              <?php echo form_input(array_merge($password_confirm, ['id' => 'password_confirm', 'class' => 'form-control'])); ?>
                              <span class="toggle-password"
                                    onclick="togglePassword('password_confirm', this)">Show</span>
                        </div>

                        <div class="col-12 createbtn">
                              <?php echo form_submit('submit', lang('create_user_submit_btn'), 'class="btn btn-primary w-100"'); ?>
                        </div>
                  </div>

                  <?php echo form_close(); ?>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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