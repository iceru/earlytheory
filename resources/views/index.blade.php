<x-app-layout>
    @section('title')
        Early Theory - Homepage
    @endsection
    <div class="popupPage" id="popup">
        <a href="https://shopee.co.id/tokomejik?smtt=0.775443230-1656594335.9" class="popup-img">
            <div class="close" id="closePopup"> <i class="fas fa-times" aria-hidden="true"></i></div>
            <div class="ratio">
                <img src="/images/banner-shopee.png" alt="">
            </div>
        </a>
    </div>
    <div class="container">
        <main class="index">
            <a href="/tarot">
                <section class="index-section top-section">
                    <div class="bg">
                        <img src="/images/BackgroundRamalan.png" alt="">
                    </div>
                    <h3 class="text-2xl">
                        Order <br />
                        Ramalan
                    </h3>
                </section>
            </a>

            <a href="https://shopee.co.id/tokomejik?smtt=0.775443230-1656594335.9" target="_blank">
                <section class="index-section top-section">
                    <div class="bg">
                        <img src="/images/BackgroundTokoMejik.png" alt="">
                    </div>
                    <h3 class="text-2xl">
                        Toko <br />
                        Mejik
                    </h3>
                </section>
            </a>
            <a href="{{ route('workshops') }}">
                <section class="index-section top-section">
                    <div class="bg">
                        <img src="/images/BackgroundKelasMejik.png" alt="">
                    </div>
                    <h3 class="text-2xl">
                        Kelas <br />
                        Mejik
                    </h3>
                </section>
            </a>
            <a target="_blank" href="https://www.tiktok.com/@early.theory?">
                <section class="index-section">
                    <div>
                        <img height="40px" src="/images/LogoTikTok.PNG" alt="">
                    </div>
                    <h3 class="text-2xl">
                        Tiktok
                    </h3>
                </section>
            </a>
            <a href="/articles-page">
                <section class="index-section index-article">
                    <div class="bg">
                        <img src="/images/BackgroundArticle.png" alt="">
                    </div>
                    <h3 class="text-2xl">
                        Artikel
                    </h3>
                </section>
            </a>
            <a target="_blank" href="https://www.youtube.com/channel/UCSmWL0opWxqbtO2qaQ1FUsg">
                <section class="index-section">
                    <div>
                        <img height="40px" src="/images/LogoUtub.PNG" alt="">
                    </div>
                    <h3 class="text-2xl">
                        Youtube
                    </h3>
                </section>
            </a>
        </main>
        <main class="index mobile">
            <section class="section-side">
                <a href="/tarot">
                    <section class="index-section">
                        <div class="bg">
                            <img src="/images/BackgroundRamalan.png" alt="">
                        </div>
                        <h3 class="text-2xl">
                            Order <br />
                            Ramalan
                        </h3>
                    </section>
                </a>

                <a href="https://shopee.co.id/tokomejik?smtt=0.775443230-1656594335.9" target="_blank">
                    <section class="index-section">
                        <div class="bg">
                            <img src="/images/BackgroundTokoMejik.png" alt="">
                        </div>
                        <h3 class="text-2xl">
                            Toko <br />
                            Mejik
                        </h3>
                    </section>
                </a>
            </section>
            <section class="section-side">
                <a href="/articles-page" class="index-small">
                    <section class="index-section index-article">
                        <div class="bg">
                            <img src="/images/BackgroundArticle.png" alt="">
                        </div>
                        <h3 class="text-2xl">
                            Artikel
                        </h3>
                    </section>
                </a>
                <a href="{{ route('workshops') }}" class="index-kelas">
                    <section class="index-section">
                        <div class="bg">
                            <img src="/images/BackgroundKelasMejik.png" alt="">
                        </div>
                        <h3 class="text-2xl">
                            Kelas <br />
                            Mejik
                        </h3>
                    </section>
                </a>
                <a target="_blank" href="https://www.tiktok.com/@early.theory?" class="index-v-small">
                    <section class="index-section index-social">
                        <h3 class="text-2xl">
                            Tiktok
                        </h3>
                        <div>
                            <img width="40px" src="/images/LogoTikTok.PNG" alt="">
                        </div>
                    </section>
                </a>
                <a target="_blank" href="https://www.youtube.com/channel/UCSmWL0opWxqbtO2qaQ1FUsg"
                    class="index-v-small">
                    <section class="index-section index-social">
                        <div>
                            <img width="40px" src="/images/LogoUtub.PNG" alt="">
                        </div>
                        <h3 class="text-2xl">
                            Youtube
                        </h3>
                    </section>
                </a>
            </section>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            if (sessionStorage && !sessionStorage.getItem('popupShow')) {
                $('#popup').addClass('active');
                sessionStorage.setItem('popupShow', true);
            }

            $('#closePopup').click(function(e) {
                e.preventDefault();
                $('#popup').removeClass('active');
            });
        })
    </script>
</x-app-layout>
