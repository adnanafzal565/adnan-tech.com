@extends ("theme::layouts/app")
@section ("title", $page->title)
@section ("meta_keywords", $page->keywords)
@section ("meta_description", $page->excerpt)
@section ("type", "article")
@section ("main")

  <div class="container">
    <h2>Get in Touch</h2>
    <p>If you have any questions, feedback, or just want to say hello — feel free to drop a message below!</p>

    <form onsubmit="doSendMessage(event);">

      <input type="hidden" name="token" value="{{ $token }}">

      <div style="position: absolute; left: -10000px; width: 1px; height: 1px; overflow: hidden;">
        <label for="website">Website</label>

        <textarea name="website" rows="1"
            tabindex="-1"
            style="resize: none;
                min-height: fit-content;
                font-family: sans-serif;
                font-size: 14px;"
         
            oninput="this.value = this.value.replace(/\n/g, '')"></textarea>
      </div>

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
      <p id="msg-success" class="form-success"></p>
      <button type="submit" name="submit">Send Message</button>
    </form>
  </div>

  <script>
    async function doSendMessage(event) {
      event.preventDefault();
      const form = event.currentTarget;
      document.getElementById("msg-success").innerHTML = "";
      form.submit.setAttribute("disabled", "disabled");
      var ajax = new XMLHttpRequest();
      ajax.open("POST", baseUrl + "/api/send_contact_us_message", true);

      ajax.onreadystatechange = function () {
        if (this.readyState == 4) {
          if (this.status == 200) {
            form.submit.removeAttribute("disabled");
            const response = JSON.parse(this.responseText);
            if (response.status == "success") {
              document.getElementById("msg-success").innerHTML = response.message;
            } else {
              alert(response.message);
            }
          }

          if (this.status == 500) {
            console.log(this.responseText);
          }
        }
      };

      var formData = new FormData(form);
      ajax.send(formData);
    }
  </script>

@endsection