function showSelection() {
    let form = document.getElementById('formSelect');
    form.classList.toggle("visible");
}

function yesnoCheck(that) {
    if (that.value !== "none") {
        document.getElementById("filterItem").style.display = "block";
        document.getElementById("searchFilter").style.display = "block";
    }
}

$("#selectFilter").change(function(){
    $("#selectedFilter").attr("placeholder", "Inserer " + $(this).find(":selected").attr('libelle'));
})

function keepSelect() {
    let formSelect = document.getElementById('formSelect');
    formSelect.style.display = "block";
}