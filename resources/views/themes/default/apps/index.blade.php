@extends ("theme::layouts/app")
@section ("title", "Apps")

@section ("main")

    <div class="container apps">

        <div class="header">
            <h1>APIs</h1>
            <p>View and manage available APIs.</p>
        </div>

        <div class="apps_grid">

            @foreach ($apps as $app)

                <div class="app_card">

                    <div>
                        <div class="app_icon">
                            {{ $app->name[0] }}
                        </div>

                        <div class="app_name">
                            {{ $app->name }}
                        </div>

                        {{--
                        <div class="identifier">
                            {{ $app->identifier }}
                        </div>
                        --}}

                    </div>

                    <a href="{{ route('apps.detail', [ 'identifier' => $app->identifier ]) }}" class="btn btn-dark">
                        View Details
                    </a>

                </div>

            @endforeach

        </div>

    </div>

    @include ("theme::pricing")

@endsection