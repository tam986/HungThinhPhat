function addToWishlist(productId) {
    var id = productId;
    var name = document.getElementById("wishList_name" + id).value;
    var giakm = document.getElementById("wishList_giakm" + id).value;
    var img = document.getElementById("wishList_img" + id).value;
    var url = document.getElementById("wishList_url" + id).value;
}

document.addEventListener("DOMContentLoaded", function () {
    const wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    if (wishlist.length > 0 && window.isLoggedIn) {
        fetch("/wishlist/sync", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({ wishlist }),
        })
            .then((res) => res.json())
            .then((data) => {
                localStorage.removeItem("wishlist");
                console.log("Đồng bộ wishlist:", data);
            });
    }
});
