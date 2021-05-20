<x-app-layout>
    @section('title')
        Contact Us
    @endsection
    <div class="col-12 contact-us main-content">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="evogria">Contact Us</h2>
            </div>
            {{-- <div class="col-12 col-md-6 contact-form">
                <form action="">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Your Message</label>
                        <textarea type="text" rows="6" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="button primary">Submit</button>
                </form>
            </div> --}}
            <div class="col-12 contact-info">
                <h3 class="mb-2 evogria" style="color: white">Contact Information</h3>
                <p class="mb-5">You can contact us through here</p>

                <p class="mb-5"><i class="fa fa-envelope" aria-hidden="true"></i> &nbsp; earlytheorytarot@gmail.com</p>
                {{-- <p class="mb-5"><i class="fa fa-phone-alt" aria-hidden="true"></i> &nbsp; 081112224444</p> --}}

                <p class="mb-2">Our Social Media</p>
                <div class="contact-social d-flex">
                    <div class="me-3">
                        <a href="https://www.instagram.com/early.theory" class="white-color"><i class="fab fa-instagram"></i></a>
                    </div>
                    <div class="me-3 white-color">
                        <a href="https://www.tiktok.com/@early.theory?" class="white-color"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="wave-contact">
                    <svg height="100%" width="100%" id="svg" viewBox="0 0 1440 400" xmlns="http://www.w3.org/2000/svg" class="transition duration-300 ease-in-out delay-150"><defs><linearGradient id="gradient"><stop offset="5%" stop-color="#f78da788"></stop><stop offset="95%" stop-color="#abb8c388"></stop></linearGradient></defs><path d="M 0,400 C 0,400 0,133 0,133 C 130.26666666666665,109.39999999999999 260.5333333333333,85.79999999999998 403,100 C 545.4666666666667,114.20000000000002 700.1333333333334,166.20000000000002 875,178 C 1049.8666666666666,189.79999999999998 1244.9333333333334,161.39999999999998 1440,133 C 1440,133 1440,400 1440,400 Z" stroke="none" stroke-width="0" fill="url(#gradient)" class="transition-all duration-300 ease-in-out delay-150"></path><defs><linearGradient id="gradient"><stop offset="5%" stop-color="#f78da7ff"></stop><stop offset="95%" stop-color="#abb8c3ff"></stop></linearGradient></defs><path d="M 0,400 C 0,400 0,266 0,266 C 190.8,254.13333333333335 381.6,242.2666666666667 533,255 C 684.4,267.7333333333333 796.4000000000001,305.06666666666666 941,311 C 1085.6,316.93333333333334 1262.8,291.4666666666667 1440,266 C 1440,266 1440,400 1440,400 Z" stroke="none" stroke-width="0" fill="url(#gradient)" class="transition-all duration-300 ease-in-out delay-150"></path></svg>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
