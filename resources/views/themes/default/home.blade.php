@extends ("theme::layouts/app")

@section ("main")

    <!-- Main Content -->
    {{--
    <main class="container">
        <div class="blog-posts">
            @foreach (get_cached_posts() as $post)
                <article class="post-card" style="display: flex;">
                    <img src="{{ $post->file_path ?? '' }}"
                        alt="{{ $post->title }}"
                        style="width: 200px;
                          height: 150px;
                          object-fit: cover;"
                        onerror="this.remove();" />

                    <div style="margin-left: 20px;">
                        <h2 class="post-title"><a href="{{ $post->url }}">{{ $post->title }}</a></h2>
                        <p class="post-excerpt">{{ $post->excerpt }}</p>
                    </div>
                </article>
            @endforeach
        </div>

    </main>
    --}}

    @php
        $apps = get_cached_apps();
    @endphp

    @if (count($apps) > 0)
        <div class="container apps">

            <div class="header">
                <h1>Applications</h1>
                <p>View and manage available applications.</p>
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
                            Open App
                        </a>

                    </div>

                @endforeach

            </div>

        </div>
    @endif

    @php
        $products = get_cached_products();
    @endphp

    @if ($products->count() > 0)
    
        <!-- Products Section -->
        <section class="products-section py-5">
            <div class="container">

                <!-- Section Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">Products</h2>
                        <!-- <p class="text-muted mb-0">
                            Discover our latest collection
                        </p> -->
                    </div>

                    <!-- <a href="#" class="btn btn-outline-dark">
                        View All
                    </a> -->
                </div>


                <!-- Products Grid -->
                <div class="row g-4">

                    @foreach ($products as $product)

                        <!-- Product -->
                        <div class="col-6 col-md-6 col-lg-4">

                            <div class="product-card h-100">

                                <div class="product-image">

                                    <!-- <span class="badge bg-danger position-absolute top-0 start-0 m-3">
                                        Sale
                                    </span> -->

                                    <!-- <button class="wishlist-btn">
                                        <i class="fa fa-heart"></i>
                                    </button> -->

                                    <img src="{{ $product->image ? $product->image->file_path_absolute : 'https://via.placeholder.com/400x400' }}"
                                         class="img-fluid"
                                         alt="{{ $product->title }}">

                                </div>


                                <div class="product-content">

                                    <div class="small text-muted mb-1">
                                        {{ $product->sku }}
                                    </div>

                                    <h6 class="product-title"
                                        onclick="window.location.href = '{{ route('pages.show', ['slug' => $product->slug]) }}';">
                                        {{ $product->title }}
                                    </h6>


                                    <!-- <div class="rating mb-2">
                                        ★★★★★
                                        <span>(24)</span>
                                    </div> -->


                                    <div class="d-flex align-items-center gap-2 mb-3">

                                        <span class="price">
                                            {{ env('CURRENCY_SYMBOL') }}{{ $product->price }}
                                        </span>

                                        <!-- <span class="old-price">
                                            $159
                                        </span> -->

                                    </div>

                                    <a href="{{ route('pages.show', ['slug' => $product->slug]) }}" class="btn btn-dark w-100">
                                        View Detail
                                    </a>

                                </div>

                            </div>

                        </div>

                    @endforeach

                    {!! $products->links("pagination::bootstrap-5") !!}

                </div>

            </div>
        </section>

    @endif

    <style>
        .products-section {
            background: #f8f9fa;
        }


        .product-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #eee;
            transition: all .3s ease;
        }


        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0,0,0,.08);
        }


        /* Product Image */

        .product-image {
            height: 260px;
            background: #f5f5f5;
            position: relative;
            overflow: hidden;
            display:flex;
            align-items:center;
            justify-content:center;
        }


        .product-image img {
            width:100%;
            height:100%;
            object-fit:cover;
            transition:.4s ease;
            object-position: right;
        }


        .product-card:hover .product-image img {
            transform:scale(1.08);
        }



        /* Wishlist */

        .wishlist-btn {

            position:absolute;
            top:15px;
            right:15px;

            width:38px;
            height:38px;

            border-radius:50%;
            border:none;

            background:#fff;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:18px;

            box-shadow:0 5px 15px rgba(0,0,0,.1);

            z-index:2;

        }



        /* Content */

        .product-content {
            padding:20px;
        }


        .product-title {

            cursor: pointer;

            font-size:16px;
            font-weight:600;

            margin-bottom:10px;

            display:-webkit-box;
            -webkit-line-clamp:2;
            -webkit-box-orient:vertical;

            overflow:hidden;

        }



        .rating {

            color:#ffc107;
            font-size:14px;

        }


        .rating span {

            color:#777;
            margin-left:5px;

        }


        .price {

            font-size:22px;
            font-weight:700;

        }


        .old-price {

            color:#999;
            text-decoration:line-through;
            font-size:14px;

        }



        .product-content .btn {

            border-radius:12px;
            padding:12px;

        }
    </style>

@endsection