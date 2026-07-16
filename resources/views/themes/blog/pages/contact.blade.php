@extends ("theme::layouts/app")
@section ("title", $page->title)
@section ("meta_keywords", $page->keywords)
@section ("meta_description", $page->excerpt)
@section ("type", "article")

@section ("main")

    <!-- Contact Section -->
      <div class="container contact-section">
        <div class="contact-card">
          <h2>Get in Touch</h2>
          <p>If you have any questions, feedback, or just want to say hello — feel free to drop a message below!</p>

          <form onsubmit="doSendMessage(event);" class="contact-form">
            <div class="form-group">
              <label>Your Name</label>
              <input type="text" name="name" required placeholder="John Doe">
            </div>

            <div class="form-group">
              <label>Your Email</label>
              <input type="email" name="email" required placeholder="john@example.com">
            </div>

            <div class="form-group">
              <label>Your Message</label>
              <textarea name="message" rows="6" required placeholder="Write your message here..."></textarea>
            </div>

            <p id="msg-success" style="color: green;"></p>

            <button type="submit" name="submit" class="btn-submit">Send Message</button>
          </form>
        </div>
      </div>

        <script>
            async function doSendMessage(event) {
                event.preventDefault();
                const form = event.currentTarget;
                document.getElementById("msg-success").innerHTML = "";

                form.submit.setAttribute("disabled", "disabled");
                var ajax = new XMLHttpRequest();
                ajax.open("POST", baseUrl + "/api/send_contact_us_message", true);
             
                // when the response is received
                ajax.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            // display in browser
                            form.submit.removeAttribute("disabled");
                            const response = JSON.parse(this.responseText);
                            if (response.status == "success") {
                                document.getElementById("msg-success").innerHTML = response.message;
                            } else {
                                alert(response.message);
                            }
                        }
             
                        // handler error
                        if (this.status == 500) {
                            console.log(this.responseText);
                        }
                    }
                };
             
                var formData = new FormData(form);
                ajax.send(formData);
            }
        </script>

      <style>
        .contact-section {
          margin: 50px auto;
          max-width: 700px;
        }

        .contact-card {
          background: #fff;
          border-radius: 12px;
          padding: 40px;
          box-shadow: 0 4px 20px rgba(0,0,0,0.1);
          animation: fadeInUp 0.6s ease;
        }
        .contact-card h2 {
          margin-bottom: 10px;
          font-size: 2rem;
        }
        .contact-card p {
          margin-bottom: 30px;
          color: #666;
        }

        .contact-form .form-group {
          margin-bottom: 25px;
        }
        .contact-form label {
          display: block;
          font-weight: 600;
          margin-bottom: 8px;
          color: #333;
        }
        .contact-form input,
        .contact-form textarea {
          width: 100%;
          padding: 12px 15px;
          border: 1px solid #ccc;
          border-radius: 8px;
          font-size: 1rem;
          background: #fafafa;
          transition: border-color 0.3s, background-color 0.3s;
        }
        .contact-form input:focus,
        .contact-form textarea:focus {
          border-color: #007bff;
          background-color: #fff;
          outline: none;
        }

        .btn-submit {
          display: inline-block;
          background: #007bff;
          color: white;
          padding: 12px 25px;
          border: none;
          border-radius: 8px;
          font-size: 1rem;
          cursor: pointer;
          transition: background 0.3s ease;
        }
        .btn-submit:hover {
          background: #0056b3;
        }
      </style>

@endsection