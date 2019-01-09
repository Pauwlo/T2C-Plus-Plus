var settings = {
    'showBtnAdd': undefined,
    'dayMode': undefined
}

function getHash(string) {
    var shaObj = new jsSHA("SHA-256", "TEXT");
    shaObj.update(string);
    return shaObj.getHash("HEX");
}

function loadCSS(dayMode) {
    if (dayMode) {
        $('<link/>', {
            rel: 'stylesheet',
            href: './public/css/app-day.css',
            id: 'style-day'
        }).appendTo('head');
        $('#style-default').remove();
    } else {
        $('<link/>', {
            rel: 'stylesheet',
            href: './public/css/app.css',
            id: 'style-default'
        }).appendTo('head');
        $('#style-day').remove();
    }
}

$(function () {
    settings.showBtnAdd = $('#s-showBtnAdd').data('value');
    settings.dayMode = $('#s-dayMode').data('value');

    $('#save').click(function (event) {
        event.preventDefault();
        var password = $('#password').val();

        $('#action').attr('value', 'save');
        $('#password-hash').val(getHash(password));
        $('#auth').submit();
    });

    $('#load').click(function (event) {
        event.preventDefault();
        var password = $('#password').val();

        $('#action').attr('value', 'load');
        $('#password-hash').val(getHash(password));
        $('#auth').submit();
    });

    $('.btn-setting').click(function () {
        var name = $(this).data('name');
        var value;

        switch (name) {

            case 'showBtnAdd':
                settings.showBtnAdd = ! settings.showBtnAdd;
                $(this).text(settings.showBtnAdd ? 'Désactiver' : 'Activer');
                $('#t-showBtnAdd').text(settings.showBtnAdd ? 'Oui' : 'Non');
                value = settings.showBtnAdd;
                break;

            case 'dayMode':
                settings.dayMode = ! settings.dayMode;
                loadCSS(settings.dayMode);
                $(this).text(settings.dayMode ? 'Désactiver' : 'Activer');
                $('#t-dayMode').text(settings.dayMode ? 'Oui' : 'Non');
                value = settings.dayMode;
                break;
            
            default:
                console.error('Unknown setting.');
                break;
        }

        $.post(
            './api/setSetting',
            {'name': name, 'value': value}
        )
    });

    $('.btn-delete-favorite').click(function () {
        var name = $(this).data('name');
        $(this).parent().parent().remove();

        $.post(
            './api/removeFavorite',
            {'name': name}
        )

        let count = $("#favorites-table-body tr").length;
        if (count == 0) {
            $('#favorites-table').replaceWith('<p>Vous n\'avez pas encore créé de favori.</p>');
        }
    });
});
