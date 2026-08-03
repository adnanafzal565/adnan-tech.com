@extends ("theme::layouts/app")
@section ("title", "Apps")

@section ("main")

    <div class="container">

        <div class="header">
            <h1>Applications</h1>
            <p>Manage and view available applications.</p>
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

    <style>
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .header p {
            color: #6b7280;
            font-size: 15px;
        }

        .apps_grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }

        .app_card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 220px;
        }

        .app_card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 35px rgba(0, 0, 0, 0.1);
        }

        .app_icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            background: var(--color-primary);
            /*background: linear-gradient(135deg, #2563eb, #4f46e5);*/
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .app_name {
            font-size: 21px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #111827;
        }

        .identifier {
            display: inline-block;
            background: #f3f4f6;
            color: #4b5563;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 13px;
            font-family: monospace;
            margin-bottom: 20px;
        }

        .detail_button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            background: #2563eb;
            color: white;
            padding: 11px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .detail_button:hover {
            background: #1d4ed8;
        }

        @media(max-width: 600px) {
            .container {
                margin: 25px auto;
            }

            .header h1 {
                font-size: 26px;
            }

            .app_card {
                padding: 20px;
            }
        }
    </style>

@endsection