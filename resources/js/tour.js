
// import Shepherd from 'shepherd.js';
$(document).ready(function(){
    // debugger;
    if(!localStorage.getItem("firstTime")){
        //code executed first time
        const tour = new Shepherd.default.Tour({
            defaultStepOptions: {
                classes: 'custom-class-shepherd',
                scrollTo: {
                    behavior: 'smooth',
                    block: 'center'
                },
                cancelIcon: {
                    enabled: true
                },
            },

            useModalOverlay: true
        });

        tour.addStep({
            id: 'welcome',
            text: 'Selamat datang di website <b>Early Theory</b>. Kamu bisa mengikuti tour untuk mengetahui fitur-fitur terbaru dari website Early Theory!',
            buttons: [
                {
                text: 'Next',
                action: tour.next
                }
            ],
            cancelIcon: {
                enabled: false
            },
        });

        tour.addStep({
            id: 'step-1',
            text: 'Kamu bisa klik gambar produk ataupun nama produk untuk mengetahui detail produk tersebut',
            attachTo: {
                element: '.product-item-container',
                on: 'bottom'
            },
            buttons: [
                {
                    action() {
                      return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Back'
                },
                {
                text: 'Next',
                action: tour.next
                }
            ],
        });

        tour.addStep({
            id: 'step-2',
            text: 'Kamu juga bisa langsung memesan produk tersebut dengan mengklik <b>Add to Cart</b>',
            attachTo: {
                element: '.addcart',
                on: 'bottom'
            },
            buttons: [
                {
                    action() {
                      return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Back'
                },
                {
                    text: 'Next',
                    action: tour.next
                }
            ]
        });

        tour.addStep({
            id: 'step-3',
            text: 'Selanjutnya produk tersebut akan masuk kedalam cart yang kamu bisa akses dengan mengklik icon cart ini!',
            attachTo: {
                element: '.cart-icon-a',
                on: 'bottom'
            },
            buttons: [
                {
                    action() {
                      return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Back'
                },
                {
                    text: 'Next',
                    action: tour.next
                }
            ]
        });

        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

           }else
           {
            tour.addStep({
                id: 'step-4',
                text: 'Ketahui update astrologi dan tarot disini!',
                attachTo: {
                    element: '.article-link',
                    on: 'bottom'
                },
                buttons: [
                    {
                        action() {
                          return this.back();
                        },
                        classes: 'shepherd-button-secondary',
                        text: 'Back'
                    },
                    {
                        text: 'Next',
                        action: tour.next
                    }
                ]
            });
           }



        tour.addStep({
            id: 'end',
            text: 'Terima kasih sudah mengikuti tour sampai akhir. Semoga pengalamanmu di website Early Theory menyenangkan!',
            buttons: [
                {
                    action() {
                        return this.complete();
                      },
                    text: 'Close'
                }
            ],
            cancelIcon: {
                enabled: false
            },
        });

        tour.start();

        localStorage.setItem("firstTime","true");
    }

})
