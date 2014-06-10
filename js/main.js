/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        url: 'scripts/index.php',
        formData: {username: 'test'},
        dataType: 'text',
        fail: function(e, data) {
            alert(data.errorThrown);
        },
        done: function (e, data) {
            // data.result
            // data.textStatus;
            // data.jqXHR;
            // alert(data.result);
        }
    });

});
