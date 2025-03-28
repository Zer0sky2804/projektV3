// Ovládání modalu
var modal = document.getElementById("mModal");
var btn = document.getElementById("ModalBtn");
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