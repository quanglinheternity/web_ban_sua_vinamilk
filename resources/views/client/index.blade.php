@extends('client.layouts.master')

@section('content')
    @include('client.layouts.banner')
    <!-- Sản Phẩm Nổi Bật  -->
    <section class="flat-spacing-5 pt_0 flat-seller">
        <div class="container">
            <div class="flat-title">
                <span class="title wow fadeInUp" data-wow-delay="0s">Sản Phẩm Nổi Bật</span>
                <p class="sub-title wow fadeInUp" data-wow-delay="0s">Top 4 Sản Phẩm Nổi Bật Nhất Tháng {{ date('m/Y') }}</p>
            </div>
            <div class="grid-layout  wow fadeInUp" data-wow-delay="0s" data-grid="grid-4">
                <?php foreach ($top5Products as $top5) { ?>
                    <div class="card-product fl-item">
                        <div class="card-product-wrapper">
                            <a href="{{ route('client.showProduct', $top5['id'])}}" class="product-img">
                                <img class="lazyload img-product" data-src="{{ asset(Storage::url( $top5['img']) )}}" src="{{ asset(Storage::url( $top5['img']) )}}" alt="image-product">
                                <img class="lazyload img-hover" data-src="{{ asset(Storage::url( $top5['img']) )}}" src="{{ asset(Storage::url( $top5['img']) )}}" alt="image-product">
                            </a>
                            <div class="list-product-btn">
                                <form action="{{ route('client.addToCart') }}" method="post" class="box-icon bg_white add-to-cart">
                                    @csrf
                                    <input type="hidden" name="san_pham_id" value="{{ $top5->id }}">
                                    {{-- <input type="hidden" name="so_luong" value="1"> --}}
                                    <button type="submit" class="icon icon-bag" style="border: none; background-color: white; outline: none;"></button>
                                    <span class="tooltip">Thêm Giỏ Hàng</span>
                                </form>

                                <a href="" class="box-icon bg_white wishlist btn-icon-action">
                                    <span class="icon icon-heart"></span>
                                    <span class="tooltip">Thêm Sản Phẩm Yêu Thích</span>
                                    <span class="icon icon-delete"></span>
                                </a>
                                <a href="{{ route('client.showProduct', $top5['id'])}}"  class="box-icon bg_white quickview tf-btn-loading">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Xem Sản Phẩm</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="title link"><?= $top5['ten_san_pham'] ?></a>
                            <span class="price"><?= number_format($top5['gia_khuyen_mai'] ?? $top5['gia']) ?>vnđ</span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
     <!-- dánh sách sản phẩm -->
     <section class="flat-spacing-5 pt_0 flat-seller">
        <div class="container">
            <div class="flat-title">
                <span class="title wow fadeInUp" data-wow-delay="0s">Danh Sách Sản Phẩm</span>
                <p class="sub-title wow fadeInUp" data-wow-delay="0s"></p>
            </div>
            <div class="grid-layout  wow fadeInUp" data-wow-delay="0s" data-grid="grid-4">
                <?php foreach ($listProducts as $listProduct) { ?>
                    <div class="card-product fl-item">
                        <div class="card-product-wrapper">
                            <a href="{{ route('client.showProduct', $listProduct['id'])}}" class="product-img">
                                <img class="lazyload img-product" data-src="{{ asset(Storage::url( $listProduct['img']) )}}" src="{{ asset(Storage::url( $listProduct['img']) )}}" alt="image-product">
                                <img class="lazyload img-hover" data-src="{{ asset(Storage::url( $listProduct['img']) )}}" src="{{ asset(Storage::url( $listProduct['img']) )}}" alt="image-product">
                            </a>
                            <div class="list-product-btn">
                                <form action="{{ route('client.addToCart') }}" method="post" class="box-icon bg_white add-to-cart">
                                    @csrf
                                    <input type="hidden" name="san_pham_id" value="{{ $listProduct->id }}">
                                    {{-- <input type="hidden" name="so_luong" value="1"> --}}
                                    <button type="submit" class="icon icon-bag" style="border: none; background-color: white; outline: none;"></button>
                                    <span class="tooltip">Thêm Giỏ Hàng</span>
                                </form>
                                <a href="" class="box-icon bg_white wishlist btn-icon-action">
                                    <span class="icon icon-heart"></span>
                                    <span class="tooltip">Thêm Sản Phẩm Yêu Thích</span>
                                    <span class="icon icon-delete"></span>
                                </a>
                                <a href="{{ route('client.showProduct', ['id' => $listProduct['id']]) }}"  class="box-icon bg_white quickview tf-btn-loading">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Xem Sản Phẩm</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="title link"><?= $listProduct['ten_san_pham'] ?></a>
                            <span class="price"><?= number_format($listProduct['gia_khuyen_mai'] ?? $listProduct['gia']) ?>vnđ</span>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="tf-pagination-wrap view-more-button text-center">
                <a href="{{ route('client.ListProducts')}}"><button class="tf-btn-loading tf-loading-default style-2 btn-loadmore "><span class="text">Xem Thêm</span></button></a>
            </div>
        </div>
    </section>

    <!-- đánh Giá -->
    <section class="flat-spacing-5 pt_0 flat-testimonial">
        <div class="container">
            <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                <span class="title">Đánh Giá Khách Hàng</span>
                <p class="sub-title">Khách Hàng Nói Gì Về  Sản Phẩm Của Chúng Tôi</p>
            </div>
            <div class="wrap-carousel">
                <div dir="ltr" class="swiper tf-sw-testimonial" data-preview="3" data-tablet="2" data-mobile="1" data-space-lg="30" data-space-md="15">
                    <div class="swiper-wrapper">
                        <?php foreach ($top5DanhGia as $top5DG) { ?>
                            <div class="swiper-slide ">
                                <div class="testimonial-item style-column wow fadeInUp" data-wow-delay="0s">
                                    <div class="mb-2 ms-1">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $top5DG['rating']) { ?>
                                                <span style="color: gold;"><i class="fas fa-star"></i></span>
                                            <?php } else { ?>
                                                <span style="color: gray;"><i class="fas fa-star"></i></span>
                                        <?php }
                                        } ?>
                                    </div>
                                    <div class="text">
                                        “{{ $top5DG['comment'] }}”
                                    </div>
                                    <div class="author">
                                        <div class="name">{{ $top5DG->customer->ten_khach_hang }}</div>
                                    </div>
                                    <div class="product">
                                        <div class="image">
                                            <a href="">
                                                <img class="lazyload" data-src="" src="" alt="">
                                            </a>
                                        </div>
                                        <div class="content-wrap">
                                            <div class="product-title">
                                                <a href="">{{ $top5DG->product->ten_san_pham }}</a>
                                            </div>
                                            <div class="price">{{ number_format($top5DG->product->gia_khuyen_mai ?? $top5DG->product->gia) }}</div>
                                        </div>
                                        <a href="" class=""><i class="icon-arrow1-top-left"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="nav-sw nav-next-slider nav-next-testimonial lg"><span class="icon icon-arrow-left"></span></div>
                <div class="nav-sw nav-prev-slider nav-prev-testimonial lg"><span class="icon icon-arrow-right"></span></div>
                <div class="sw-dots style-2 sw-pagination-testimonial justify-content-center"></div>
            </div>
        </div>
    </section>
    <!-- tin tức -->

    <section class="mb_30">
        <div class="container">
            <div class="flat-title">
                <h5 class="">Bài Viết Hay</h5>
            </div>
            <div class="hover-sw-nav view-default hover-sw-5">
                <div dir="ltr" class="swiper tf-sw-recent" data-preview="3" data-tablet="2" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <?php  foreach($listNews as $listNew){ ?>
                        <div class="swiper-slide" lazy="true">
                            <div class="blog-article-item">
                                <div class="article-thumb radius-10">
                                    <a href="">
                                        {{-- <img class="lazyload" style="width: 430px; height: 240px;" data-src="{{ asset(Storage::url( $listNew['imge']) )}}" src="{{ asset(Storage::url( $listNew['imge'])  )}}" alt="img-blog"> --}}
                                        <img class="lazyload" style="width: 430px; height: 240px;" data-src="{{ asset( $listNew['imge'] )}}" src="{{ $listNew['imge'] }}" alt="img-blog">
                                    </a>
                                </div>
                                <div class="article-content">
                                    <div class="article-title">
                                        <a href="" class="">{{substr($listNew['title'],0,50) . '...' }}</a>
                                    </div>
                                    <div class="article-btn">
                                        <a href="" class="tf-btn btn-line fw-6">Đọc Tiếp<i class="icon icon-arrow1-top-left"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="nav-sw nav-next-slider nav-next-recent box-icon w_46 round"><span class="icon icon-arrow-left"></span></div>
                <div class="nav-sw nav-prev-slider nav-prev-recent box-icon w_46 round"><span class="icon icon-arrow-right"></span></div>
                <div class="sw-dots d-flex style-2 sw-pagination-recent justify-content-center"></div>
            </div>
        </div>
    </section>
@endsection
