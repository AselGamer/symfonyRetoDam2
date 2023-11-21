/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import jQuery from 'jquery';
import 'bootstrap';

jQuery(window).on('load', function() {

    let cantPlataformas = 1;
    let cantEtiqueta = 1;
    let estadoCarga = 0;
    let articuloEliminar = -1;

    showFields(jQuery('#tipo').val());

    jQuery('#tipo').on('change', function() {
        showFields(jQuery(this).val());
    });

    function showFields(field) {
        switch (field) {
            case "Consola":
                jQuery('#consola').show();
                jQuery('#dipositivo').hide();
                jQuery('#videojuego').hide();
                break;
            case "Dispositivo Movil":
                jQuery('#consola').hide();
                jQuery('#dipositivo').show();
                jQuery('#videojuego').hide();
                break;
            case "VideoJuego":
                jQuery('#consola').hide();
                jQuery('#dipositivo').hide();
                jQuery('#videojuego').show();
                break;
            default:
                jQuery('#consola').hide();
                jQuery('#dipositivo').hide();
                jQuery('#videojuego').hide();
                break;
        }
    }

    jQuery('.btnAddPlataforma').on('click', function() {


        let plataforma = jQuery('.plataformaPlantilla').last().clone();
        cantPlataformas++;

        addRemoveButton(plataforma);

        addPlataforma();

        function addPlataforma() {
            jQuery('#contPlataformas').append(plataforma);
        }

        function addRemoveButton(plataforma) {
            if (cantPlataformas <= 2 && !plataforma.find('.btnRemovePlataforma').length > 0) {
                plataforma.find('.plataformaPlantillaInner').append('<button type="button" class="btn btn-danger btnRemovePlataforma">X</button>');
            }

            plataforma.find('.btnRemovePlataforma').on('click', function() {
                jQuery(this).parent().parent().remove();
                cantPlataformas--;
            });
        }
    });

    jQuery('.btnRemovePlataforma').on('click', function() {
        jQuery(this).parent().parent().remove();
        cantPlataformas--;
    });

    jQuery('.btnAddEtiqueta').on('click', function () {

        let etiqueta = jQuery('.etiquetaPlantilla').last().clone();
        cantEtiqueta++;

        addRemoveButton(etiqueta);

        addEtiqueta();

        function addEtiqueta() {
            jQuery('#contEtiqueta').append(etiqueta);
        }

        function addRemoveButton(etiqueta) {
            if (cantEtiqueta <= 2 && !etiqueta.find('.btnRemoveEtiqueta').length > 0) {
                etiqueta.find('.etiquetaPlantillaInner').append('<button type="button" class="btn btn-danger btnRemoveEtiqueta">X</button>');
            }

            etiqueta.find('.btnRemoveEtiqueta').on('click', function() {
                jQuery(this).parent().parent().remove();
                cantEtiqueta--;
            });
        }
    });

    jQuery('.btnRemoveEtiqueta').on('click', function() {
        jQuery(this).parent().parent().remove();
        cantEtiqueta--;
    });


    jQuery('#estado').on('change', function() {
        estado = jQuery(this).val();
        if (estado == 2) {
            jQuery('.modal-body').find('p').text('Al cambiar el estado a "Activo" te haces responsable de la reparación del dispositivo.');
            jQuery('.modal').show();
        } else if (estado == 3) {
            jQuery('.modal-body').find('p').text('Al cambiar el estado a "Finalizado" no se podra volver a editar y el dispositivo se le devolvera al cliente en el estado actual.');
            jQuery('.modal').show();
        } else if (estado == 1) {
            jQuery('.modal-body').find('p').text('Al cambiar el estado a "Enviado" se eliminaran los datos de la reparacion incluiendo el empleado que esta realizando la misma.');
            jQuery('.modal').show();
        }
        estadoCarga = estado;
        cambiarEstado();
    }
    );

    jQuery('.closeModal').on('click', function() {
        jQuery('.modal').hide();
    });

    estadoCarga = jQuery('#estado').val();

    cambiarEstado();

    function cambiarEstado() {
        switch (estadoCarga) {
            case '1' || 1:
                jQuery('.activo').hide();
                jQuery('.finalizado').hide();
                break;
            case '2' || 2:
                jQuery('.finalizado').hide();
                jQuery('.activo').show();
                break;
            case '3' || 3:
                jQuery('.activo').show();
                jQuery('.finalizado').show();
                break;
        }
    };

    jQuery('.btnDelete').on('click', function() {
        articuloEliminar = jQuery(this).attr('id-eliminar');
        jQuery('.modal').show();
    });

    jQuery('.botonBorrar').on('click', function() {
        window.location.href = '/articulos/delete/' + articuloEliminar;
    });

    jQuery('.botonBorrarMarca').on('click', function() {
        window.location.href = '/marcas/delete/' + articuloEliminar;
    });

    jQuery('.botonBorrarPlataforma').on('click', function() {
        window.location.href = '/plataformas/delete/' + articuloEliminar;
    });

    jQuery('.botonBorrarEtiqueta').on('click', function() {
        window.location.href = '/etiqueta/delete/' + articuloEliminar;
    });

 

    jQuery('.btnBuscarTabla').on('click', function() {
        let valor = jQuery('.inputBuscarTabla').val();
        jQuery('.tablaBuscar tr').each(function() {

            jQuery(this).filter(function() {
                jQuery(this).hide();
                if(jQuery(this).text().toLowerCase().indexOf(valor.toLowerCase()) > -1)
                {
                    jQuery(this).show();
                }
              });
        });
    });

    jQuery('.btnBuscarArticulos').on('click', function() {
        let valor = jQuery('.inputBuscarTodo').val();
        window.location.href = '/articulos/buscar/' + valor;
    });

    jQuery('.btnBuscarMarcas').on('click', function() {
        let valor = jQuery('.inputBuscarTodo').val();
        window.location.href = '/marcas/buscar/' + valor;
    });

    jQuery('.btnBuscarPlataformas').on('click', function() {
        let valor = jQuery('.inputBuscarTodo').val();
        window.location.href = '/plataforma/buscar/' + valor;
    });

    jQuery('.btnBuscarEtiquetas').on('click', function() {
        let valor = jQuery('.inputBuscarTodo').val();
        window.location.href = '/etiqueta/buscar/' + valor;
    });

    jQuery('.btnBuscarReparaciones').on('click', function() {
        let valor = jQuery('.inputBuscarTodo').val();
        window.location.href = '/reparacion/buscar/' + valor;
    });

    jQuery('.btnBuscarTransacciones').on('click', function() {
        let valor = jQuery('.inputBuscarTodo').val();
        window.location.href = '/transaccion/buscar/' + valor;
    });

    jQuery('.btnBuscarEmpleados').on('click', function() {
        console.log('penes');
        let valor = jQuery('.inputBuscarTodo').val();
        window.location.href = '/empleado/buscar/' + valor;
    });
    
});