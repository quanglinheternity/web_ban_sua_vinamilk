@extends('client.layouts.master')

@section('content')

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
                                <span><?= $product['so_luong'] . ' trong kho' ?></span>
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
                                    <input type="text" class="quantity-product" name="number" value="1">
                                    <span class="btn-quantity btn-increase">+</span>
                                </div>
                            </div>
                            <div class="tf-product-info-buy-button">
                                <form class="">
                                <input type="hidden" name="number" class="quantity-hidden" value="1"> <!-- Input ẩn để gửi số lượng -->
                                    <a href="" class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart">
                                        <span>Thêm vào giỏ hàng</span></a>
                                    <a href="" class="tf-product-btn-wishlist hover-tooltip box-icon bg_white wishlist btn-icon-action">
                                        <span class="icon icon-heart"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                        <span class="icon icon-delete"></span>
                                    </a>
                                    <div class="w-100">
                                        <a href="#" class="btns-full">Mau ngay <img src="images/payments/paypal.png" alt=""></a>
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
                            <form action="?act=addcomment" method="POST" class="form-write-review write-review-wrap">
                                <div class="form-content">
                                    <fieldset class="box-field">
                                        <label class="label">Viết Bình Luận</label>
                                        <textarea name="noi_dung" rows="4" placeholder="Viết Bình Luận Của Bạn Tại Đây" tabindex="2" aria-required="true" required=""></textarea>
                                        <input type="hidden" name="san_pham_id" value="<?= $product['id']; ?>">
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
                                            <a href="" class="box-icon bg_white quick-add tf-btn-loading">
                                                <span class="icon icon-bag"></span>
                                                <span class="tooltip">Thêm Giỏ Hàng</span>
                                            </a>
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

<script>
    document.querySelectorAll('.btn-quantity').forEach(function(button) {
        button.addEventListener('click', function() {
            var quantityInput = document.querySelector('.quantity-product');
            var quantityValue = parseInt(quantityInput.value);
            if (button.classList.contains('btn-increase')) {
                quantityValue++;
                // console.log(quantityValue);
            } else if (button.classList.contains('btn-decrease') && quantityValue > 1) {
                quantityValue--;
            }
            quantityInput.value = quantityValue;
            var addToCartLink = document.getElementById('add-to-cart');

            Cập nhật giá trị số lượng trong href của liên kết
            if (addToCartLink) {
                var url = addToCartLink.getAttribute('href');
                var newUrl = url.replace(/(&number=\d+)/, '&number=' + quantityValue);
                addToCartLink.setAttribute('href', newUrl);
            }
        });
    });
</script>


@endsection
