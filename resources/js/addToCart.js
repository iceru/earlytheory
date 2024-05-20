$(".addcart").on("click", async function () {
    var id = $(this).attr("data-id");
    var price = $(this).attr("data-price");
    var sku = $(this).attr("data-sku");
    var values = $(this).attr("data-values");
    var stock = $(this).attr("data-stock");
    var link = $(this).attr("data-link");

    if (id) {
        try {
            const response = await fetch("/cart/add/" + id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify({
                    price: price,
                    sku: sku,
                    values: values,
                    stock: stock,
                    link: link,
                }),
            });

            const data = await response.json();

            $("#cartcount").html(data.count);

            const Toast = Swal.mixin({
                toast: true,
                position: "top",
                showConfirmButton: false,
                timer: 20000,
                timerProgressBar: true,
            });

            console.log(sku);
            console.log(values);

            if ($.isEmptyObject(data.error)) {
                Toast.fire({
                    icon: "success",
                    title:
                        data.success +
                        "&nbsp; | &nbsp;" +
                        '<a style="color:#4A2984;" href="/cart">Go to Cart</a> ',
                });
                if (sku && values) {
                    Toast.fire({
                        icon: "success",
                        title:
                            data.success +
                            " | " +
                            values +
                            " Variant | " +
                            '<a style="color:#4A2984;" href="/cart">Go to Cart</a> ',
                    });
                }
            } else {
                Toast.fire({
                    icon: "error",
                    title: data.error,
                });
            }
        } catch (error) {
            console.error("Error adding to cart:", error);
            Swal.fire({
                icon: "error",
                title: "Something went wrong!",
                text: "Please try again later.",
            });
        }
    } else {
        alert("Stok Habis / Error");
    }
});
