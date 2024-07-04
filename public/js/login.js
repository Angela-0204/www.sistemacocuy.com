$("#entrar").click(function (e) {
  var datos = new FormData();
  datos.append("accion", "ingresar");
  datos.append("email", $("#email").val());
  datos.append("password_user", $("#password_user").val());
  funcionAjax(datos);
});

function funcionAjax(datos) {
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: function (response) {
      var res = JSON.parse(response);
      if (res.estatus == 1) {
        //alert(res.message);
        window.location.replace("?pagina=inicio");
        /*setTimeout(function () {
          window.location.replace("?pagina=inicio");
        }, 2000);*/
      } else {
        Swal.fire({
          icon: "error",
          title: "Login de acceso",
          text: "Constraseña erronea!"
        });
      }
    },
    error: function (err) {
      alert(res.error);
    },
  });
}