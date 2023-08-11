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
            <section class="index-section col">
                <h3 class="text-2xl">
                    Order <br />
                    Ramalan
                </h3>
            </section>
            <section class="index-section col">
                <h3 class="text-2xl">
                    Kelas & <br />
                    Workshop
                </h3>
            </section>
            <section class="index-section col">
                <h3 class="text-2xl">
                    Toko <br />
                    Mejik
                </h3>
            </section>
            <section class="index-section col">
                <h3 class="text-2xl">
                    Artikel
                </h3>
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
