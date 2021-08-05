//HEADER

addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.toggle')
    const navBar__link = document.querySelector('.navBar__link')
    const toggle__span = document.querySelectorAll('.toggle span');
    if (toggle) {
        toggle.addEventListener('click', () => {
            navBar__link.classList.toggle('active')
            toggle__span.forEach(child => {child.classList.toggle('animated')});
            toggle.classList.toggle('rotate');
        })
    }
    if (navBar__link) {
        navBar__link.addEventListener('click', () => {
            navBar__link.classList.toggle('active')
            toggle__span.forEach(child => {child.classList.toggle('animated')});
            toggle.classList.toggle('rotate');
        })
    }

});

//ACCORDION

var acc = document.getElementsByClassName("hp-accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}


//FORM
$("#formContact").submit(function(event){
    event.preventDefault(); //almacena los datos sin refrescar el sitio web.

    var formData = new FormData(document.getElementById("formContact"));
    formData.append("dato", "valor");

    sendForm(formData);
});

function sendForm(formData){
    
    $.ajax({
            url: "./form/form.php",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(text){
                if(text == "success"){
                    correct(),
                    window.location = "https://soporteapplemac.cl";
                }else{
                    phperror(text);
                }
            }
    })
}
//FUNCTION SEND
function correct(){
    $("#successMessage").removeClass("hp-d-none");
    $("#messageError").addClass("hp-d-none");
}

//FUNCTION ERROR
function phperror(text){
    $("#messageError").removeClass("hp-d-none");
    $("#messageError").html(text);
}