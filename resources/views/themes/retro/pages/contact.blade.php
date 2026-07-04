@extends ("theme::layouts/app")
@section ("title", $page->title)
@section ("meta_keywords", $page->keywords)
@section ("meta_description", $page->excerpt)
@section ("type", "article")

@section ("main")

      <div class="retro-container contact-form">
        <h2>📨 Get in Touch</h2>

        <form onsubmit="doSendMessage(event);" class="retro-form">
          <label>Your Name</label>
          <input type="text" name="name" required>

          <label>Your Email</label>
          <input type="email" name="email" required>

          <label>Your Message</label>
          <textarea name="message" rows="6" required></textarea>

          <p id="msg-success" style="color: lightgreen;"></p>

          <button type="submit" name="submit">🚀 Send Message</button>
        </form>
      </div>

      <script>
        async function doSendMessage(event) {
            event.preventDefault();
            const form = event.currentTarget;
            document.getElementById("msg-success").innerHTML = "";

            form.submit.setAttribute("disabled", "disabled");
            var ajax = new XMLHttpRequest();
            ajax.open("POST", baseUrl + "/api/send-contact-us-message", true);
         
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
          /* Contact Form */
        .contact-form h2 {
          text-align: center;
          font-size: 18px;
          color: #00ffff;
          margin-bottom: 30px;
        }

        .retro-form {
          background: #111;
          border: 3px dotted #00ffcc;
          padding: 30px;
          border-radius: 10px;
          max-width: 600px;
          margin: 0 auto;
          animation: fadeIn 0.6s ease;
        }

        .retro-form label {
          display: block;
          margin-bottom: 10px;
          font-size: 12px;
          color: #ffcc00;
        }

        .retro-form input,
        .retro-form textarea {
          width: 100%;
          padding: 10px;
          font-family: 'Press Start 2P', monospace;
          background: #000;
          border: 2px solid #00ffff;
          color: #00ff99;
          font-size: 10px;
          margin-bottom: 20px;
          border-radius: 4px;
          outline: none;
          transition: border 0.3s, background 0.3s;
        }

        .retro-form input:focus,
        .retro-form textarea:focus {
          background: #220033;
          border-color: #ff00cc;
        }

        .retro-form button {
          background: #ff00cc;
          color: #000;
          font-size: 12px;
          padding: 12px 20px;
          border: none;
          font-family: 'Press Start 2P', monospace;
          cursor: pointer;
          border-radius: 5px;
          transition: background 0.3s;
        }

        .retro-form button:hover {
          background: #ffcc00;
          color: #000;
        }
      </style>

@endsection