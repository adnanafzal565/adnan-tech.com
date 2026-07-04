@extends ("layouts/app")
@section ("title", "Profile")

@section ("main")

    <div class="container" style="margin-top: 30px; margin-bottom: 30px;">
        <div class="row">
            <div class="col-4">
                @include ("layouts/profile-left-menu")
            </div>

            <div class="col-8" id="profile-app">
                <form onsubmit="saveProfile(event);" enctype="multipart/form-data">
                    <div class="row mb-5">
                        <div class="offset-4 col-3">
                            <img id="profile-image" style="width: 100px;
                                height: 100px;
                                object-fit: cover;
                                border-radius: 50%;
                                margin-bottom: 20px;
                                position: relative;
                                left: 50%;
                                transform: translateX(-50%);"
                                src="{{ url('/storage/' . auth()->user()->profile_image) }}"
                                onerror="this.src = baseUrl + '/img/user-placeholder.png'" />

                            <input type="file" name="profile_image" accept="image/*"
                                onchange="onChangeProfileImage(event);" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name ?? '' }}" class="form-control" required />
                    </div>

                    <div class="form-group mt-3 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" class="form-control" disabled />
                    </div>

                    <input type="submit" name="submit" class="btn btn-outline-primary btn-sm"
                        value="Save" />
                </form>
            </div>
        </div>
    </div>

    <script>
        async function saveProfile(event) {
            event.preventDefault()
            const form = event.currentTarget;

            try {    
                form.submit.setAttribute("disabled", "disabled");

                const formData = new FormData(event.target)
                const response = await axios.post(
                    baseUrl + "/profile",
                    formData
                )

                if (response.data.status == "success") {
                    swal.fire("Profile", response.data.message, "success")
                } else {
                    swal.fire("Error", response.data.message, "error")
                }
            } catch (exp) {
                if (exp.response.status == 401) {
                    window.location.href = baseUrl + "/login?redirect=" + window.location.href
                } else {
                    swal.fire("Error", exp.message, "error")
                }
            } finally {
                form.submit.removeAttribute("disabled");
            }
        }

        function onChangeProfileImage(event) {
            const files = event.target.files
            if (files.length > 0) {
                const fileReader = new FileReader()

                fileReader.onload = function (event) {
                    document.getElementById("profile-image").setAttribute("src", event.target.result)
                }
     
                fileReader.readAsDataURL(files[0])
            }
        }
    </script>

@endsection