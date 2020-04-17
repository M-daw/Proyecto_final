$(document).ready(function () {

  //funciones para cambiar donde redirigen los formularios de alta de Usuarios y PLantas cuando se cancela la acción
  //todos los formularios van ahora a gestión, con cancelar y con crear/modificar. hace falta por los campos requeridps. NOOOO, que cancelar es un enlace
  /*  $("#cancelarUsuario").click(function () {
    $("[name='formAltaUsuario']").attr('action', 'index.php?p=gu');
    $("[name='formAltaUsuario']").submit();
  });

  $("#cancelarPlanta").click(function () {
    $("[name='formAltaPlanta']").attr('action', 'index.php?p=gp');
    $("[name='formAltaPlanta']").submit();
  });  */

  //galería en el Home
  var swiper = new Swiper('#galeria-principal', {
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: true,
    },
    pagination: {
      el: '.swiper-pagination',
    },
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    loop: true
  });


  //galería en la ficha de planta: fotos descriptivas
  var galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 10,
    slidesPerView: 4,
    loop: true,
    freeMode: true,
    loopedSlides: 4, //looped slides should be the same
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });
  var galleryTop = new Swiper('.gallery-top', {
    spaceBetween: 10,
    loop: true,
    loopedSlides: 4, //looped slides should be the same
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    thumbs: {
      swiper: galleryThumbs,
    },
  });


  //galería en la ficha de planta: fotos de usuarios


  //conexión AJAX
  /* 
  La confirmación del borrado de registros (plantas o usuarios) la quiero hacer con una ventana modal.
  Con PHP no puedo pasar parámetros dentro de un formulario en una ventana modal y tengo que
  usar JS. Necesito usar una conexión AJAX
  */
  $('.botonBorrar').click(function (e) {

    e.preventDefault();

    var id = $(this).attr('data-id');  //cojo la id del registro a borrar con el atributo data-id que tiene en enlace
    var tipo = $(this).attr('data-tipo'); //cojo el tipo de registro a borrar con el atributo data-tipo del enlace
    var parent = $(this).parent("td").parent("tr");
    var parametros = {
      "id": id,
      "tipo": tipo,
      "borrSI": true
    };

    bootbox.dialog({
      message: "Vas a eliminar el registro " + id + " ¿Estás seguro?",
      title: "<i class='fas fa-trash-alt'></i> ¡Atención!",
      buttons: {
        cancel: {
          label: "No",
          className: "btn-success",
          callback: function () {
            $('.bootbox').modal('hide');
          }
        },
        confirm: {
          label: "Eliminar",
          className: "btn-danger",
          callback: function () {

            $.ajax({
              //url: 'index.php?p=gu&b',
              url: 'borrar.php',
              method: 'post',
              dataType: 'html',
              data: parametros
            })
              //Si todo ha ido bien...
              .done(function (data) {
                parent.fadeOut('slow'); // No recargo la página con lo no recarga el php que muestra las filas, y necesito "eliminar" ese registro de la vista sin recargar
                $('#mensajes-y-errores').html('<div class="row"><div class="alert alert-warning">' + data + '</div></div>');
              })
              .fail(function () {
                bootbox.alert('Algo ha ido mal. No se ha podido completar la acción.');
              })
          }
        }
      }
    });
  });

  //validación formulario
  /* $("#formAltaUsuario").submit(function () {
    var expRegTexto = /^[A-Za-z \s]+$/; 
    var expRegMail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    var nombre;
    var mail, pass;
    
    var OKnombre = false;

    nombre = $("#nombre_usuario").val();
    mail = $("[name='email_usuario']").val();
    $("#nombre_usuario + .text-danger").remove();  //quito los posibles mensajes de error
    if (!nombre || nombre.length === 0 || nombre.trim() === "") { //si el campo no contiene nada se indica que está vacío bajo el input
      $("#nombre_usuario").after("<div class='text-danger'>*Introduce nombre </div>");
    } else if (expRegTexto.test(nombre)) { //si contiene algo se evalua con la expresión regular para el nombre
      OKnombre = true;   //si es válido se setea a TRUE su variable booleana
    } else {
      $("#nombre_usuario").after("<div class='text-danger'>*Nombre no válido</div>");//si no es válido se indica bajo el input
    }

    if (OKnombre) {
      alert("que si")
    } else {
      alert("que no")
      event.preventDefault(); //si falla la validación impido que se envíe el formulario
    }

  });  */  //funciona, voy a probar con librería validate

  $("#formAltaUsuario").submit(function () { }).validate({
    errorClass: "text-danger small",
    rules: {
      nombre_usuario: {
        //required: true,
        minlength: 4,
        //maxlength: 20
      }
    },
    messages: {
      nombre_usuario: {
        required: "Introduce nombre",
        minlength:"El nombre debe tener al menos {0} caracteres",
        maxlength:"{0} caracteres son demasiados!"
      }
    }
  });


})//fin $(document).ready(function ()