@extends ("theme::layouts/app")
@section ("title", $app->name)

@section ("main")

    <input type="hidden" id="data" value="{{ json_encode($data ?? []) }}" />

    <script>
        const data = JSON.parse(document.getElementById("data").value);
    </script>

    <div class="container py-5">

        <div class="row">
            
            <div class="col-12">
                
                <div id="app_detail_app">
                    @if ($app->identifier === "email_renderer")
                        @include ("EmailRenderer::templates_list")
                    @endif
                </div>

            </div>

        </div>

    </div>

    @if ($app->identifier === "email_renderer")
        <script type="text/babel">
            ReactDOM.createRoot(
                document.getElementById("app_detail_app")
            ).render(<EmailTemplates
                init_groups={ data } />);
        </script>
    @endif

@endsection