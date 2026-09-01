@extends ("theme::layouts/app")

@section ("main")

    @php
        $recentPosts = get_cached_posts();
        $featuredPost = null;
    @endphp
     
    <section class="latest-posts">
        <div class="container" style="max-width: 1140px;">
     
            {{-- Section header --}}
            <div class="d-flex align-items-end justify-content-between gap-3 lp-header">
                <h2 class="font-display">From the journal</h2>
                <a href="{{ route('blog.index') }}" class="lp-all-link flex-shrink-0">All posts</a>
            </div>
     
            @if (!$featuredPost && (!isset($recentPosts) || $recentPosts->isEmpty()))
     
                {{-- Empty state --}}
                <div class="lp-empty text-center py-5">
                    <p class="mb-2">No stories yet</p>
                    <p>Check back soon — new posts will appear here.</p>
                </div>
     
            @else
     
                <div class="row gy-5">
     
                    {{-- Featured post --}}
                    @if ($featuredPost)
                        <div class="col-md-8">
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="lp-featured">
                                <div class="lp-featured-media">
                                    <img
                                        src="{{ $featuredPost->image_url }}"
                                        alt="{{ $featuredPost->title }}"
                                        loading="lazy"
                                    >
                                </div>
                                <p class="lp-meta">
                                    {{ $featuredPost->category }} &middot; {{ $featuredPost->published_at->format('M j, Y') }}
                                </p>
                                <h3 class="font-display lp-featured-title">
                                    {{ $featuredPost->title }}
                                </h3>
                                <p class="lp-excerpt mb-0">
                                    {{ $featuredPost->excerpt }}
                                </p>
                            </a>
                        </div>
                    @endif
     
                    {{-- Recent posts list --}}
                    @if (isset($recentPosts) && $recentPosts->isNotEmpty())
                        <div class="col-md-4">
                            <div class="d-flex flex-column">
                                @foreach ($recentPosts as $post)
                                    @include ("theme::posts/single", [
                                        "post" => $post
                                    ])
                                @endforeach
                            </div>
                        </div>
                    @endif
     
                </div>
     
            @endif
        </div>
    </section>

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

                        </div>

                        <a href="{{ route('apps.detail', [ 'identifier' => $app->identifier ]) }}" class="btn btn-dark">
                            View Details
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
                        <div class="col-12 col-lg-4">

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