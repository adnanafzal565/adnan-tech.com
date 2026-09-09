<!--
  Newsletter signup section.
  Drop this into any Blade view (e.g. layouts/footer.blade.php or a landing page).
  Requires Bootstrap 5 CSS/JS already loaded on the page, and the CSRF meta tag
  in your main layout's <head>:
    <meta name="csrf-token" content="{{ csrf_token() }}">
-->
<section class="newsletter-section py-5">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-7 col-md-9">
        <h2 class="fw-bold mb-2">Subscribe to our Newsletter</h2>
        <p class="text-muted mb-4">
          Get product updates and news delivered straight to your inbox. No spam, ever.
        </p>
 
        <form id="newsletterForm" class="newsletter-form" novalidate>
          <div class="input-group input-group-lg shadow-sm">
            <span class="input-group-text bg-white border-end-0">
              <i class="fa fa-envelope"></i>
            </span>
            <input
              type="email"
              class="form-control border-start-0"
              id="newsletterEmail"
              name="email"
              placeholder="you@example.com"
              autocomplete="email"
              required
            >
            <button class="btn btn-primary px-4" type="submit" id="newsletterBtn">
              <span class="btn-label">Subscribe</span>
              <span class="spinner-border spinner-border-sm d-none ms-1" id="newsletterSpinner" role="status" aria-hidden="true"></span>
            </button>
          </div>
 
          <!-- Inline validation message -->
          <div class="invalid-feedback d-block text-start mt-1 d-none" id="newsletterInvalid">
            Please enter a valid email address.
          </div>
 
          <!-- Server response alert -->
          <div id="newsletterAlert" class="alert mt-3 d-none py-2" role="alert"></div>
        </form>
      </div>
    </div>
  </div>
</section>

<style>
  .newsletter-section .input-group-text {
    border-color: #ced4da;
  }
  .newsletter-form .form-control:focus {
    box-shadow: none;
    border-color: #ced4da;
  }
  .newsletter-form .btn:disabled {
    opacity: 0.75;
  }
</style>
 
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form       = document.getElementById('newsletterForm');
    const emailInput = document.getElementById('newsletterEmail');
    const submitBtn  = document.getElementById('newsletterBtn');
    const btnLabel   = submitBtn.querySelector('.btn-label');
    const spinner    = document.getElementById('newsletterSpinner');
    const invalidMsg = document.getElementById('newsletterInvalid');
    const alertBox   = document.getElementById('newsletterAlert');
   
    const CSRF_TOKEN = document.querySelector('meta[name="_token"]')?.getAttribute('content');
    const SUBSCRIBE_URL = "{{ route('newsletter.subscribe') }}"; // e.g. /newsletter/subscribe
   
    function setLoading(isLoading) {
      submitBtn.disabled = isLoading;
      emailInput.disabled = isLoading;
      spinner.classList.toggle('d-none', !isLoading);
      btnLabel.textContent = isLoading ? 'Subscribing...' : 'Subscribe';
    }
   
    function showAlert(message, type) {
      alertBox.textContent = message;
      alertBox.className = `alert mt-3 py-2 alert-${type}`;
    }
   
    function isValidEmail(value) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }
   
    form.addEventListener('submit', function (e) {
      e.preventDefault();
   
      const email = emailInput.value.trim();
   
      // Client-side validation
      if (!isValidEmail(email)) {
        emailInput.classList.add('is-invalid');
        invalidMsg.classList.remove('d-none');
        return;
      }
      emailInput.classList.remove('is-invalid');
      invalidMsg.classList.add('d-none');
      alertBox.classList.add('d-none');
   
      setLoading(true);
   
      fetch(SUBSCRIBE_URL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ email: email }),
      })
        .then(async (response) => {
          const data = await response.json().catch(() => ({}));
   
          if (response.status === 201) {
            // Newly subscribed
            showAlert(data.message || "You're subscribed! Check your inbox for confirmation.", 'success');
            form.reset();
          } else if (response.status === 200) {
            // Already subscribed (still a "success" from the user's point of view)
            showAlert(data.message || "You're already subscribed.", 'info');
          } else if (response.status === 422) {
            // Validation error from Laravel
            const firstError = data.errors ? Object.values(data.errors)[0][0] : 'Please check your email address.';
            showAlert(firstError, 'danger');
          } else {
            showAlert(data.message || 'Something went wrong. Please try again.', 'danger');
          }
        })
        .catch(() => {
          showAlert('Network error. Please try again in a moment.', 'danger');
        })
        .finally(() => {
          setLoading(false);
        });
    });
  });
</script>