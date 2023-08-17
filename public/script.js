$('#signupForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: './auth/signup',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            $('#signupForm').trigger("reset");
            $('.info').empty();
            if (response.success) {
                window.location.href = "./login?registration=success";
            } else {
                const errors = response.errors;
                const infoDiv = $('.info');
                errors.forEach(error => {
                    infoDiv.append(`<div class='failure'>${error}</div>`);
                });
            }
        },
        error: function (error) {
            console.error(error);
            $('.info').empty();
            const infoDiv = $('.info');
            infoDiv.append(`<div class='failure'>${error.responseJSON.message}</div>`);
        }
    });
});

$('#loginForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: './auth/login',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            $('#loginForm').trigger("reset");
            $('.info').empty();
            if (response.success) {
                window.location.href = "./dashboard";
            } else {
                const errors = response.errors;
                const infoDiv = $('.info');
                errors.forEach(error => {
                    infoDiv.append(`<div class='failure'>${error}</div>`);
                });
            }
        },
        error: function (error) {
            console.error(error);
            $('.info').empty();
            const infoDiv = $('.info');
            infoDiv.append(`<div class='failure'>${error.responseJSON.message}</div>`);
        }
    });
});