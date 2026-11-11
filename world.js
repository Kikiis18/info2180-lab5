window.onload = function () {
    const countryInput = document.getElementById("country");
    const result = document.getElementById("result");

    function lookup(lookupType) {
        const params = new URLSearchParams({ country: countryInput.value });
        if (lookupType === "cities") {
            params.set("lookup", "cities");
        }

        fetch(`world.php?${params.toString()}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Request failed with status ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                result.innerHTML = data;
            })
            .catch(error => {
                console.error("Could not retrieve lookup results:", error);
                result.innerHTML = '<p class="empty-state error-state">Unable to load results. Please try again.</p>';
            });
    }

    document.getElementById("lookup").addEventListener("click", function () {
        lookup("countries");
    });

    document.getElementById("lookup-cities").addEventListener("click", function () {
        lookup("cities");
    });
};