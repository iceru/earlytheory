<div class="footer no-print">
    <div class="to-top col-12" id="to_top">
        <div class="container">
            <h5 class="text-end m-0">BACK TO TOP</h5>
        </div>
    </div>
    <div class="container">
        <div class="footer-info row">
            <div class="link col-6">
                {{-- <div>
                        <a href="">Privacy Policy</a>
                    </div>
                    <div>
                        <a href="">Terms and Conditions</a>
                    </div> --}}
            </div>
            <div class="social col-6 d-flex justify-content-end">
                <a href="https://www.instagram.com/early.theory">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@early.theory?">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="https://www.youtube.com/channel/UCSmWL0opWxqbtO2qaQ1FUsg">
                    <i class="fab fa-youtube" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="footer-subs-logo row align-items-center">
            <div class="footer-subs col-12 col-lg-6 order-lg-2">
                <p class="text-uppercase text-subs primary-color pb-2">Subscribe untuk promo terbaru!</p>
                <form action="/newsletter" id="newsletter">
                    @csrf
                    <div class="form-group d-flex">
                        <input type="text" class="form-control me-2" name="email" id="email" placeholder="Email">
                        <button class="button primary m-0">Subscribe</button>
                    </div>
                </form>
            </div>

            <div class="footer-logo col-12 col-lg-6 order-lg-1">
                <img src="/images/MainLogo.png" alt="">
            </div>
        </div>

        <div class="footer-copyright col-12 mb-3">
            <p class="text-center">Copyrights Reserved. Early Theory 2021</p>
        </div>
    </div>
</div>


