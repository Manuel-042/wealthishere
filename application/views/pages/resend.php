<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
    <div class="container my-5">
        <button id="resendBtn" class="btn btn-secondary">Send Custom Email</button>
        <p id="status"></p>
    </div>
    
    <script>
        const btn = document.getElementById("resendBtn");
        const statusText = document.getElementById("status");
        let offset = 0;
        const limit = 100;

        btn.addEventListener("click", function () {
            btn.disabled = true;
            statusText.textContent = "Starting batch process...";
            processBatch();
        });

        // "api/resend_activation_mail"
        //"api/send_custom_email"

        function processBatch() {
            fetch(`<?= base_url("api/send_custom_confirm_email") ?>?offset=${offset}&limit=${limit}`)
                .then(res => res.json())
                .then(data => {
                    offset += limit;

                    if (!data.done) {
                        statusText.textContent = `Processed: ${offset} | Queued: ${data.queued}`;
                        setTimeout(processBatch, 500); // optional delay
                    } else {
                        statusText.textContent = `✅ All done! Total queued: ${offset}`;
                        btn.disabled = false;
                    }
                })
                .catch(err => {
                    statusText.textContent = "❌ Error occurred. Check console.";
                    console.error(err);
                    btn.disabled = false;
                });
        }
    </script>
</body>
</html>
