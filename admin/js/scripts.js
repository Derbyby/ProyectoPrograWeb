const sexoAdmin = sexo;

const imgPerfil = document.getElementById("imgPerfil");

if (sexoAdmin === "0") {
    imgPerfil.src = "img/hombre.svg";
} else if (sexoAdmin === "1") {
    imgPerfil.src = "img/mujer.svg";
} else {
    imgPerfil.src = "img/default.svg";
}