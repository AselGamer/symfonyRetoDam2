/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import jQuery, { map } from 'jquery';
import 'bootstrap';

jQuery(window).on('load', function() {

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
});