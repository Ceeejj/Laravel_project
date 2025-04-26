<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <div class="feedback-container">
        <h2 class="text-center mb-4"> We Value Your Feedback</h2>

        <form id="feedbackForm" action="/feedback" method="POST">


            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Your Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-custom" id="submitButton">
                    <span id="buttonText">Submit Feedback</span>
                    <span id="spinner" class="spinner-border spinner-border-sm d-none ms-2" role="status"
                        aria-hidden="true"></span>
                </button>
            </div>

            <div id="responseMessage" class="alert mt-3 d-none"></div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('feedbackForm');
            const submitButton = document.getElementById('submitButton');
            const buttonText = document.getElementById('buttonText');
            const spinner = document.getElementById('spinner');
            const responseMessage = document.getElementById('responseMessage');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                submitButton.disabled = true;
                buttonText.textContent = 'Processing...';
                spinner.classList.remove('d-none');
                responseMessage.classList.add('d-none');

                const formData = new FormData(form);

                try {
                    const response = await fetch('/feedback', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    const data = await response.json();

                    responseMessage.classList.remove('d-none');
                    if (response.ok && data.success) {
                        responseMessage.className = 'alert alert-success mt-3';
                        responseMessage.innerHTML =
                            `<strong>Success!</strong> ${data.message}<div class="mt-2">We've sent a confirmation to ${formData.get('email')}.</div>`;
                        form.reset();
                    } else {
                        throw new Error(data.message || 'Failed to submit feedback');
                    }
                } catch (error) {
                    responseMessage.className = 'alert alert-danger mt-3';
                    responseMessage.textContent = `Error: ${error.message}`;
                    console.error('Submission error:', error);
                } finally {
                    submitButton.disabled = false;
                    buttonText.textContent = 'Submit Feedback';
                    spinner.classList.add('d-none');

                    setTimeout(() => {
                        responseMessage.classList.add('d-none');
                    }, 5000);
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
