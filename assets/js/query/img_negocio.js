$(document).ready(function () {

    $("#btn-img").click(function (event) {
        //stop submit the form, we will post it manually.
        event.preventDefault();
        // Get form
        var form = $('#form-img')[0];
        // Create an FormData object 
        var data = new FormData(form);
        // disabled the submit button
        $("#btn-img").prop("disabled", true);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "application/src/routes.php?op=163",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {

                $("#result").html(data);
                console.log("SUCCESS : ", data);
                $("#btn-img").prop("disabled", false);
                $("#form-img").trigger("reset");

            },
            error: function (e) {

                $("#result").html(e.responseText);
                console.log("ERROR : ", e);
                $("#btn-img").prop("disabled", false);

            }
        });

    });








});

