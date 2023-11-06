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

        /*
        plataforma.find('label').each(function() {
            console.log(jQuery(this).html());
            let label = jQuery(this).html();
            label = label.replace(cantPlataformas-1, cantPlataformas);
            jQuery(this).html(label);
        });
        */

        addRemoveButton(plataforma);

        addPlataforma();

        function addPlataforma() {
            jQuery('#contPlataformas').append(plataforma);
        }

        function addRemoveButton(plataforma) {
            console.log(!plataforma.find('.btnRemovePlataforma').length > 0);
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
});