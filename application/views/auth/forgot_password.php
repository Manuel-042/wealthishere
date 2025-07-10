<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <title><?php echo lang('forgot_password_heading'); ?></title>
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

            .forgot-box {
                  background: #fff;
                  padding: 2rem;
                  border-radius: 10px;
                  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                  width: 100%;
                  max-width: 500px;
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

            <div class="forgot-box mx-auto">
                  <h1 class="h4 mb-3"><?php echo lang('forgot_password_heading'); ?></h1>
                  <p class="text-muted mb-4">
                        <?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?>
                  </p>

                  <div id="infoMessage" class="mb-3"><?php echo $message; ?></div>

                  <?php echo form_open("auth/forgot_password"); ?>

                  <div class="mb-3 text-start">
                        <label for="identity" class="form-label">
                              <?php echo (($type == 'email') ?
                                    sprintf(lang('forgot_password_email_label'), $identity_label) :
                                    sprintf(lang('forgot_password_identity_label'), $identity_label)); ?>
                        </label>
                        <?php echo form_input(array_merge($identity, ['class' => 'form-control', 'id' => 'identity'])); ?>
                  </div>

                  <div class="d-grid">
                        <?php echo form_submit('submit', lang('forgot_password_submit_btn'), 'class="btn btn-primary btn-block"'); ?>
                  </div>

                  <?php echo form_close(); ?>
            </div>
      </div>

</body>

</html>