@extends ("theme::layouts/app")

@section ("main")

    <!-- Main Content -->
    <main class="container">

        <section class="product-detail-section py-5">

            <div class="container">

                <div class="row g-5">


                    <!-- Product Gallery -->
                    <div class="col-lg-6">

                        <div class="product-gallery">

                            <div class="main-product-image mb-3">

                                <!-- <span class="badge bg-danger product-badge">
                                    Sale
                                </span> -->

                                <img src="{{ $product->image ? $product->image->file_path_absolute : 'https://via.placeholder.com/700x700' }}"
                                     class="img-fluid"
                                     alt="{{ $product->title }}">

                            </div>


                            <!-- <div class="row g-3">

                                <div class="col-3">
                                    <div class="thumbnail active">
                                        <img src="https://via.placeholder.com/150"
                                             class="img-fluid">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="thumbnail">
                                        <img src="https://via.placeholder.com/150"
                                             class="img-fluid">
                                    </div>
                                </div>

                            </div> -->

                        </div>

                    </div>



                    <!-- Product Information -->
                    <div class="col-lg-6">


                        <div class="product-info">


                            <div class="text-muted mb-2">
                                {{ $product->sku }}
                            </div>


                            <h1 class="product-title">
                                {{ $product->title }}
                            </h1>



                            <!-- <div class="product-rating mb-3">

                                <span>
                                    ★★★★★
                                </span>

                                <a href="#">
                                    124 Reviews
                                </a>

                            </div> -->



                            <div class="price-area mb-4">

                                <span class="current-price">
                                    {{ env('CURRENCY_SYMBOL') }}{{ $product->price }}
                                </span>

                                <!-- <span class="old-price">
                                    $159
                                </span> -->

                            </div>



                            <div class="product-description">

                                {!! $product->excerpt !!}

                            </div>



                            <hr>



                            <!-- Options -->

                            <!-- <div class="mb-4">

                                <label class="fw-semibold mb-2">
                                    Color
                                </label>

                                <div class="d-flex gap-2">

                                    <button class="color-option active"></button>
                                    <button class="color-option black"></button>
                                    <button class="color-option blue"></button>

                                </div>

                            </div> -->



                            <!-- Quantity -->

                            <!-- <div class="mb-4">

                                <label class="fw-semibold mb-2">
                                    Quantity
                                </label>


                                <div class="quantity-box">

                                    <button>
                                        -
                                    </button>

                                    <input value="1">

                                    <button>
                                        +
                                    </button>

                                </div>

                            </div> -->


                            <a href="https://wa.me/923156041304" class="contact-buy-btn"
                                target="_blank">
                                <i class="fa-brands fa-whatsapp"></i>
                                Contact Us To Buy
                            </a>

                            <!-- Actions -->

                            <!-- <div class="d-flex gap-3 mb-4">

                                <button class="btn btn-dark btn-lg flex-grow-1">
                                    <i class="bi bi-cart"></i>
                                    Add To Cart
                                </button>


                                <button class="btn btn-primary btn-lg flex-grow-1">
                                    Buy Now
                                </button>

                            </div> -->



                            <!-- Meta -->

                            <div class="product-meta">

                                <div>
                                    <strong>SKU:</strong>
                                    {{ $product->sku }}
                                </div>

                                <div>
                                    <strong>Category:</strong>
                                    {{ implode(',', $product->categories) }}
                                </div>

                                <!-- <div>
                                    <strong>Availability:</strong>
                                    <span class="text-success">
                                        In Stock
                                    </span>
                                </div> -->

                            </div>


                        </div>


                    </div>


                </div>


                <!-- Description Tabs -->
                <div class="product-tabs mt-5">

                    <ul class="nav nav-tabs" id="productTabs" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active"
                                    id="description-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#description"
                                    type="button"
                                    role="tab">

                                Description

                            </button>
                        </li>


                        <li class="nav-item" role="presentation">
                            <button class="nav-link"
                                    id="reviews-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#reviews"
                                    type="button"
                                    role="tab">

                                Reviews

                            </button>
                        </li>

                    </ul>


                    <div class="tab-content p-4 border border-top-0 rounded-bottom">

                        <div class="tab-pane fade show active"
                             id="description"
                             role="tabpanel">

                            <div>
                                {!! $product->content !!}
                            </div>

                        </div>



                        <div class="tab-pane fade"
                             id="reviews"
                             role="tabpanel">

                            <h5 class="mb-3">
                                Customer Reviews
                            </h5>

                            <p class="text-muted">
                                No reviews yet.
                            </p>

                        </div>


                    </div>

                </div>


            </div>

        </section>

    </main>

    <style>
        .contact-buy-btn {

            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;

            padding:15px 32px;

            border-radius:50px;

            background:linear-gradient(
                135deg,
                #111827,
                #2563eb
            );

            color:#fff;

            font-size:18px;
            font-weight:700;

            text-decoration:none;

            box-shadow:
                0 10px 25px rgba(37,99,235,.35);

            transition:all .3s ease;

            position:relative;
            overflow:hidden;

        }



        .contact-buy-btn::before {

            content:"";

            position:absolute;

            top:0;
            left:-100%;

            width:100%;
            height:100%;

            background:rgba(255,255,255,.15);

            transition:.4s ease;

        }



        .contact-buy-btn:hover::before {

            left:100%;

        }



        .contact-buy-btn:hover {

            color:#fff;

            transform:translateY(-3px);

            box-shadow:
                0 15px 35px rgba(37,99,235,.45);

        }



        .contact-buy-btn i {

            font-size:22px;

        }

        .product-detail-section {
            background:#fff;
        }


        /* Gallery */

        .main-product-image {

            height:600px;
            background:#f8f9fa;

            border-radius:20px;

            display:flex;
            align-items:center;
            justify-content:center;

            position:relative;

            overflow:hidden;

        }


        .main-product-image img {

            width:100%;
            height:100%;

            object-fit:cover;

        }


        .product-badge {

            position:absolute;
            top:20px;
            left:20px;

            font-size:14px;
            padding:8px 14px;

        }



        .thumbnail {

            height:100px;

            border-radius:12px;

            overflow:hidden;

            border:2px solid transparent;

            cursor:pointer;

            background:#f8f9fa;

        }


        .thumbnail.active {

            border-color:#212529;

        }


        .thumbnail img {

            width:100%;
            height:100%;

            object-fit:cover;

        }




        /* Information */


        .product-title {

            font-size:42px;
            font-weight:700;

            line-height:1.2;

        }



        .product-rating span {

            color:#ffc107;
            font-size:20px;

        }


        .product-rating a {

            color:#666;
            margin-left:10px;

        }



        .current-price {

            font-size:38px;
            font-weight:800;

        }


        .old-price {

            margin-left:15px;

            color:#999;

            text-decoration:line-through;

            font-size:20px;

        }



        .product-description {

            font-size:17px;

            color:#555;

            line-height:1.7;

        }




        /* Colors */


        .color-option {

            width:35px;
            height:35px;

            border-radius:50%;

            background:white;

            border:3px solid #111;

        }


        .color-option.black {

            background:#111;

            border-color:#111;

        }


        .color-option.blue {

            background:#2563eb;

            border-color:#2563eb;

        }



        .color-option.active {

            outline:3px solid #ddd;

        }




        /* Quantity */


        .quantity-box {

            display:flex;

            width:150px;

            border:1px solid #ddd;

            border-radius:10px;

            overflow:hidden;

        }


        .quantity-box button {

            width:45px;

            border:0;

            background:#f5f5f5;

            font-size:20px;

        }


        .quantity-box input {

            width:60px;

            text-align:center;

            border:0;

        }




        /* Meta */


        .product-meta {

            background:#f8f9fa;

            padding:20px;

            border-radius:15px;

            display:flex;

            flex-direction:column;

            gap:10px;

        }



        /* Tabs */

        .product-tabs .nav-link {

            color:#555;

        }


        .product-tabs .nav-link.active {

            font-weight:600;

        }



        /* Mobile */

        @media(max-width:768px){

            .main-product-image {
                height:350px;
            }


            .product-title {

                font-size:30px;

            }


            .current-price {

                font-size:30px;

            }

        }
    </style>

@endsection