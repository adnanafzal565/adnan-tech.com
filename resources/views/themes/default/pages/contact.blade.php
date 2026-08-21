@extends ("theme::layouts/app")
@section ("title", $page->title)
@section ("meta_keywords", $page->keywords)
@section ("meta_description", $page->excerpt)

@section ("main")

    <section class="contact-section">
        <div class="contact-container">
            <h2>Contact Us</h2>
            <p>Have any questions? We’d love to hear from you.</p>

            <form onsubmit="doSendMessage(event);" class="contact-form">

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
                    <input type="text" name="name" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label>Your Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label>Your Message</label>
                    <textarea name="message" placeholder="Write your message" rows="5" required></textarea>
                </div>

                <p id="msg-success" style="color: green;"></p>

                <button type="submit" name="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </section>

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
                    form.submit.removeAttribute("disabled");
                    
                    if (this.status == 200) {
                        // display in browser
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 15px;
        }

        .contact-container {
            background: #fff;
            max-width: 500px;
            width: 100%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-container h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #222;
        }

        .contact-container p {
            text-align: center;
            margin-bottom: 30px;
            color: #555;
        }

        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            background: #fafafa;
            transition: border-color 0.3s ease;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #007BFF;
            outline: none;
            background: #fff;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #007BFF;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-submit:hover {
            background: #0056b3;
        }

        @media (max-width: 600px) {
            .contact-container {
                padding: 20px;
            }
        }
    </style>

@endsection