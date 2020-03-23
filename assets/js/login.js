import $ from 'jquery';


$(() => {

    /* register process */
    processUser($("#panel8"), '.registration_form', './register');

    /* Login process */

    processUser($("#panel7"), '#loginForm', './login');

});

function parseJson(data) {

    let something;

    if (typeof data != 'string')
        something = JSON.stringify(data);

    try {
        return JSON.parse(something);
    } catch (e) {
        return false;
    }
}

/**
 * Login or register process
 * @param panel
 * @param id_form
 * @param url The action form
 */

function processUser(panel, id_form, url) {

    panel.on('submit', id_form, (e) => {
        e.preventDefault();

        const formSerialize = $(id_form).serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: formSerialize
        })
            .done((data) => {

                let response = parseJson(data);

                if (!response) { // process failed

                    panel.html(data)
                        .find('input')
                        .trigger('focus');

                    // setTimeout(function() {
                    //     panel.find('svg').removeClass('active')
                    // }, 1000);


                } else { //process success

                    location.href = response.location;
                }
            });
    });
}


