<link rel="stylesheet" href="<?= base_url('assets/css/contact.css') ?>" />

<!-- Hero Section -->
<header class="page-hero">
    <div class="container text-center">
        <h1>GET IN TOUCH WITH US</h1>
        <p class="lead">We are happy to talk to you! Just complete the form.</p>
    </div>
</header>

<main class="container py-5">
    <section id="contact-section" class="section">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row gy-4">
                    <!-- Contact Form Column -->
                    <div class="col-md-12">
                        <div class="card h-100 p-4 shadow-sm">
                            <h4 class="mb-4 text-center section-title" style="color: var(--primary-color)">
                                Send Us A Message
                            </h4>
                            <form method="post" action="<?= base_url("api/contact_us") ?>" id="contactForm" class="row contact-form flex-wrap justify-content-between">
                                <div class="mb-4 col-12 col-lg-4">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Your full name"
                                        required value="<?= $fullname ?>" />
                                </div>
                                <div class="mb-4 col-12 col-lg-4">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com"
                                        required value="<?= $email ?>" />
                                </div>
                                <div class="mb-4 col-12 col-lg-4">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Your phone number" required value="<?= $phone ?>" />
                                </div>

                                <div class="col-md-6">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option></option>
                                        <?php
                                        foreach ($categories as $category) {
                                            echo "<option value='{$category->id}'>{$category->name}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6" id="question_cont">
                                    <label for="question" class="form-label">Question</label>
                                    <select class="form-select" id="question" name="question">
                                        <option></option>
                                    </select>
                                </div>

                                <input type="hidden" id="question_id" name="question_id" />
                                <input type="hidden" name="selected_question" id="selectedQuestion">

                                <div class="my-4 col-12 d-none" id="custom_message">
                                    <label for="message" class="form-label">Type in your message</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your message"></textarea>
                                </div>
                                <div class="mb-4 mt-5 col-12 text-center">
                                    <button type="submit" class="btn btn-primary mx-auto rounded-pill" style="
                          background-color: rgba(0, 79, 159, 1);
                          border-color: var(--primary-color);
                        ">
                                        Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Info Column -->
                    <div class="col-md-12 mt-5">
                        <div class="card h-100 p-4 shadow-sm d-flex flex-column justify-content-around">
                            <div class="">
                                <h4 class="mb-4 section-title text-center" style="color: var(--primary-color)">
                                    Our Details
                                </h4>
                                <div class="row flex-wrap justify-content-between px-4">
                                    <div class="contact-info-card mb-3 col-12 col-lg-3">
                                        <div class="icon"><i class="fas fa-envelope"></i></div>
                                        <h4>Email Us</h4>
                                        <p>
                                            <a href="mailto:BATN_Foundation@bat.com"
                                                style="color: var(--text-dark); text-decoration: none">BATN_Foundation@bat.com</a>
                                        </p>
                                    </div>
                                    <div class="contact-info-card mb-3 col-12 col-lg-3">
                                        <div class="icon"><i class="fas fa-clock"></i></div>
                                        <h4>Working Hours</h4>
                                        <p>Monday - Friday</p>
                                        <p>8:00AM - 5:00PM</p>
                                    </div>
                                    <div class="contact-info-card mb-3 col-12 col-lg-3">
                                        <div class="icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <h4>Our Location</h4>
                                        <p>Lagos, Nigeria</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <h4 style="color: var(--primary-color)">
                                    Stay Updated on the BATN Foundation Mobile App
                                </h4>
                                <p class="mb-3">Available on iOS & Android</p>
                                <div class="qr-code-container justify-content-around">
                                    <a href="https://apps.apple.com/us/app/batn-foundation/id6479701182"
                                        target="_blank">
                                        <div class="qr-code-item">
                                            <img src="<?= base_url('assets/images/ios app.png') ?>"
                                                alt="iOS App QR Code" />
                                            <small class="text-muted">iOS App</small>
                                        </div>
                                    </a>
                                    <a href="https://play.google.com/store/apps/details?id=com.bat.BATNF&hl=en&pli=1"
                                        target="_blank">
                                        <div class="qr-code-item">
                                            <img src="<?= base_url('assets/images/android app.png') ?>"
                                                alt="Android App QR Code" />
                                            <small class="text-muted">Android App</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="social-media-icons">
                                    <a href="https://www.instagram.com/batnfoundation/" target="_blank"
                                        aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                                    <a href="https://web.facebook.com/BATNFoundation/?_rdc=1&_rdr#" target="_blank"
                                        aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://x.com/BATNFoundation/" target="_blank" aria-label="Twitter"><i
                                            class="fa-brands fa-x-twitter"></i></a>
                                    <a href="https://www.linkedin.com/showcase/batn-foundation/about/" target="_blank"
                                        aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="https://www.youtube.com/channel/UCektzc9hBeVRLPqEsQuqfzQ" target="_blank"
                                        aria-label="Youtube"><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<?php if ($this->session->flashdata('success')): ?>
    <script>
        toastr["success"]("<?= $this->session->flashdata('success') ?>");
    </script>
<?php elseif ($this->session->flashdata('error')): ?>
    <script>
        toastr["error"]("<?= $this->session->flashdata('error') ?>");
    </script>
<?php endif; ?>

<script>
    $(document).ready(function() {
        $("#category").select2({
            placeholder: "Please select the category your question belongs to.",
            allowClear: true
        })

        $('#question').select2({
            placeholder: "Select a question...",
            allowClear: true
        });

        let currentCategory = null;

        $("#category").on("change", function() {
            currentCategory = $(this).val();

            if (currentCategory == '6') {
                $("#custom_message").removeClass("d-none");
                $("#message").prop("required", true);
                $("#question_cont").addClass("d-none");
                $("#question").prop("required", false);
            } else {
                $("#question_cont").removeClass("d-none");
                $("#question").prop("required", true);
                $("#custom_message").addClass("d-none");
                $("#message").prop("required", false);
            }

            $('#question').empty();

            // Fetch questions for the selected category
            $.ajax({
                url: "<?= base_url('api/support_questions') ?>",
                data: {
                    category_id: currentCategory
                },
                dataType: "json",
                success: function(data) {
                    const questions = data.message || [];

                    $('#question').append(new Option("Select a question...", "", true, true)).trigger('change');

                    questions.forEach(function(item) {
                        const option = new Option(item.question, item.answer, false, false);
                        $(option).attr('data-id', item.id);
                        $(option).attr('data-question', item.question);
                        $('#question').append(option);
                    });

                    //$('#question').append(new Option("Other", "other", false, false));
                },
                error: function(err) {
                    console.error("Error loading questions:", err);
                }
            });
        });

        $("#question").on("change", function() {
            let value = $(this).val();
            const selectedOption = $(this).find(':selected');
            const questionId = selectedOption.data('id');
            const question = selectedOption.data('question');
            $('#question_id').val(questionId);
            $('#selectedQuestion').val(question);

            if (value === 'Others') {
                if ($("#custom_message").hasClass("d-none")) {
                    $("#custom_message").removeClass("d-none");
                    $("#message").prop("required", true);
                }
            } else {
                if (!$("#custom_message").hasClass("d-none") && $("#category").val() !== '6') {
                    $("#custom_message").addClass("d-none");
                    $("#message").prop("required", false);
                }
            }
        })

        $("#phone").on("keypress paste",
            function(e) {
                let allowedChars = "+0123456789";

                if (e.type === "keypress") {
                    let char = String.fromCharCode(e.which);
                    if (!allowedChars.includes(char)) {
                        e.preventDefault();
                    }
                }

                // Handle paste events:
                else if (e.type === "paste") {
                    // Get the pasted text (works in modern browsers)
                    let pastedData = e.originalEvent.clipboardData.getData("text");
                    // If the pasted text contains any characters not in allowedChars, prevent the paste.
                    if (!/^[0-9]+$/.test(pastedData)) {
                        e.preventDefault();
                    }
                }
            }
        );

    });
</script>