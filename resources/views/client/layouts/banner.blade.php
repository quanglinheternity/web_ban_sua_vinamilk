<div class="tf-slideshow slider-effect-fade position-relative">
    <div style="width: 100%; height: 940px;"  dir="ltr" class="swiper tf-sw-slideshow" data-preview="1" data-tablet="1" data-mobile="1" data-centered="false" data-space="0" data-loop="true" data-auto-play="true" data-delay="0" data-speed="1000">
        <div  class="swiper-wrapper">
            <?php foreach($listBanners as $listBanner) { ?>
            <div class="swiper-slide">
                <div class="wrap-slider">
                    <img src="{{ asset( Storage::url($listBanner->image )) }} " alt="fashion-slideshow">
                    {{-- <div class="box-content">
                        <div class="container">
                            <h1 class="fade-item fade-item-1">Siêu Thị Thú Cưng<br>PawPaw</h1>
                            <p class="fade-item fade-item-2">Những Chú Thú Cưng Mới Nhất</p>
                            <a href="" class="fade-item fade-item-3 tf-btn btn-fill animate-hover-btn btn-xl radius-3"><span>Tham Quan Shop</span><i class="icon icon-arrow-right"></i></a>
                        </div>
                    </div> --}}
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="wrap-pagination">
        <div class="container">
            <div class="sw-dots sw-pagination-slider justify-content-center"></div>
        </div>
    </div>
</div>
