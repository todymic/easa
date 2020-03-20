import $ from "jquery";
import 'mdbootstrap/js/bootstrap';

$(document).ready(function () {
    var table = $('#dtBasicExample').DataTable({
        dom: 'Bfrtip',
        select: true,
        buttons: [{
            text: 'Select all',
            action: function () {
                table.rows().select();
            }

        },
            {
                text: 'Select none',
                action: function () {
                    table.rows().deselect();
                }
            }]
    });
});

