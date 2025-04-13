@extends('client.layouts.master')

@section('content')

<style>
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-start;
    }

    .rating-stars input[type="radio"] {
        opacity: 0;
        position: absolute;
    }


    .rating-stars label {
        font-size: 28px;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
        margin: 0 2px;
    }

    .rating-stars input[type="radio"]:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #FFD700;
    }
</style>


<div id="header" class="header-default">
    <div class="px_15 lg-px_40">
        <div class="row wrapper-header align-items-center">
            <div class="col-md-4 col-3 tf-lg-hidden">
                <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"></a>
            </div>
        </div>
    </div>
</div>


<div class="tf-breadcrumb">
    <div class="container">
        <div class="tf-breadcrumb-wrap d-flex justify-content-between flex-wrap align-items-center">
            <div class="tf-breadcrumb-list">
                <a href="index.php" class="text">Trang Chủ</a>
                <i class="icon icon-arrow-right"></i>
                <a href="#" class="text">Danh Mục</a>
                <i class="icon icon-arrow-right"></i>
                <span class="text"><?= $product['ten_san_pham']; ?></span>
            </div>
        </div>
    </div>
</div>
<!-- default -->
<section class="flat-spacing-4 pt_0">
    <div class="tf-main-product section-image-zoom">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="tf-product-media-wrap sticky-top">
                        <div class="thumbs-slider">

                            <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide" data-color="beige">
                                        <a href="{{ Storage::url($product['img']) }}" target="_blank" class="item" data-pswp-width="770px" data-pswp-height="1075px">
                                            <img class="tf-image-zoom ls-is-cached lazyloaded" data-zoom="{{ Storage::url($product['img']) }}" data-src="{{ Storage::url($product['img']) }}" src="{{ Storage::url($product['img']) }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tf-product-info-wrap position-relative">
                        <div class="tf-zoom-main"></div>
                        <div class="tf-product-info-list other-image-zoom">
                            <div class="tf-product-info-title">
                                <h5><?= $product['ten_san_pham'] ?></h5>
                            </div>
                            <div class="tf-product-info-badges">
                                <div class="badges"><?= $product->categories->ten_danh_muc ?></div>
                            </div>
                            <div class="tf-product-info-price">
                                <?php if ($product['gia_khuyen_mai']) { ?>
                                    <div class="price-on-sale"><?= number_format($product['gia_khuyen_mai']) . 'VND'; ?></div>
                                    <div class="compare-at-price"><?= number_format($product['gia']) . 'VND'; ?></div>
                                <?php } else { ?>
                                    <div class="price-on-sale"><?= number_format($product['gia']) . 'VND'; ?></div>
                                <?php } ?>
                                <div class="badges-on-sale"><span>20</span>% OFF</div>
                            </div>
                            <div class="availability">
                                <i class="fa fa-check-circle"></i>
                                <span ><?= $product['so_luong'] . ' trong kho' ?></span>
                            </div>
                            <div class="tf-product-info-variant-picker">
                                <div class="variant-picker-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="variant-picker-label">
                                            <span class="fw-6 variant-picker-label-value"><?= $product['mo_ta'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tf-product-info-quantity">
                                <div class="quantity-title fw-6">Số lượng</div>
                                <div class="wg-quantity">
                                    <span class="btn-quantity btn-decrease">-</span>
                                    <input type="text" class="quantity-product" name="so_luong" value="1" data-max="{{ $product['so_luong'] }}">
                                    <span class="btn-quantity btn-increase">+</span>
                                </div>
                            </div>
                            <div class="tf-product-info-buy-button">
                                <div class="d-flex mt-3">
                                    <form action="{{ route('client.addToCart') }}" method="POST" class="box-icon bg_white add-to-cart w-100">
                                        @csrf
                                        <input type="hidden" name="san_pham_id" value="{{ $product->id }}">
                                        <input type="hidden" name="so_luong" class="quantity-hidden" value="1">
                                        <button type="submit" class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart">
                                            <span>Thêm vào giỏ hàng</span>
                                        </button>
                                    </form>
                                    <form action="" method="POST" class="box-icon bg_white add-to-wishlist">
                                        @csrf
                                        <input type="hidden" name="san_pham_id" value="{{ $product->id }}">
                                        <button type="submit" class="tf-product-btn-wishlist hover-tooltip box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Thêm vào Wishlist</span>
                                        </button>
                                    </form>
                                </div>

                                <form action="">
                                <div class="w-100">
                                    <a href="#" class="btns-full">Mau ngay</a>
                                    <a href="#" class="payment-more-option">More payment options</a>
                                </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /default -->
<!-- Hiển thị bình luận -->
<section class="flat-spacing-17 pt_0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="widget-tabs style-has-border">
                    <ul class="widget-menu-tab">
                        <li class="item-title active">
                            <span class="inner">Bình Luận</span>
                        </li>
                    </ul>
                    <div class="widget-content-tab">
                        <div class="widget-content-inner active">
                            <div class="reply-comment cancel-review-wrap">
                                <div class="reply-comment-wrap">
                                    <?php foreach ($comments as $comment): ?>
                                        <div class="reply-comment-item">
                                            <div class="user">
                                                {{-- <div class="image">
                                                    <img src="<?= $comment->customer->anh_dai_dien ?>" alt="">
                                                </div> --}}
                                                <div>
                                                    <p><?= $comment->customer->ten_khach_hang ?></p>
                                                </div>
                                            </div>
                                            <p class="text_black-3"><?= $comment['comment']; ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <br>
                            <form action="{{ route('client.reviewsStore')}}" method="POST" class="form-write-review write-review-wrap">
                                @csrf
                                <div class="form-content">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    @if(Auth::check())
                                        <input type="hidden" name="customer_id" value="{{ Auth::id() }}">
                                    @endif

                                    <fieldset class="box-field mb-3">
                                        <label class="label">Đánh Giá Sao</label>
                                        <div class="rating-stars">
                                            <input type="radio" id="star5" name="rating" value="5" />
                                            <label for="star5" title="5 sao">&#9733;</label>

                                            <input type="radio" id="star4" name="rating" value="4" />
                                            <label for="star4" title="4 sao">&#9733;</label>

                                            <input type="radio" id="star3" name="rating" value="3" />
                                            <label for="star3" title="3 sao">&#9733;</label>

                                            <input type="radio" id="star2" name="rating" value="2" />
                                            <label for="star2" title="2 sao">&#9733;</label>

                                            <input type="radio" id="star1" name="rating" value="1" />
                                            <label for="star1" title="1 sao">&#9733;</label>
                                        </div>
                                        @error('rating')
                                            <span class="text-danger">{{ $errors->first('rating') }}</span>
                                        @enderror
                                    </fieldset>
                                    <fieldset class="box-field">
                                        <label class="label">Viết Bình Luận</label>
                                        <textarea name="noi_dung" rows="4" placeholder="Viết Bình Luận Của Bạn Tại Đây" tabindex="2" aria-required="true" ></textarea>
                                        @error('noi_dung')
                                            <span class="text-danger">{{ $errors->first('noi_dung') }}</span>
                                        @enderror
                                    </fieldset>
                                </div>
                                <div class="button-submit">
                                    <button class="tf-btn btn-fill animate-hover-btn" type="submit">Bình Luận</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product -->
<section class="flat-spacing-1 pt_0">
    <div class="container">
        <div class="flat-title">
            <span class="title">Sản phẩm liên quan</span>
        </div>
        <div class="hover-sw-nav hover-sw-2">
            <div dir="ltr" class="swiper tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3" data-mobile="2" data-space-lg="30" data-space-md="15" data-pagination="2" data-pagination-md="3" data-pagination-lg="3">
                <div class="swiper-wrapper">
                    @foreach ($productByCategory as $product)
                            <div class="swiper-slide" lazy="true">
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('client.showProduct', $product['id']) }}" class="product-img">
                                            <img class="lazyload img-product" data-src="{{ asset(Storage::url($product['img'])) }}" src="{{ asset(Storage::url($product['img'])) }}" alt="image-product">
                                            <img class="lazyload img-hover" data-src="{{ asset(Storage::url($product['img'])) }}" src="{{ asset(Storage::url($product['img'])) }}" alt="image-product">
                                        </a>

                                        @if ($product['gia_khuyen_mai'])
                                            <div class="product-badge">
                                                <div class="product-label discount">
                                                    <span>Giảm giá</span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="list-product-btn">

                                            <form action="{{ route('client.addToCart') }}" method="post" class="box-icon bg_white quick-add tf-btn-loading">
                                                @csrf
                                                <input type="hidden" name="san_pham_id" value="{{ $product->id }}">
                                                <button type="submit" class="icon icon-bag" style="border: none; background-color: white; outline: none;"></button>
                                                <span class="tooltip">Thêm Giỏ Hàng</span>
                                            </form>
                                            <a href="#" class="box-icon bg_white wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Thêm Sản Phẩm Yêu Thích</span>
                                                <span class="icon icon-delete"></span>
                                            </a>
                                            <a href="" class="box-icon bg_white quickview tf-btn-loading">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">Xem Sản Phẩm</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="card-product-info">
                                        <a href="{{ route('client.showProduct', $product['id']) }}" class="title link">{{ $product['ten_san_pham'] }}</a>
                                        @if ($product['gia_khuyen_mai'])
                                            <span class="price-regular">{{ number_format($product['gia_khuyen_mai']) }}đ</span>
                                            <span class="price-old"><del>{{ number_format($product['gia']) }}đ</del></span>
                                        @else
                                            <span class="price-regular">{{ number_format($product['gia']) }}đ</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                </div>
            </div>
            <div class="nav-sw nav-next-slider nav-next-product box-icon w_46 round"><span class="icon icon-arrow-left"></span></div>
            <div class="nav-sw nav-prev-slider nav-prev-product box-icon w_46 round"><span class="icon icon-arrow-right"></span></div>
            <div class="sw-dots style-2 sw-pagination-product justify-content-center"></div>
        </div>
    </div>
</section>
<!-- nội dung HTML chi tiết sản phẩm -->


@endsection
@section('scripts')
<script>
    $(document).ready(function() {
    // Khi click tăng số lượng
    $('.btn-increase').click(function() {
        let input =$(this).siblings('.quantity-product');
        let max= parseInt(input.data('max'));
        // console.log(max);
        let currentVal = parseInt(input.val()) || 1;
        if (currentVal < max) {
            input.val(currentVal).trigger('change');
        }else{
            alert('Không thể vượt quá số lượng trong kho!');
        }

    });
    // Khi click giảm số lượng
    $('.btn-decrease').click(function () {
        let $input = $(this).siblings('.quantity-product');
        let currentVal = parseInt($input.val()) || 1;

        if (currentVal > 1) {
            $input.val(currentVal - 1).trigger('change');
        }
    });

    // Khi thay đổi số lượng thì cập nhật vào input ẩn trong form
    $('.quantity-product').on('change keyup', function () {
        let $input = $(this);
        let max = parseInt($input.data('max'));
        let val = parseInt($input.val()) || 1;

        if (val > max) {
            alert('Không thể vượt quá số lượng trong kho!');
            $input.val(max);
            val = max;
        } else if (val < 1) {
            $input.val(1);
            val = 1;
        }

        $('.quantity-hidden').val(val);
    });

    // Đồng bộ số lượng khi submit form (tránh trường hợp user nhập tay mà chưa nhấn enter)
    $('.btn-add-to-cart').click(function() {
        let quantity = parseInt($('.quantity-product').val()) || 1;
        $('.quantity-hidden').val(quantity);
    });
});

</script>

@endsection
