@extends ("theme::layouts/app")
@section ("title", $app->name)

@section ("main")

    <div class="container py-5">

        <div class="row">
            
            <div class="col-12">
                
                <div id="app_detail_app"></div>

            </div>

        </div>

    </div>

    @if ($app->identifier === "email_renderer")
        <script type="text/babel">
            ReactDOM.createRoot(
                document.getElementById("app_detail_app")
            ).render(<EmailTemplates />);
        </script>
    @endif

@endsection