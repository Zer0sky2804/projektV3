// Ovládání modalu
var modal = document.getElementById("myModal");
var btn = document.getElementById("modalBtn");
var span = document.getElementsByClassName("closed")[0];

btn.onclick = function () {
    modal.style.display = "block";
};

span.onclick = function () {
    modal.style.display = "none";
};

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

// Funkce pro načtení externí stránky
function loadPage(page) {
    const contentDisplay = document.getElementById("content-display");

    // Fetch API pro načtení obsahu stránky
    fetch(page)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP chyba! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            // Vložení načteného HTML do sekce content-display
            contentDisplay.innerHTML = html;
        })
        .catch(error => {
            contentDisplay.innerHTML = `<p style="color: red;">Chyba při načítání stránky: ${error.message}</p>`;
        });
}

// Obsah pro ostatní tlačítka
function showContent(contentId) {
    const contentDisplay = document.getElementById("content-display");

    if (contentId === "content2") {
        contentDisplay.innerHTML = "<p>Obsah pro tlačítko 2</p>";
    } else if (contentId === "content3") {
        contentDisplay.innerHTML = "<p>Obsah pro tlačítko 3</p>";
    }
}