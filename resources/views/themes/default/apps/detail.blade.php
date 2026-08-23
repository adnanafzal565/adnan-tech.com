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

                @if ($app->identifier === "email_renderer")
                    @include ("EmailRenderer::templates_list")
                @elseif ($app->identifier === "job_runner")
                    @include ("JobRunner::index")
                @endif

            </div>

        </div>

    </div>

@endsection