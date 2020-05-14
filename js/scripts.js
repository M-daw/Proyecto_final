$(document).ready(function () {
  /**
   * ######################################################################
   * ######################################################################
   * ##################  Funciones de las galerías  #######################
   * ######################################################################
   * ###################################################################### 
   *
   * Para crear las diferentes galerías del proyecto se utiliza la libreía Swiper. Cada librería es un objeto de clase 
   * Swiper en el que se definen diversos parámetros para establecer su estructura y comportamiento.
   * Los ejemplos presentan las galerías de Swiper no en etiquetas <img> sino en <div> con las imágenes como background, 
   * pero se ha modificado porque me intereseba más tener elementos imagen por cuestiones de SEO.
   */

  /**
   * Galería en el Home
   * Esta es la galería presente en la página Home, al final. Se construye con una selección aleatoria de 5 fotografías 
   * subidas por los usuarios, y si no hay, con unas fotos guardadas para rellenar la galería. El array de fotos a usar se
   * genera con php, y se itera para obtener los "src" de las imágenes.
   * Tiene una animación con efecto coverflow, y también permite avanzar o retroceder arrastrando el cursor a izquierda o 
   * derecha.
   */
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

  /**
  * Galerías en la ficha de planta: fotos descriptivas
  * Esta es una de las galerías presentes en las páginas de fichas de plantas. Esta dentro de la propia ficha de la planta
  * ya que en esta se presentan las imágenes descriptivas de la planta, que se guardan en la base de datos en la tabla de 
  * plantas junto con el resto de característicasde las mismas. Son en realidad dos galerías conectadas, que constan de 
  * las mismas 4 fotos, una general, otra de las flores, otra de las hojas y otra del fruto. Si alguna de las imágenes no 
  * se guarda en la base de datos, al cargar src de las imágenes se pondrá el enlace a una imagen "default".
  * La galería superior muestra las fotos, y la inferior las miniaturas.
  * Esta galería no tiene animación, el paso de una imagen a otra se hace con los botones de desplazamiento, o pinchando en
  * las miniaturas presentes bajo la imagen mostrada.
  */
  var galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 10,
    slidesPerView: 4,
    loop: true,
    freeMode: true,
    loopedSlides: 4, //tiene que tener las mismas imágenes que las galería superior
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });
  var galleryTop = new Swiper('.gallery-top', {
    spaceBetween: 10,
    loop: true,
    loopedSlides: 4, //tiene que tener las mismas imágenes que las galería de miniaturas
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    thumbs: {
      swiper: galleryThumbs, //en este componente se le indica que las fotos están sincronizadas con las miniaturas
    },
  });

  /*
  Función para poner títulos a la galería de la ficha. 
  Por estructura de este tipo de galerías con miniaturas, las imágenes tienen que ser hijas directos del contendor 
  ".swiper-wrapper" y si se usan elementos img no se pueden poner en un div que las contenga a ellas más elementos de texto 
  para mostrar. Se podía optar por mostrarlas como en los ejemplos de la librería,
  elementos div con la imagen como fondo que serían hijos directos del contendor ".swiper-wrapper", pero como se ha optado por
  usar elementos <img> se ha utilizado esta función que devuelve texto a un contenedor situado sobre la galería, y cambia
  el texto en función de la imagen que hay en la diapositica activa. Se usa la función de jQuery attr() para obtener la id
  de la imagen.
*/
  $('#titulosGaleria').html(function () {
    if ($('.swiper-slide-active').attr('id') == "imagenGeneral") {
      return "Vista general";
    }
    if ($('.swiper-slide-active').attr('id') == "imagenFlor") {
      return "Vista de la Flor";
    }
    if ($('.swiper-slide-active').attr('id') == "imagenHoja") {
      return "Vista de la Hoja";
    }
    if ($('.swiper-slide-active').attr('id') == "imagenFruto") {
      return "Vista del Fruto";
    }
  });

  /*
  Función para para abrir fotos de la galería de la ficha en ventana.
  Excepto las fotos de la galería de la página principal, el resto de imágenes están contenidas en un elemento enlace, para abrir la imagen
  en el navegador. No se han utilizado lightboxes para evitar que la aplicación pesara demasiado.
  Por estructura de este tipo de galerías con miniaturas, las imágenes tienen que ser hijas directos del contendor ".swiper-wrapper" y si se usan elementos img no se pueden poner dentro de un enlace.
  Se utilizan estas funciones para recoger el atributo src de la imagen y usarlo como hrrf de un objeto window.
*/
  $(document).on("click", '#imagenGeneral', function () {
    window.location.href = $('#imagenGeneral').attr("src");
  });
  $(document).on("click", '#imagenFlor', function () {
    window.location.href = $('#imagenFlor').attr("src");
  });
  $(document).on("click", '#imagenHoja', function () {
    window.location.href = $('#imagenHoja').attr("src");
  });
  $(document).on("click", '#imagenFruto', function () {
    window.location.href = $('#imagenFruto').attr("src");
  });

  /**
   * Galería en la ficha de planta: fotos de usuarios
   * Esta es la segunda de las galerías presentes en las páginas de fichas de plantas. Esta galería está al final de la
   * página, y en ella se presentan las imágenes subidas por los usuarios para ilustrar esa especie vegetal.
   * 
   * Se muestran todas las fotos subidas por los usuarios para esa planta, pero si hubiera menos de 5 se rellenaría con imágenes 
   * de relleno hasta 5. También tiene autoplay, y se pueden pasar con botones. 
   *
   */
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
      disableOnInteraction: true,
    },
    loop: true
  });

  //esta función desactiva el autoplay si el ratón está sobre las imágenes de la galería. El disableOnInteraction tiene que estar seteado a "true"
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
  /*
  Esta primera llamada a AJAX es para el borrado de fotos, tanto para las fotos subidas por los usuarios, desde la página borrarimagenes.php, 
  como las de ficha de planta desde la página de gestión de plantas modificarplantas.php.
  Se usan atributos del tipo data- para recoger los parámetros de interés.
  LLama a una ventana modal de confirmación de borrado, y desde la función callback de la aceptación en el modal es desde donde se hace la
  llamada AJAX.
  PHP no me permite pasar datos desde el modal de confirmación a PHP, así que uso una conexión AJAX.
  Si la llamada tiene éxito se necesita ocultar de formaa asíncrona las fotos borradas, ya que después de la llamada AJAX
  se han eliminado en la base de datos y el servidor pero no se puede recargar la página ya que es un formulario en el que el usuario
  puede estar modificando datos que no se han salvado.
  En el caso de las fotos de galería, se recargará la página desde JavaScript para evitar que el layout se muestre con huecos.
  */

  $('.botonBorrarFoto').click(function (e) {

    e.preventDefault();

    var tipo = $(this).attr('data-tipo'); //cojo el tipo de foto (galeria de usuarios o si es de ficha de planta, si es general, hoja, etc) a borrar con el atributo data-tipo del enlace o submit

    //si es una foto de la ficha de planta cojo sus atributos, si es de las galerías de usuarios recojo las id en un array y dejo la ruta vacía
    if (tipo != "galeria") {
      var id = $(this).attr('data-id'); //cojo la id de la foto/planta a borrar con el atributo data-id que tiene en enlace. Si es tipo ficha será a id de la planta
      var ruta = $(this).attr('data-ruta');  //cojo la ruta de la foto a borrar con el atributo data-ruta que tiene en enlace
    } else { //si el tipo es galería el data-id es el id de la propia foto y se meterá en un array. EL atributo está en el elemento input
      var ids = [];
      $("input[type=checkbox]:checked").each(function () { //se comprueban todos los checkbox de la galería, para ver si están marcados.
        ids.push(this.value);
      });
      var id = ids.toString(); //se pasan a un string para no variar los parámetros enviados por AJAX
      var ruta = ""; //se inicializa la ruta para no variar los parámetros enviados por AJAX
    }

    var img = $(this).siblings('img'); //se recoge para poder ocultarlo si tiene éxito la petición AJAX
    var enlace = $(this);  //se recoge para poder ocultarlo si tiene éxito la petición AJAX
    var parametros = {
      "id": id,
      "ruta": ruta,
      "tipo": tipo,
      "borrFoto": true
    };

    var mensaje = "Vas a borrar " + ((typeof ids !== 'undefined' && ids.length > 1) ? "las fotos" : "la foto") + " ¿Estás seguro?";
    bootbox.dialog({ //modal para la confirmación del borrado.
      message: mensaje,
      title: "<span class='text-success'><i class='fas fa-trash-alt'></i> ¡Atención!</span>",
      buttons: {
        cancel: {
          label: "No",
          className: "col-3 rounded-pill btn-outline-success",
          callback: function () {
            $('.bootbox').modal('hide'); //si se cancela, se esconde el modal, sin llamar a ninguna función más-
          }
        },
        confirm: {
          label: "<i class='fas fa-trash-alt'></i> Eliminar",
          className: "col-3 rounded-pill btn btn-success",
          callback: function () { //si se acepta el borrado se hace la llamada AJAX al archivo PHP que borrará las imágenes.

            $.ajax({
              url: './lib/functions.php',
              method: 'post',
              dataType: 'html',
              data: parametros
            })
              .done(function (data) {
                $('#mensajes-y-errores').html('<div class="row"><div class="alert alert-success">' + data + '</div></div>'); //muestro el mensaje de éxito o error que devuelve la función de php
                if (tipo != "galeria") {
                  img.remove(); // Como no recargo la página no recarga el php que muestra las filas, y necesito eliminar ese registro de la vista sin recargar
                  enlace.remove(); //elimino también el enlace de borrado,
                } else {
                  setTimeout(function () { location.reload(); }, 2500);
                  /*cuando se trata de imágenes de la galería sí recargo la pagina por la disposición de las imágenes en la página. 
                  De usar el mismo método que en las imágenes de la ficha quedarían huecos. Se usa el mñetodo location.reload() del 
                  objeto window, y una fsetTimeout para esperar un tiempo antes de la recarga y que se peudan leer los mensajes de 
                  éxito antes de recargar la página*/
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

  /*
  Esta función es similar, pero se usa para el borrado de registros: usuarios y plantas.
  Como en el caso anterior, se quiere usar una ventana modal para confirmar que realmente se quiere borrar ese registro, y desde el modal
  no se pueden enviar datos directamente a una función PHP.
  Si la llamada tiene éxito se necesita ocultar de fomra asíncrona las filas borradas en las tablas, ya que después de la llamada AJAX
  se han eliminado en la base de datos pero al no recargar la página se siguen viendo en la parte de cliente.
  Se usa navegación por el DOM, recogida de atributos del HTML, efectos de desvanecimientos, y modificación del DOM
  */

  $('.botonBorrar').click(function (e) {

    e.preventDefault();

    var id = $(this).attr('data-id');  //cojo la id del registro a borrar con el atributo data-id que tiene en enlace
    var tipo = $(this).attr('data-tipo'); //cojo el tipo de registro a borrar con el atributo data-tipo del enlace
    var parent = $(this).parent("td").parent("tr"); //se recoge el "abuelo" del enlace, que es la fila de la tabla, para poder ocultarla si tiene éxito la petición AJAX
    var parametros = {
      "id": id,
      "tipo": tipo,
      "borrSI": true
    };

    bootbox.dialog({
      message: "Vas a eliminar el registro " + id + " ¿Estás seguro?",
      title: "<span class='text-success'><i class='fas fa-trash-alt'></i> ¡Atención!</span>",
      buttons: {
        cancel: {
          label: "No",
          className: "col-3 rounded-pill btn-outline-success",
          callback: function () {
            $('.bootbox').modal('hide');
          }
        },
        confirm: {
          label: "<i class='fas fa-trash-alt'></i> Eliminar",
          className: "col-3 rounded-pill btn btn-success",
          callback: function () {

            $.ajax({
              url: './lib/functions.php',
              method: 'post',
              dataType: 'html',
              data: parametros
            })
              .done(function (data) {
                parent.slideUp('3000'); // No recargo la página con lo no recarga el php que muestra las filas, y necesito "eliminar" ese registro de la vista sin recargar
                $('#mensajes-y-errores').html('<div class="row"><div class="alert alert-success">' + data + '</div></div>'); //muestro el mensaje de éxito o error que devuelve la función de php
              })
              .fail(function () {
                bootbox.alert('Algo ha ido mal. No se ha podido borrar el registro.');
              })
          }
        }
      }
    });
  }); //fin función de borrado de registros

  /*
  Llamada AJAX para Ordenación de la colección de plantas.
  La colección de plantas se puede ordenar en orden ascendiente o descendiente según las cabeceras de la tabla. El array con las plantas
  se va a ordenar con PHP, pero se va a realizar una llamada AJAX con los parámetros de ordenación y un JSON con las plantas a ordenar.
  La ordenación se va a realizar de forma asíncrona, sin recargar la página. Las filas en la tabla con las plantas se ocultarán, y se 
  creará un nuevo cuerpo de tabla con los datos obtenidos.
  Se usa el DOM (para acceder a los elementos a borrar, para crear nuevos elementos y agregarlos después de otros elementos), se usan 
  funciones para ocultar elementos, para añadirlos, se cambian clases en los iconos con la función toogleClass, se comprueba su existe 
  una determinada clase, se recogen atributos, y además se trabaja con objetos JSON.
  */
  $('.ordenar').each(function () {
    $(this).click(function () {
      var col = $(this).attr('data-col');
      var order = "desc";
      if ($(this).children("i").hasClass('fa-sort-up')) {
        var order = "asc";
      }
      var parent = $(this).parents("thead");
      //console.log(datos);  //ok

      /*cuando se clica uno de estos botones se cambia el icono de la flecha cambiando la clase del icono. 
      Lo hago después de coger la variable para la ordenación que voy a mandar por AJAX
      Se navega por el DOM y se modifican clases del hijo*/
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
          //console.log("DATA" + data)
          data2 = JSON.parse(data); //se parsea el JSON para poder iterar el array resultante
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
            text += "<td><a href='index.php?p=fp&f=" + id + "'><img class='miniatura fit-cover' src='" + imagen + "' alt='miniatura de '" + nCient + "'></td></tr>";
          }
          text += "</tbody>";
          parent.siblings().fadeOut();
          parent.next().after(text);
        })
        .fail(function () {
          $('#mensajes-y-errores').html('<div class="row"><div class="alert alert-danger">Algo ha ido mal. No se ha podido completar la acción.</div></div>');
        })
    });//fin funcion .click
  }); //fin ordenar

    /*
  Llamada AJAX a la API de OpenWeather para mostrar datos de tiempo de Crevillent.
  Se usa la id de la ciudad, según recomendaciones de la API. El dato es fijo porque interesa mostrar el tiempo
  en Crevillente, y no donde se encuentra el usuario.
  */
  $.ajax({
    type: "GET",
    url: "http://api.openweathermap.org/data/2.5/weather?id=2519110&units=metric&APPID=b5cb30d0e3197e70384ac887d7b391f0",
    dataType: "json"
  })
    .done(function (data) {
      console.log(data);
      var tiempo = data.main.temp;
      var ciudad = data.name;
      var humedad = data.main.humidity;
      var presion = data.main.pressure;
      var urlIcono = "http://openweathermap.org/img/w/" + data.weather[0].icon + ".png";
      //se va a aprovechar también el icono que devuelve el JSON para mostrarlo en la página
      $("#tiempo").html("En " + ciudad + " hay <b>" + tiempo + " grados</b><img src="+ urlIcono +" alt='Icono tiempo'><br/>La humedad es del <b>" + humedad + "%</b> y la presión es de <b>" + presion + "hpa</b>");
    })
    .fail(function () {
      $("#tiempo").html("Fallo en la conexión con el servidor");
    });



  /**
 * ######################################################################
 * ######################################################################
 * ################    Validación de formularios        #################
 * ################  y otras funciones de formularios   #################
 * ###################################################################### 
 */

  /*esta función es para forzar la primera letra en mayúscula y el resto en minúscula en los nombres científicos de las plantas, 
  para seguir sus reglas de nomenclatura.
  Se usa con dos eventos, change y blur*/
  $('input[name ="nombre_cientifico"]').on('change blur', function (event) {
    $(this).val(function (i, v) {
      return $(this).val().trim().charAt(0).toUpperCase() + $(this).val().trim().slice(1).toLowerCase(); //lleva trims para evitar que no se siga el formato de nomenclatura si se introducen espacios en blanco delante por error.
    })
  });

   /*función para poner los caracteres que quedan disponibles en los textarea.
  Se usa navegación por el DOM, para seleccionar el elemento hermano al textarea en el que se hace la comprobación,
  y modificar, con el método html() solo ese elemento de entre todos los que tienen la misma clase.
  */
  $('textarea').on('input', function () { //se usa el evento input después de probar otros como keypress, keyup, keydown o change que no recogían la actividad de las teclas de suprimir y retroceso.
    var longitud = $(this).attr('maxlength'); //se recoge la longitud máxima del elemento, que viene definida en el HTML
    if (this.value.length > longitud) {
      return false;
    }
    $(this).siblings(".caracteresRestantes").html((longitud - this.value.length) + "/" + longitud); //se navega por el DOM, y se muestra la info de los caracteres restantes y los totales
  });

  //función de validación para TODOS los formularios.
  $("form").each(function () {  //uso una función para validar todos los formularios, ya que los de alta y modificación van a compartir nombre de los input, y reglas. 
    $(this).submit(function () { }).validate({ //la funcion de validar se ejecutará en el submit
      errorClass: "text-danger small border-danger",  //los mensajes de error aparecen en un span con class="error". Le añado clases de Bootstrap para modificar su estilo
      onkeyup: function (element, event) { //para que vaya también validando mientras se escribe en el input se le añade este parámetro
        if (event.which === 9 && this.elementValue(element) === "") {
          return;
        } else {
          this.element(element);
        }
      },
      rules: { //en este apartado se escriben las reglas de validación
        nombre_usuario: {  //se usa el "name" del input para definir las reglas y los mensajes asociados a esas reglas.
          //required: true,  //si la regla está en el HTML no hace falta ponerla. Se puede definir su mensaje de error, igualmente.
          esNombre: true,  //para cada elemento se indica sus reglas
          minLetras: 3
        },
        email_usuario: {
          esEmail: true
        },
        pass_usuario: {
          checkMinus: true,
          checkMayus: true,
          checkDigit: true
        },
        nombre_cientifico: {
          esNombreSci: true,
          minLetras: 3
        },
        familia: {
          esNombreSci: true,
          minLetras: 3
        },
        caracteres_diagnosticos: {
          minLetras: 3
        },
        nombreRegistro: {
          esNombre: true,
          minLetras: 3
        },
        emailRegistro: {
          esEmail: true
        },
        passRegistro: {
          checkMinus: true,
          checkMayus: true,
          checkDigit: true
        }
      },
      messages: {  //aquí se definen los mensajes de error que requieran mensaje. Si no, mostrará los mensajes por defecto, o los que se especifique en las porpias funciones de las reglas.
        nombre_usuario: {
          required: "Introduce nombre" //se puede definir un mensaje personalizado para una regla que no está especificada en la función, pero es uno de los atributos de validación de HTML5, como required, min-lenght...
        },
        email_usuario: {
          required: "Introduce email",
          email: "El formato del email no es correcto." //mensaje para sobreescribir el mensaje de error a validación por type=email de HTML5
        },
        pass_usuario: {
          required: "Introduce contraseña"
        },
        nombre_cientifico: {
          required: "Introduce el nombre científico"
        },
        familia: {
          required: "Introduce la Familia"
        },
        caracteres_diagnosticos: {
          required: "Introduce los caracteres diagnósticos"
        },
        nombreRegistro: {
          required: "Introduce nombre"
        },
        emailRegistro: {
          required: "Introduce email",
          email: "El formato del email no es correcto."
        },
        passRegistro: {
          required: "Introduce contraseña"
        }
      }

    });
  });


  //reglas para el validador
  //el "required" se puede saltar con espacios en blanco, así que creo uan regla que exija un mínimo de caracteres reales.
  $.validator.addMethod("minLetras", //prefiero un método con mínimo de letras a mínimo de longitud, porque ese también se salta con espacios en blanco
    function (value, element) {
      return value.trim().length > 2;
    }, "El nombre debe tener al menos {0} letras"  //añado el mensaje a la regla y no hace falta especificarlo en la función validate() para cada elemento
  );
  $.validator.addMethod("esTexto",
    function (value, element) {
      return /^[\wÁÉÍÓÚÜÑáéíóúüñ'\-,.%() \s]*$/.test(value); //lleva * y no + porque se usarán también en campos no requeridos, y de llevar + me pediría siempre al menos un caracter en campos no requeridos.
    },
    "Ese caracter no está permitido"
  );
  $.validator.addMethod("esNombre",  //para los nombres se admitirán todas las letras posibles en castellano/valenciano/inglés y dígitos, por si se prefiere tener un nombre "de usuario" en lugar del nombre "real", y se usará también para validar los nombres de las plantas en los distintos idiomas
    function (value, element) {
      return /^[\wÁÉÍÓÚÜÑÇáéíóúüñç', \s]*$/.test(value);
    },
    "Ese caracter no está permitido"
  );
  $.validator.addMethod("esNombreSci",  //los nombre científicos solo admiten letras, sin acentos.
    function (value, element) {
      return /^[A-Za-z \s]+$/.test(value);
    },
    "Solo admite letras"  
  );
  $.validator.addMethod("esEmail",  //para email se admiten letras, digitos, puntos, arroba, guiones y más. 
    function (value, element) {
      return /^\w+([\+\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(value);
    },
    "El formato del email no es correcto."
  );
  $.validator.addMethod("checkMinus", function (value) {  //comprueba que hay una minúscula, para la constraseña
    return /[a-z]/.test(value);
  },
    "La contraseña debe tener una letra minúscula"
  );
  $.validator.addMethod("checkMayus", function (value) {  //comprueba que hay una maysúscula, para la constraseña
    return /[A-Z]/.test(value);
  },
    "La contraseña debe tener una letra mayúscula"
  );
  $.validator.addMethod("checkDigit", function (value) { //comprueba que hay un dígito, para la constraseña
    return /[0-9]/.test(value);
  },
    "La contraseña debe tener un dígito"
  );

  $.validator.addClassRules({  //método para añadir un grupo de reglas a un grupo de elementos, que tienen una determinada clase. Solo necesito una regla para cada clase, pero se pueden añadir las que se neesiten 
    esCampoTexto: {
      esTexto: true //se usarán en los campos de texto no requeridos
    },
    esCampoNombre: {
      esNombre: true //se usarán en los campos que contienen nombres y que no sean requeridos
    }
  });


  /**
 * ######################################################################
 * ######################################################################
 * ########################## Otras Funciones ###########################
 * ######################################################################
 * ###################################################################### 
 */
  /*función para desplegar el formulario de registro en la página de las ficha de planta desde el enlace de 
  registro que aparece en las páginas de fichas de plantas para usuarios no registrados.
  Se usa el método find para navegar por el DOM, el selector :hidden de JQuery. EL método dropdown() es de la librería JS de Bootstrap*/
  $('#abrir').click(function (e) {
    e.stopPropagation();
    if ($('#desplegableRegistro').find('.dropdown-menu').is(":hidden")) {
      $('#desplegableRegistro').find('.dropdown-toggle').dropdown('toggle');
    }
  });

  /*función para no mostrar el nombre de la planta en las cards de las galerías de usuarios y borrado
  cuando la pantalla es muy pequeña. Se pone la clase d-none de Bootstrap que aplica display: none
  cuando el tamaño de la pantalla es menor que el establecido para tablet. 
  Se usa el método width del objeto window
  */
  $(window).on('resize', function () {
    $('.card-text span:first-child').toggleClass('d-none', $(window).width() < 768);
  });

  /*función para cumplir el requisito de usar el objeto Date. Se muestra un reloj en el footer.
  Se usa el método setInterval del objeto window para actualizarla cada segundo.*/
  setInterval(mostrarHora, 1000);
  function mostrarHora() {
    var hora = new Date();
    $("#hora").text(hora.getHours() + ":" + ((hora.getMinutes() > 9) ? hora.getMinutes() : ("0" + hora.getMinutes())) + ":" + ((hora.getSeconds() > 9) ? hora.getSeconds() : ("0" + hora.getSeconds())));
  }

})//fin $(document).ready(function ()