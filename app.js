function yesnoCheck(that) {
    if (that.value !== "none") {
        var getOptionsSelected = document.getElementById("selectFilter").value;
        console.log(getOptionsSelected);
        document.getElementById("filterItem").style.display = "block";
        document.getElementById("searchFilter").style.display = "block";
    } else {
        document.getElementById("filterItem").style.display = "none";
        document.getElementById("searchFilter").style.display = "none";
    }
}

$("#selectFilter").change(function(){
    $("#selectedFilter").attr("placeholder", "Inserer " + $(this).find(":selected").attr('libelle'));
})

function showSelection() {
    let form = document.getElementById('formSelect');
    form.classList.toggle("visible");
}