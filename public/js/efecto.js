const swith = document.querySelector(".switch");
const darkLogo = document.querySelector(".dark");
const lightLogo = document.querySelector(".claro");


swith.addEventListener("click", e=>{

    swith.classList.toggle("active");
    document.body.classList.toggle("active");
 
    darkLogo.classList.toggle("active");
    lightLogo.classList.toggle("active");

});
