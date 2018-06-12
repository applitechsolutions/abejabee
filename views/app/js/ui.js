function openLink(evt, animName) {
    var i, x, tablinks;
    x = _c("city");

    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    tablinks = _c("tablink");
    for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" row", "");
        tablinks[i].className = tablinks[i].className.replace(" page-header", "");
    }
    __(animName).style.display = "block";
}

$(document).ready(function(){
    $("#add-empleado").click(function(){
    $("#form-empleado").slideDown("fast");
    });
});
$(document).ready(function(){
    $("#close-add-empleado").click(function(){
    $("#form-empleado").slideUp("fast");
    document.getElementById('add-empleado').style.display='inline'
    });
    $("#cancel-add-empleado").click(function(){
    $("#form-empleado").slideUp("fast");
    document.getElementById('add-empleado').style.display='inline'
    });
});

$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});