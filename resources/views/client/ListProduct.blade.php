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
<div class="tf-page-title">
    <div class="container-full">
        <div class="heading text-center">Danh muc</div>
    </div>
</div>
<section class="flat-spacing-1">
    <div class="container">
        <div class="tf-shop-control grid-3 align-items-center">
            <div class="tf-control-filter">
                <!-- <a href="#filterShop" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft" class="tf-btn-filter"><span class="icon icon-filter"></span><span class="text">Filter</span></a> -->
            </div>

        </div>
        <div class="tf-row-flex">
            <aside class="tf-shop-sidebar wrap-sidebar-mobile">
                <div class="widget-facet wd-categories">
                    <div class="widget-facet wd-categories">
                        <div class="facet-title" data-bs-target="#categories" data-bs-toggle="collapse" aria-expanded="true" aria-controls="categories">
                            <span>Danh Mục Thú Cưng</span>
                            <span class="icon icon-arrow-up"></span>
                        </div>
                        <div id="categories" class="collapse show">
                            <ul class="list-categoris current-scrollbar mb_36">
                                @foreach ($listCategories as $listCategory  )
                                <li class="cate-item {{ request('category_id') == $listCategory->id ? 'active' : '' }}">
                                    <a href="{{ url()->current() }}?category_id={{ $listCategory->id }}">
                                        <span>{{ $listCategory->ten_danh_muc }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="widget-facet">
                    <div class="widget-facet">
                        <div class="facet-title" data-bs-target="#sale-products" data-bs-toggle="collapse" aria-expanded="true" aria-controls="sale-products">
                            <span>Sale products</span>
                            <span class="icon icon-arrow-up"></span>
                        </div>
                        <div id="sale-products" class="collapse show">
                            <div class="widget-featured-products mb_36">
                                {{-- <?php foreach($listProductSales as $listProductSale){ ?>
                                <div class="featured-product-item">
                                    <a href="<?= BASE_URL . '?act=show-product&id=' . $listProductSale['id_san_pham'] ?>" class="card-product-wrapper">
                                        <img class="img-product ls-is-cached lazyloaded" data-src="<?= BASE_URL . $listProductSale['hinh_anh'] ?>" alt="image-feature" src="<?= BASE_URL . $listProductSale['hinh_anh'] ?>">
                                    </a>
                                    <div class="card-product-info">
                                        <a href="<?= BASE_URL . '?act=show-product&id=' . $listProductSale['id_san_pham'] ?>" class="title link"><?= $listProductSale['ten_san_pham'] ?></a>
                                        <span class="price"><?= number_format($listProductSale['gia_san_pham'] * $listProductSale['gia_tri'] / 100) ?></span>
                                    </div>
                                </div>
                                <?php } ?> --}}
                            </div>
                        </div>
                    </div>

                </div>

            </aside>
            <div class="tf-shop-content">
                <div class="grid-layout wrapper-shop" data-grid="grid-3">
                    <?php foreach ($listProducts as $listProduct) { ?>
                        <div class="card-product fl-item">
                            <div class="card-product-wrapper">
                                <a href="{{ route('client.showProduct', $listProduct['id'])}}" class="product-img">
                                    <img class="lazyload img-product" data-src="{{ asset(Storage::url( $listProduct['img']) )}}" src="{{ asset(Storage::url( $listProduct['img']) )}}" alt="image-product">
                                    <img class="lazyload img-hover" data-src="{{ asset(Storage::url( $listProduct['img']) )}}" src="{{ asset(Storage::url( $listProduct['img']) )}}" alt="image-product">
                                </a>
                                <div class="list-product-btn">
                                    <a href=""  class="box-icon bg_white quick-add tf-btn-loading">
                                        <span class="icon icon-bag"></span>
                                        <span class="tooltip">Thêm Giỏ Hàng</span>
                                    </a>
                                    <a href="" class="box-icon bg_white wishlist btn-icon-action">
                                        <span class="icon icon-heart"></span>
                                        <span class="tooltip">Thêm Sản Phẩm Yêu Thích</span>
                                        <span class="icon icon-delete"></span>
                                    </a>
                                    <a href="{{ route('client.showProduct', $listProduct['id'])}}"  class="box-icon bg_white quickview tf-btn-loading">
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
                <div class="tf-pagination">
                    <div class="tf-pagination-wrap">
                        <div class="tf-pagination-content">
                            {{ $listProducts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>



@endsection
