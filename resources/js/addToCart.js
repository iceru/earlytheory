$('.addcart').on('click', function () {
    var id = $(this).attr('data-id');
    var price = $(this).attr('data-price');
    var sku = $(this).attr('data-sku');
    var values = $(this).attr('data-values');
    var stock = $(this).attr('data-stock');
    var link = $(this).attr('data-link');

    if (id) {
        $.ajax({
            url: "/cart/add/" + id,
            type: "POST",
            data: { 'price': price, 'sku': sku, 'values': values, 'stock': stock, 'link': link },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (data) {
                $('#cartcount').html(data.count);
                
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                })

                if ($.isEmptyObject(data.error)) {
                    Toast.fire({
                        icon: 'success',
                        title: data.success + '&nbsp; | &nbsp;' + '<a style="color:#4A2984;" href="/cart">Go to Cart</a> '
                    })
                }
                else {
                    Toast.fire({
                        icon: 'error',
                        title: data.error
                    })
                }
            },
        });
    } else {
        alert('Stok Habis / Error');
    }
});
