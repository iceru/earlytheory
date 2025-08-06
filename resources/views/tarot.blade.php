<x-app-layout>
    @section('title')
        Early Theory - Homepage
    @endsection
    
    <!-- SKU Selection Popup -->
    <div id="skuPopup" class="sku-popup-overlay">
        <div class="sku-popup">
            <div class="sku-popup-header">
                <h3 id="popupProductTitle">Pilih Varian</h3>
                <button class="sku-popup-close" onclick="closeSkuPopup()">&times;</button>
            </div>
            <div class="sku-popup-content">
                <h4 class="mb-2">Pilih Area Ketemu</h4>
                <div id="skuVariants" class="sku-variants">
                    <!-- SKU variants will be populated here -->
                </div>
                <div class="sku-popup-actions">
                    <button class="button secondary" onclick="closeSkuPopup()">Batal</button>
                    <button id="addToCartBtn" class="button primary" onclick="addSelectedToCart()" disabled>Tambah ke Keranjang</button>
                </div>
            </div>
        </div>
    </div>

    <div class="index-tarot col-12">
        <div class="sliders-index sliders">
            @foreach ($sliders as $slider)
                <a target="_blank" href="{{ $slider->link }}">
                    <div class="slider-item">
                        <div class="ratio ratio-16x9">
                            <img data-lazy="{{ Storage::url('sliders-image/' . $slider->image) }}" alt="">
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="page-tabs">
        <a href="#products" class="tab active" id="productsTab">
            <h4>Tarot</h4>
        </a>
        <a href="#astrologi" class="tab" id="astrologiTab">
            <h4>Astrologi</h4>
        </a>
        <a href="#spiritual" class="tab" id="spiritualTab">
            <h4>Spiritual</h4>
        </a>
    </div>

    <div class="col-12 index-tarot">
        <div class="products mt-3 page active" id="products">
            <div class="title">
                Tarot
            </div>
            <div class="row">
                @forelse ($services as $product)
                    <div class="product-item-container col-6 col-md-4 col-lg-3">
                        <div class="product-image service-image">
                            @foreach ((array) json_decode($product->image) as $item)
                                <a href="/product/{{ $product->slug }}">
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ Storage::url('product-image/' . $item) }}" loading="lazy"
                                            alt="{{ $product->title }}">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="product-item">
                            <div class="product-title">
                                <a href="/product/{{ $product->slug }}">
                                    <h3>{{ $product->title }}</h3>
                                </a>
                            </div>
                            @if (!$product->discount_price)
                                <div class="prices skus">
                                    <p class="product-price mb-0">idr {{ number_format($product->price) }}
                                    </p>
                                </div>
                            @else
                                <div class="prices">
                                    <p class="product-price discount mb-0">idr
                                        {{ number_format($product->discount_price) }}
                                    </p>
                                    <span class="striked">idr {{ number_format($product->base_price) }}</span>
                                </div>
                            @endif
                            @if ($product->duration > 0)
                                <p class="duration">
                                    {{ $product->duration }} menit
                                </p>
                            @endif
                            <div class="product-desc">{{ $product->description_short }}</div>
                        </div>
                        <div data-id="{{ $product->id }}" 
                             data-title="{{ $product->title }}" 
                             class="button primary my-3 addcart">PESAN SEKARANG</div>
                    </div>
                @empty
                    <h4 class="evogria">No Product</h4>
                @endforelse
            </div>
        </div>
        <div class="astrologi mt-3 page active" id="astrologi">
            <div class="title">
                Astrologi
            </div>
            <div class="row products">
                @forelse ($astrologi as $product)
                    <div class="product-item-container col-6 col-md-4 col-lg-3">
                        <div class="product-image astrologi-image">
                            @foreach ((array) json_decode($product->image) as $item)
                                <a href="/product/{{ $product->slug }}">
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ Storage::url('product-image/' . $item) }}" loading="lazy"
                                            alt="{{ $product->title }}">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="product-item">
                            <div class="product-title">
                                <a href="/product/{{ $product->slug }}">
                                    <h3>{{ $product->title }}</h3>
                                </a>
                            </div>
                            @if (!$product->discount_price)
                                <div class="prices skus">
                                    <p class="product-price mb-0">idr {{ number_format($product->price) }}
                                    </p>
                                </div>
                            @else
                                <div class="prices">
                                    <p class="product-price discount mb-0">idr
                                        {{ number_format($product->discount_price) }}
                                    </p>
                                    <span class="striked">idr {{ number_format($product->base_price) }}</span>
                                </div>
                            @endif
                            @if ($product->duration > 0)
                                <p class="duration">
                                    {{ $product->duration }} menit
                                </p>
                            @endif
                            <div class="product-desc">{{ $product->description_short }}</div>
                        </div>
                        <div data-id="{{ $product->id }}" 
                             data-title="{{ $product->title }}" 
                             class="button primary my-3 addcart">PESAN SEKARANG</div>
                    </div>
                @empty
                    <h4 class="evogria">No Product</h4>
                @endforelse
            </div>
        </div>
        <div class="spiritual mt-3 page active" id="spiritual">
            <div class="title">
                Spiritual
            </div>
            <div class="row products">
                @forelse ($spiritual as $product)
                    <div class="product-item-container col-6 col-md-4 col-lg-3">
                        <div class="product-image spiritual-image">
                            @foreach ((array) json_decode($product->image) as $item)
                                <a href="/product/{{ $product->slug }}">
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ Storage::url('product-image/' . $item) }}" loading="lazy"
                                            alt="{{ $product->title }}">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="product-item">
                            <div class="product-title">
                                <a href="/product/{{ $product->slug }}">
                                    <h3>{{ $product->title }}</h3>
                                </a>
                            </div>
                            @if (!$product->discount_price)
                                <div class="prices skus">
                                    <p class="product-price mb-0">idr {{ number_format($product->price) }}
                                    </p>
                                </div>
                            @else
                                <div class="prices">
                                    <p class="product-price discount mb-0">idr
                                        {{ number_format($product->discount_price) }}
                                    </p>
                                    <span class="striked">idr {{ number_format($product->base_price) }}</span>
                                </div>
                            @endif
                            @if ($product->duration > 0)
                                <p class="duration">
                                    {{ $product->duration }} menit
                                </p>
                            @endif
                            <div class="product-desc">{{ $product->description_short }}</div>
                        </div>
                        <div data-id="{{ $product->id }}" 
                             data-title="{{ $product->title }}" 
                             class="button primary my-3 addcart">PESAN SEKARANG</div>
                    </div>
                @empty
                    <h4 class="evogria">No Product</h4>
                @endforelse
            </div>
        </div>
    </div>

    @section('js')
        <style>
            /* SKU Popup Styles */
            .sku-popup-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: none;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }
            
            .sku-popup-overlay.active {
                display: flex;
            }
            
            .sku-popup {
                background: white;
                border-radius: 10px;
                max-width: 500px;
                width: 90%;
                max-height: 80vh;
                overflow-y: auto;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            }
            
            .sku-popup-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px;
                border-bottom: 1px solid #eee;
            }
            
            .sku-popup-header h3 {
                margin: 0;
                font-size: 1.2em;
            }
            
            .sku-popup-close {
                background: none;
                border: none;
                font-size: 24px;
                cursor: pointer;
                padding: 0;
                width: 30px;
                height: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .sku-popup-content {
                padding: 20px;
            }
            
            .sku-variants {
                margin-bottom: 20px;
            }
            
            .sku-variant {
                border: 2px solid #eee;
                border-radius: 8px;
                padding: 15px;
                margin-bottom: 10px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .sku-variant:hover {
                border-color: #ddd;
                background-color: #f8f9fa;
            }
            
            .sku-variant.selected {
                border-color: #007bff;
                background-color: #e7f3ff;
            }
            
            .sku-variant-name {
                font-weight: bold;
                margin-bottom: 5px;
            }
            
            .sku-variant-price {
                color: #333;
                font-size: 1.1em;
            }
            
            .sku-variant-price .discount {
                color: #e74c3c;
                font-weight: bold;
            }
            
            .sku-variant-price .striked {
                text-decoration: line-through;
                color: #999;
                margin-left: 10px;
            }
            
            .sku-popup-actions {
                display: flex;
                gap: 10px;
                justify-content: flex-end;
            }
            
            .button.secondary {
                background: #6c757d;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            }
            
            .button.primary:disabled {
                background: #ccc;
                cursor: not-allowed;
            }
        </style>
        
        <script>
            let selectedSku = null;
            let currentProductId = null;
            
            function openSkuPopup(productId, productTitle, productSkus) {
                currentProductId = productId;
                selectedSku = null;
                
                document.getElementById('popupProductTitle').textContent = productTitle;
                const skuContainer = document.getElementById('skuVariants');
                skuContainer.innerHTML = '';
                
                // Populate SKU variants
                productSkus.forEach(sku => {
                    const skuDiv = document.createElement('div');
                    skuDiv.className = 'sku-variant';
                    skuDiv.setAttribute('data-sku-id', sku.id);
                    
                    let priceHtml = '';
                    if (sku.base_price && sku.base_price > sku.price) {
                        priceHtml = `
                            <div class="sku-variant-price">
                                <span class="discount">IDR ${parseInt(sku.price).toLocaleString()}</span>
                                <span class="striked">IDR ${parseInt(sku.base_price).toLocaleString()}</span>
                            </div>
                        `;
                    } else {
                        priceHtml = `
                            <div class="sku-variant-price">
                                IDR ${parseInt(sku.price).toLocaleString()}
                            </div>
                        `;
                    }
                    
                    skuDiv.innerHTML = `
                        <div class="sku-variant-name">${sku.values || 'Default'}</div>
                        ${priceHtml}
                    `;
                    
                    skuDiv.addEventListener('click', function() {
                        selectSku(sku);
                    });
                    
                    skuContainer.appendChild(skuDiv);
                });
                
                document.getElementById('skuPopup').classList.add('active');
                document.getElementById('addToCartBtn').disabled = true;
            }
            
            function selectSku(sku) {
                // Remove previous selection
                document.querySelectorAll('.sku-variant').forEach(variant => {
                    variant.classList.remove('selected');
                });
                
                // Select current SKU
                document.querySelector(`[data-sku-id="${sku.id}"]`).classList.add('selected');
                selectedSku = sku;
                document.getElementById('addToCartBtn').disabled = false;
            }
            
            function closeSkuPopup() {
                document.getElementById('skuPopup').classList.remove('active');
                selectedSku = null;
                currentProductId = null;
            }
            
            async function addSelectedToCart() {
                if (selectedSku && currentProductId) {
                    const id = currentProductId;
                    const price = selectedSku.price;
                    const sku = selectedSku.id;
                    const values = selectedSku.values[0];
                    const stock = selectedSku.stock;

                    if (id) {
                        try {
                            const response = await fetch("/cart/add/" + id, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                        "content"
                                    ),
                                },
                                body: JSON.stringify({
                                    price: price,
                                    sku: sku,
                                    values: values,
                                    stock: stock,
                                }),
                            });

                            const data = await response.json();

                            $("#cartcount").html(data.count);

                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top",
                                showConfirmButton: false,
                                timer: 20000,
                                timerProgressBar: true,
                            });

                            if ($.isEmptyObject(data.error)) {
                                Toast.fire({
                                    icon: "success",
                                    title:
                                        data.success +
                                        "&nbsp; | &nbsp;" +
                                        '<a style="color:#4A2984;" href="/cart">Go to Cart</a> ',
                                });
                                if (sku && values) {
                                    Toast.fire({
                                        icon: "success",
                                        title:
                                            data.success +
                                            " | " +
                                            values +
                                            " Variant | " +
                                            '<a style="color:#4A2984;" href="/cart">Go to Cart</a> ',
                                    });
                                }
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: data.error,
                                });
                            }
                            closeSkuPopup();
                        } catch (error) {
                            console.error("Error adding to cart:", error);
                            Swal.fire({
                                icon: "error",
                                title: "Something went wrong!",
                                text: "Please try again later.",
                            });
                            closeSkuPopup();
                        }
                    } else {
                        alert("Stok Habis / Error");
                    }
                }
            }
            
            function checkSku() {
                var skus = {!! $skus !!};
                $.each($('.addcart'), function(index, item) {
                    const productId = $(item).attr('data-id');
                    const productTitle = $(item).attr('data-title');
                    const productSkus = [];
                    
                    Object.keys(skus).forEach(function(element) {
                        if (skus[element].product_id == productId) {
                            productSkus.push(skus[element]);
                        }
                    });
                    if (productSkus.length > 0) {
                        // Check if this is "Ketemu Peramal" or if there are multiple SKUs
                        if (productTitle === 'Ketemu Peramal' || productSkus.length > 1) {
                            // Multiple SKUs - show popup
                            $(item).off('click').on('click', function(e) {
                                e.preventDefault();
                                openSkuPopup(productId, productTitle, productSkus);
                            });
                        } else {
                            // Single SKU - direct add to cart
                            const sku = productSkus[0];
                            $(item).attr('data-price', sku.price);
                            $(item).attr('data-sku', sku.id);
                            $(item).attr('data-values', sku.values);
                            
                            // Update price display
                            $(item).siblings('.product-item').children('.prices.skus').children(
                                '.product-price').text('idr ' + (
                                sku.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                            
                            if (sku.base_price) {
                                $(item).siblings('.product-item').children('.prices.skus').children(
                                    '.product-price').addClass('discount')
                                $(item).siblings('.product-item').children('.prices.skus').append(
                                    `<span class="striked">idr ${sku.base_price}</span>`);
                                $(item).siblings('.sale').addClass('active');
                            }
                        }
                    } else {
                        // No SKUs available
                        $(item).removeClass('primary');
                        $(item).removeClass('addcart');
                        $(item).removeAttr('data-id');
                        $(item).addClass('disabled');
                        $(item).text('STOK HABIS');
                        $(item).attr('disabled', true);
                        $(item).parent().insertAfter($('.product-item-container').last());
                    }
                });
            }

            $(window).scroll(function() {
                w = Math.floor($(window).scrollTop());
                $('.tab').removeClass('active');
                if (w <= $('#products').offset().top) {
                    $('#productsTab').addClass('active');
                } else if (w <= $('#astrologi').offset().top) {
                    $('#astrologiTab').addClass('active');
                } else if (w <= $('#spiritual').offset().top) {
                    $('#spiritualTab').addClass('active');
                }
            });

            function options() {
                return {
                    dots: false,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    pauseOnHover: false,
                }
            }
            
            $(document).ready(function() {
                if (sessionStorage && !sessionStorage.getItem('popupShow')) {
                    $('#popup').addClass('active');
                    sessionStorage.setItem('popupShow', true);
                }

                $('#closePopup').click(function(e) {
                    e.preventDefault();
                    $('#popup').removeClass('active');
                });

                $('.sliders-index').slick({
                    dots: false,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    pauseOnHover: false,
                });
                $('.service-image').slick(options());
                $('.astrologi-image').slick(options());
                $('.spiritual-image').slick(options());

                checkSku();
            });

            function ReinitSliders(page) {
                if (page == 'products') {
                    $('.service-image').slick('unslick');
                    $('.service-image').slick(options());
                } else if (page == 'astrologi') {
                    $('.astrologi-image').slick('unslick')
                    $('.astrologi-image').slick(options());
                } else if (page == 'spiritual') {
                    $('.spiritual-image').slick('unslick')
                    $('.spiritual-image').slick(options());
                }
            }

            const pagestate = window.location.pathname.slice(1);

            function ActivePage(page) {
                $('.page').removeClass('active');
                $('.tab').removeClass('active');
                $('.' + page).addClass('active');
                $('#' + page).addClass('active');
                ReinitSliders(page);
            }
            
            // Close popup when clicking outside
            document.getElementById('skuPopup').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeSkuPopup();
                }
            });
        </script>
    @endsection
</x-app-layout>