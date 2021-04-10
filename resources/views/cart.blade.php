<x-app-layout>
    <div class="col-12 cart">
        <div class="row">
            <div class="col-12 title-page text-center primary-color">
                <h1>MY CART</h1>
            </div>
            <div class="col-12 col-lg-6 product-cart ">
                <div class="d-flex justify-content-end mb-3">
                    <button class="button primary align-items-center">
                        <span class="me-2 ">Remove All</span> <i class="fas fa-trash"></i>
                    </button>
                </div>

                <div class="products">
                    <div class="product-item-container row m-0">
                        <div class="col-4 product-image">
                            <img src="/images/PROBLEMSOLVER.png" alt="">
                        </div>
                        <div class="col-8 product-item">
                            <h4 class="product-title">Mencari Jodoh</h4>
                            <p class="product-price">idr 150.000</p>
                            <div class="qty-spinner d-flex">
                                <div class="min-button">
                                    <i class="fas fa-minus-circle"></i>
                                </div>
                                <div class="qty">1</div>
                                <div class="plus-button">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-item-container row m-0">
                        <div class="col-4 product-image">
                            <img src="/images/PROBLEMSOLVER.png" alt="">
                        </div>
                        <div class="col-8 product-item">
                            <h4 class="product-title">Mencari Jodoh</h4>
                            <p class="product-price">idr 150.000</p>
                            <div class="qty-spinner d-flex">
                                <div class="min-button">
                                    <i class="fas fa-minus-circle"></i>
                                </div>
                                <div class="qty">1</div>
                                <div class="plus-button">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 cart-summary">
                <div class="total-price">
                    <h5>
                       <span class="text">Total</span> <br>
                       <span class="price">idr 225,000</span>
                    </h5>
                </div>
                <div class="checkout">
                    <a href="#" class="button primary">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
