<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?= base_url('/assets/images/favico-32.png') ?>" sizes="32x32" />
    <link rel="icon" href="<?= base_url('assets/images/favico-192.png') ?>" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?= base_url('assets/images/favico-180.png') ?>" />
    <meta name="msapplication-TileImage" content="<?= base_url('assets/images/favico-270.png') ?>" />
    <title><?= $title ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/552bd80ddc.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/global.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('./assets/css/home.css') ?>" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>

    <style>
        .loggedIn {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #f5f5f5;
            font-weight: 500;
            letter-spacing: 1px;
            margin-left: 10px;
        }

        .loggedIn::after {
            content: " " !important;
            border: none !important;
            margin: 0 !important;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        .layout {
            display: grid;
            grid-template-rows: auto 1fr auto;
            min-height: 100vh;
        }

        .layout>main {
            min-height: 0;
            overflow: auto;
        }

        .btn-x-styles {
            color: #ffffff;
            background-color: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
            padding: 0.375rem 1rem;
            font-family: inherit;
            font-weight: 400;
            display: inline-block;
            vertical-align: middle;
            margin: 0;
            line-height: 1.5;
        }

        .btn-x-styles:hover {
            color: #ffffff;
            background-color: var(--accent-color-hover) !important;
            border-color: var(--accent-color-hover) !important;
        }

        .move {
            left: -100% !important;
            margin-top: 0.3rem;
        }
    </style>
</head>

<body>
    <div class="layout">
        <?php
        // Get current URI segment or controller/method
        $current_page = $this->uri->segment(1); // Gets first segment after base_url
        if (empty($current_page))
            $current_page = 'index'; // Default for home page
        ?>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-xl sticky-top">
            <div class="d-flex justify-content-between align-items-center w-100 px-5">
                <a class="navbar-brand" href="<?= base_url('index') ?>">
                    <img src="<?= base_url('/assets/images/nav_logo.png') ?>" alt="Wealth is Here Logo" loading="lazy"
                        onerror="this.onerror=null;this.src='https://placehold.co/200x60/003366/FFFFFF?text=Logo';" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'index') ? 'active' : '' ?>" aria-current="page"
                                href="<?= site_url('index') ?>">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= (in_array($current_page, ['about', 'f4f', 'f4f-apply', 'faq'])) ? 'active' : '' ?>"
                                href="#" id="f4fDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Farmers for the Future
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="f4fDropdown">
                                <li><a class="dropdown-item" href="<?= site_url('f4f#about') ?>">About</a></li>
                                <li><a class="dropdown-item" href="<?= site_url('f4f#prizes') ?>">Prizes</a></li>
                                <li><a class="dropdown-item" href="<?= site_url('f4f#past-winners') ?>">Past Winners</a>
                                </li>
                                <li><a class="dropdown-item" href="<?= site_url('f4f-apply') ?>">Apply</a></li>
                                <li><a class="dropdown-item" href="<?= site_url('about') ?>">Conveners</a></li>
                            </ul>

                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= (in_array($current_page, ['gap', 'gap-apply', 'faq'])) ? 'active' : '' ?>"
                                href="#" id="gapDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Graduate Agripreneur Program
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="gapDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('gap#about') ?>">About</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('gap#prizes') ?>">Prizes</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('gap#past-winners') ?>">Past Winners</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('gap-apply') ?>">Apply</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= (in_array($current_page, ['past-winners'])) ? 'active' : '' ?>"
                                href="#" id="beneficiariesDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Youth Alumni
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="beneficiariesDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('gap-alumni') ?>">GAP
                                        Beneficiaries</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('f4f-alumni') ?>">Farmers for the
                                        Future
                                        Beneficiaries</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= (in_array($current_page, ['f4f-apply', 'gap-apply', 'faq'])) ? 'active' : '' ?>" " href="
                                #" id="applyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Apply
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="applyDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('f4f-apply') ?>">Farmers for the
                                        Future</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('gap-apply') ?>">Graduate Agripreneur
                                        Program</a>
                                </li>
                                <li><a class="dropdown-item" href="<?= site_url('faq') ?>">FAQs</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'contact-us') ? 'active' : '' ?>"
                                href="<?= site_url('contact-us') ?>">Contact</a>
                        </li>
                        <?php
                        if ($this->ion_auth->logged_in()) {
                            $user = $this->ion_auth->user()->row();
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle loggedIn" href="#" id="applyDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php
                                    echo substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1);
                                    ?>
                                </a>
                                <ul class="dropdown-menu move" aria-labelledby="applyDropdown">
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('logout') ?>">
                                            Logout
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('change_password') ?>">
                                            Change Password
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('api/f4f-application/') .  $user->id ?>">
                                            My Application
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item">
                                <a href="<?= site_url('login') ?>"
                                    class="nav-link btn btn-warning rounded-pill btn-x-styles">Login</a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <script>
            //document.getElementById("copyright-year").textContent = new Date().getFullYear();

            document.addEventListener("DOMContentLoaded", function() {
                const navbarCollapse = document.querySelector(".navbar-collapse");
                const navbarToggler = document.querySelector(".navbar-toggler");

                if (navbarCollapse && navbarToggler) {
                    const closeButton = document.createElement("button");
                    closeButton.type = "button";
                    closeButton.classList.add(
                        "btn-close",
                        "pe-5",
                        "btn-close-white",
                        "float-end",
                        "d-lg-none",
                        "mt-2",
                    );
                    closeButton.setAttribute("aria-label", "Close");

                    // Insert the close button as the first child of the navbar collapse
                    navbarCollapse.insertBefore(closeButton, navbarCollapse.firstChild);
                    navbarToggler.addEventListener("click", function() {
                        navbarToggler.classList.add("d-none");
                    });

                    // Close the navbar when the close button is clicked
                    closeButton.addEventListener("click", function() {
                        navbarCollapse.classList.remove("show");
                        navbarToggler.classList.add("collapsed");
                        navbarToggler.setAttribute("aria-expanded", false);
                        navbarToggler.classList.remove("d-none");
                    });

                    // Toggle the navbar when the toggler is clicked
                }
            });
        </script>