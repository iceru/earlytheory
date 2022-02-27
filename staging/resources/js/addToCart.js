
    $('.addcart').on('click', function(){
        var id = $(this).data('id');
        if(id) {
            $.ajax({
            url:"/cart/add/"+id,
            type:"GET",
            dataType:"json",
            success:function(data) {
                $('#cartcount').html(data.count);
                // console.log(data.count);

                const Toast = Swal.mixin({
                    toast:true,
                    position: 'top',
                    showConfirmButton:false,
                    timer: 4000,
                    timerProgressBar: true,
                })

                if($.isEmptyObject(data.error)){
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
        alert('Error');
        }
    });
