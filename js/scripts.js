$(document).ready(function () {

  //funciones para cambiar donde redirigen los formularios de alta de Usuarios y PLantas cuando se cancela la acción
  //todos los formularios van ahora a gestión, con cancelar y con crear/modificar. Haría falta redirigir para skippear los campos requeridos, pero se opta por botón con enlace y ya no hace falta
  /*  $("#cancelarUsuario").click(function () {
    $("[name='formAltaUsuario']").attr('action', 'index.php?p=gu');
    $("[name='formAltaUsuario']").submit();
  });

  $("#cancelarPlanta").click(function () {
    $("[name='formAltaPlanta']").attr('action', 'index.php?p=gp');
    $("[name='formAltaPlanta']").submit();
  });  */

  /**
   * ######################################################################
   * ######################################################################
   * ############### Funciones para crear las galerías ####################
   * ######################################################################
   * ###################################################################### 
   */

  //galería en el Home
  var galeriaPrincipal = new Swiper('#galeria-principal', {
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
  var swiper = new Swiper('#galeria-usuario', {
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    spaceBetween: 20,
    pagination: {
      el: '.swiper-pagination',
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    autoplay: {
      delay: 2000,
      disableOnInteraction: false,
    },
    loop: true
  });
  $("#galeria-usuario").hover(function () {
    (this).swiper.autoplay.stop();
  }, function () {
    (this).swiper.autoplay.start();
  });
  /**
   * ######################################################################
   * ######################################################################
   * ################### Funciones con conexiones AJAX ####################
   * ######################################################################
   * ###################################################################### 
   */
  //borrado de fotos - AJAX
  $('.botonBorrarFoto').click(function (e) {

    e.preventDefault();

    var tipo = $(this).attr('data-tipo'); //cojo el tipo de foto (galeria de usuarios o si es de ficha de planta, si es general, hoja, etc) a borrar con el atributo data-tipo del enlace o submit

    //si es una foto de la ficha de planta cojo sus atributos, si es de las galerías de usuarios recojo las id en un array y dejo la ruta vacía
    if (tipo != "galeria") {
      var id = $(this).attr('data-id'); //cojo la id de la foto/planta a borrar con el atributo data-id que tiene en enlace. Si es tipo ficha será a id de la planta, y si es galería será el id de la propia foto
      var ruta = $(this).attr('data-ruta');  //cojo la ruta de la foto a borrar con el atributo data-ruta que tiene en enlace
    } else {
      var ids = [];
      $("input[type=checkbox]:checked").each(function () {
        ids.push(this.value);
      });
      var id = ids.toString();
      var ruta = "";
    }

    var img = $(this).siblings('img');
    var enlace = $(this);
    var parametros = {
      "id": id,
      "ruta": ruta,
      "tipo": tipo,
      "borrFoto": true
    };

    bootbox.dialog({
      message: "Vas a borrar la foto ¿Estás seguro?",
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
              url: './lib/functions.php',
              method: 'post',
              dataType: 'html',
              data: parametros
            })
              .done(function (data) {
                //este bloque nuevo
                if (tipo != "galeria") {
                  img.fadeOut('slow'); // No recargo la página con lo no recarga el php que muestra las filas, y necesito "eliminar" ese registro de la vista sin recargar
                  enlace.fadeOut('slow');
                  $('#mensajes-y-errores').html('<div class="row"><div class="alert alert-warning">' + data + '</div></div>');
                } else {
                  //$("input[type=checkbox]:checked").each(function () {
                  //  $(this).parents(".card").fadeOut();
                  // });
                  //$("#formBorradoGalerias").submit()
                  $('#mensajes-y-errores').html('<div class="row"><div class="alert alert-warning">' + data + '</div></div>');
                  setTimeout(function () { location.reload(); }, 2500); //aquí sí recargo por la disposición de las imágenes en la página. De usar el mismo método que en las imágenes de la ficha quedarían huecos 
                }
              })
              .fail(function () {
                bootbox.alert('Algo ha ido mal. No se ha podido completar la acción.');
              })
          }
        }
      }
    });
  }); //fin de la función de borrado de fotos

  //borrado de registros - AJAX
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
              url: './lib/functions.php',  
              method: 'post',
              dataType: 'html',
              data: parametros
            })
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
  }); //fin función de borrado de registros

  //Ordenación de la colección de plantas - AJAX
  $('.ordenar').each(function () {
    $(this).click(function () {
      var col = $(this).attr('data-col');
      var order = "desc";
      if ($(this).children("i").hasClass('fa-sort-up')) {
        var order = "asc";
      }
      var parent = $(this).parents("thead");
      console.log(datos);  //ok

      //cuando se clica uno de estos botones se cambia el icono de la flecha. Lo hago después de coger la variable para la ordenación que voy a mandar por AJAX
      $(this).children("i").toggleClass('fa-sort-up');
      $(this).children("i").toggleClass('fa-sort-down');

      $.ajax({
        url: './lib/functions.php',
        method: 'post',
        dataType: 'html',
        data: {
          'datos': datos,
          "ordenar": true,
          "col": col,
          "order": order
        }
      })
        .done(function (data) {
          console.log("DATA" + data)
          data2 = JSON.parse(data);
          let text = "<tbody>";

          for (let i = 0; i < data2.length; i++) {
            let id = data2[i]["id_planta"];
            let nCient = data2[i]["nombre_cientifico"];
            let nCas = data2[i]["nombre_castellano"];
            let nVal = data2[i]["nombre_valenciano"];
            let familia = data2[i]["familia"];
            let imagen = data2[i]["foto_general"];
            if (imagen == "") {
              imagen = "img/plantas/planta_default.jpg";
            }

            text += "<tr><td><a class='text-decoration-none text-white font-weight-bold' href='index.php?p=fp&f=" + id + "'>" + nCient + "</a></td>";
            text += "<td>" + nCas + "</td>";
            text += "<td>" + nVal + "</td>";
            text += "<td>" + familia + "</td>";
            text += "<td><a class='text-decoration-none text-white font-weight-bold' href='index.php?p=fp&f=" + id + "'><img width='75px' src='" + imagen + "'></td></tr>";
          }
          text += "</tbody>";
          parent.siblings().fadeOut();
          parent.next().after(text);
        })
        .fail(function () {
          alert('Algo ha ido mal. No se ha podido completar la acción.');
        })
    });//fin funcion .click
  }); //fin ordenar


  /**
 * ######################################################################
 * ######################################################################
 * ################### Validación de formularios  #######################
 * ######################################################################
 * ###################################################################### 
 */

  //$("#formAltaUsuario").submit(function () { }).validate({
  //$("#formAltaUsuario").validate({

  $("form").each(function () {  //uso una función para validar todos los formularios, ya que los de alta y modificación van a compartir nombre de los input, y reglas
    $(this).submit(function () { }).validate({
      errorClass: "text-danger small border-danger",  //los mensajes de error aparecen en un span con class="error". Le añado clases de Bootstrap para modificar su estilo
      rules: {
        nombre_usuario: {  //se usa el "name" del input para definir las reglas y los mensajes asociados a esas reglas.
          //required: true,  //si la regla está en el HTML no hace falta ponerla
          existe: true,  //no haría falta en este caso, ya que por la regla minLetras no se va a validar si solo se añaden espacios en blanco, pero prefiero que me indique que no hay nombre si solo se añaden espacios en blanco y que reserve el mensaje de que hacen falta 3 caracteres para cuando hay al menos uno introducido
          esTexto: true,
          minlength: 3,
          minLetras: 3
        },
        email_usuario: {
          esEmail: true //no hace falta la regla "existe" porque el required de un email no se puede saltar ocn espacios en blanco
        },
        pass_usuario: {
          checkMinus: true, //no hace falta la regla "existe" porque con las reglas para comprobar minúsculas, mayúsculas y dígito no se puede rellenar el campo con espacios en blanco
          checkMayus: true,
          checkDigit: true
        },
        nombre_cientifico: {
          //required: true,  //si la regla está en el HTML no hace falta ponerla
          existe: true,  //no haría falta en este caso, ya que por la regla minLetras no se va a validar si solo se añaden espacios en blanco, pero prefiero que me indique que no hay nombre si solo se añaden espacios en blanco y que reserve el mensaje de que hacen falta 3 caracteres para cuando hay al menos uno introducido
          esTexto: true,
          minlength: 3,
          minLetras: 3
        }
      },
      messages: {
        nombre_usuario: {
          required: "Introduce nombre",
          existe: "Introduce nombre",
          //minlength: "El nombre debe tener al menos {0} caracteres"
        },
        email_usuario: {
          required: "Introduce email",
          email: "El formato del email no es correcto." //mensaje para sobreescribir el mensaje de error a validación por type=email.
        },
        pass_usuario: {
          required: "Introduce contraseña"
        },
        nombre_cientifico: {
          required: "Introduce nombre científico"
        }
      }

    });
  });


  //reglas para el validador
  //el método existe es necesario para los campos tipo texto, porque el "required" de esos campos se puede saltar con espacios en blanco
  $.validator.addMethod("existe",
    function (value, element) {
      return value.trim().length > 0;
    }  //no pongo mensaje personalizado en esta regla porque va a depender del input
  );
  $.validator.addMethod("minLetras",
    function (value, element) {
      return value.trim().length > 2;
    }, "El nombre debe tener al menos {0} letras"  //añado el mensaje a la regla y no hace falta especificarlo en la función validate(
  );
  $.validator.addMethod("esTexto",
    function (value, element) {
      return /^[A-Za-z \s]+$/.test(value);
    },
    "Solo admite letras"
  );
  $.validator.addMethod("esNombre",
    function (value, element) {
      return /^[A-Za-z \s]+$/.test(value);
    },
    "Ese caracter no está permitido"
  );
  $.validator.addMethod("esEmail",
    function (value, element) {
      return /^\w+([\+\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(value);
    },
    "El formato del email no es correcto."
  );
  $.validator.addMethod("checkMinus", function (value) {
    return /[a-z]/.test(value);
  },
    "La contraseña debe tener una letra minúscula"
  );
  $.validator.addMethod("checkMayus", function (value) {
    return /[A-Z]/.test(value);
  },
    "La contraseña debe tener una letra mayúscula"
  );
  $.validator.addMethod("checkDigit", function (value) {
    return /[0-9]/.test(value);
  },
    "La contraseña debe tener un dígito"
  );

  $.validator.addClassRules({  //método para añadir un grupo de reglas a un grupo de elementos, que tienen una determinada clase
    esCampoTexto: {
      esTexto: true,
      existe: true
    }
  });


  /**
 * ######################################################################
 * ######################################################################
 * ########################## Otras Funciones ###########################
 * ######################################################################
 * ###################################################################### 
 */
  //función para desplegar el  formulario de registro en la página de las ficha de planta desde el enlace de registro
  $('#abrir').click(function (e) {
    e.stopPropagation();
    if ($('#desplegableRegistro').find('.dropdown-menu').is(":hidden")) {
      $('#desplegableRegistro').find('.dropdown-toggle').dropdown('toggle');
    }
  });


})//fin $(document).ready(function ()