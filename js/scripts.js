$(document).ready(function () {

  //funciones para cambiar donde redirigen los formularios de alta de Usuarios y PLantas cuando se cancela la acción
  //todos los formularios van ahora a gestión, con cancelar y con crear/modificar. Ya no hace falta
  /* $("#cancelarUsuario").click(function () {
    $("[name='formAltaUsuario']").attr('action', 'index.php?p=gu');
    $("[name='formAltaUsuario']").submit();
  });

  $("#cancelarPlanta").click(function () {
    $("[name='formAltaPlanta']").attr('action', 'index.php?p=gp');
    $("[name='formAltaPlanta']").submit();
  }); */

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

})

