// Signup JS
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("signup-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        var formData = new FormData(form);

        fetch("api/signup_submit.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);

                if (data.success) {
                    location.reload(); // user ko login/vl user dikhane ke liye
                }
            })
            .catch(error => {
                alert("Something went wrong!");
            });
    });
});
