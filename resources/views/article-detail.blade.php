<x-app-layout>
    <div class="col-12 g-0 pb-4 article-detail">
        <div class="article-image" style="background-image: url('/images/SWOT.png')">
            <div class="share">
                <i class="fas fa-share    "></i>
            </div>
            <div class="back">
                <i class="fas fa-chevron-left    "></i>
            </div>
            <div class="title">
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>
            </div>
        </div>
        <div class="article-body">
            <div class="writer-info">
                <div class="writer-image">
                    <img src="/images/Favicon.png" alt="">
                </div>
                <div class="writer-name">
                    <p>Early Theory</p>
                    <div class="information">
                        <p>23 March 2021</p>
                        <div class="circle"></div>
                        <p>5 Min Read</p>
                    </div>
                </div>
            </div>
            <div class="article-text">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sit rhoncus auctor gravida suscipit. Eleifend
                euismod nisl eget tortor dolor. Habitant tellus eget purus mollis mi etiam ut. Malesuada nibh non
                imperdiet tempor. Nascetur tortor mauris in pellentesque aliquet et. Mollis maecenas egestas convallis
                amet.
                <br> <br>
                Egestas posuere tellus adipiscing in orci, enim. Volutpat sit arcu, ac porta etiam neque, faucibus. Orci
                pharetra ut accumsan volutpat eget massa mollis mi pharetra. Mattis vulputate eget maecenas molestie
                iaculis adipiscing aenean turpis sagittis. Et sed morbi viverra fames justo duis. Semper faucibus dictum
                aliquam sit molestie vitae donec volutpat. Sapien condimentum enim elit in ipsum suspendisse aliquam.
                Non nec ipsum quam accumsan nisl vel adipiscing sed ultrices. Tellus vel maecenas faucibus proin.
            </div>

            <div class="sliders mt-4">
                <div class="slider-item">
                    <img src="/images/Sliders1.png" alt="">
                </div>
                <div class="slider-item">
                    <img src="/images/Sliders1.png" alt="">
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
