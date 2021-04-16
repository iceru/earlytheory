<x-app-layout>
    <div class="col-12 articles">
        <div class="row">
            <div class="col-12">
                <div class="sliders">
                    <div class="slider-item">
                        <img src="/images/Sliders1.png" alt="">
                    </div>
                    <div class="slider-item">
                        <img src="/images/Sliders1.png" alt="">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 article">
                <div class="row article-info">
                    <div class="col-5 article-image">
                        <img src="/images/SWOT.png" alt="">
                    </div>
                    <div class="col-7">
                        <div class="tags">
                            <p>#TAG1</p>
                            <p>#TAG2</p>
                        </div>
                        <div class="title">
                            <h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h5>
                        </div>
                        <div class="information">
                            <p>23 March 2021 </p>
                            <div class="circle"></div>
                            <p>5 min read</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 article">
                <div class="row article-info">
                    <div class="col-5 article-image">
                        <img src="/images/SWOT.png" alt="">
                    </div>
                    <div class="col-7">
                        <div class="tags">
                            <p>#TAG1</p>
                            <p>#TAG2</p>
                        </div>
                        <div class="title">
                            <h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h5>
                        </div>
                        <div class="information">
                            <p>23 March 2021 </p>
                            <div class="circle"></div>
                            <p>5 min read</p>
                        </div>
                    </div>
                </div>
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


