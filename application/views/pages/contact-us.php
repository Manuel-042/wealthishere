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
                            <form id="contactForm" class="row contact-form flex-wrap justify-content-between">
                                <div class="mb-4 col-12 col-lg-4">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" placeholder="Your full name"
                                        required />
                                </div>
                                <div class="mb-4 col-12 col-lg-4">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" placeholder="name@example.com"
                                        required />
                                </div>
                                <div class="mb-4 col-12 col-lg-4">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="Your phone number" />
                                </div>
                                <div class="mb-4 col-12">
                                    <label for="message" class="form-label">Message Us</label>
                                    <textarea class="form-control" id="message" rows="5" placeholder="Your message"
                                        required></textarea>
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

<script>
    document.getElementById("contactForm").addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = {
            fullName: document.getElementById('fullName').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            message: document.getElementById('message').value,
        };

        try {
            const response = await fetch("<?= base_url('api/contact_us') ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                Swal.fire({
                    title: "Message sent successfully!",
                    icon: "success",
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.reset();
                        // window.location.href = `${baseUrl}/index`;
                    }
                });
            } else {
                throw new Error(result.error || 'Failed to send message');
            }
        } catch (error) {
            Swal.fire({
                title: "Error sending message",
                text: error.error || "Please try again later",
                icon: "error",
            });
        }
    });
</script>