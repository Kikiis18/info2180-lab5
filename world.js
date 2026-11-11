window.onload = function () {
    let button = document.getElementById("lookup");

    button.addEventListener("click", function () {

        let country = document.getElementById("country").value;

        fetch(`world.php?country=${encodeURIComponent(country)}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById("result").innerHTML = data;
            })
            .catch(error => {
                console.log(error);
            });
    });
};