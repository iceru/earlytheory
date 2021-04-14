<x-app-layout>
    <div class="index col-12">
        <div class="sliders">
            <div class="slider-item">
                <img src="/images/Sliders1.png" alt="">
            </div>
            <div class="slider-item">
                <img src="/images/Sliders1.png" alt="">
            </div>
        </div>

        <div class="products row mt-3">
            <div class="product-item-container col-6 col-md-3">
                <div class="product-image">
                    <img src="/images/PROBLEMSOLVER.png" alt="">
                </div>
                <div class="product-item">
                    <div class="product-title">
                        <h3>Problem Solver</h3>
                    </div>
                    <p class="product-price">idr 75,000</p>
                    <p class="product-desc">Menjawab 1 Pertanyaan atas permasalahan hidupmu [Love, work, etc.]</p>
                </div>
                <a href="" class="button primary my-3">Add To Cart</a>
            </div>
            <div class="product-item-container col-6 col-md-3">
                <div class="product-image">
                    <img src="/images/PROBLEMSOLVER.png" alt="">
                </div>
                <div class="product-item">
                    <div class="product-title">
                        <h3>Problem Solver</h3>
                    </div>
                    <p class="product-price">idr 75,000</p>
                    <p class="product-desc">Menjawab 1 Pertanyaan atas permasalahan hidupmu [Love, work, etc.]</p>
                </div>
                <a href="" class="button primary my-3">Add To Cart</a>
            </div>
        </div>
    </div>

    @section('js')
    <script>
        $(document).ready(function(){
            $('.sliders').slick({
                dots: true
            });
        });
    </script>
    @endsection
</x-app-layout>
