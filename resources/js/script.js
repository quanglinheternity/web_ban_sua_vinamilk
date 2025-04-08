document.addEventListener("DOMContentLoaded", function () {
    // Sidebar Toggle
    document.querySelector(".sidebar-toggle").addEventListener("click", function (e) {
        e.preventDefault();
        document.querySelector("body").classList.toggle("sidebar-collapse");
    });

    // Toast Notification
    document.querySelector(".btn-toast").addEventListener("click", function () {
        showToast("Bạn có 3 thông báo mới!");
    });

    // Hiển thị toast
    function showToast(message) {
        let toast = document.createElement("div");
        toast.className = "custom-toast";
        toast.innerHTML = `<i class="bi bi-check-circle"></i> ${message}`;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add("fade-out");
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
});
window.addEventListener("load", function () {
    document.querySelector(".loader-wrapper").classList.add("hidden");
});


