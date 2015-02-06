var toggleOpen = false;

function toggleTree() {
    if(!toggleOpen) {
        $("input[type='checkbox']").prop("checked", true);
    } else {
        $("input[type='checkbox']").removeAttr("checked");
    }
    toggleOpen = !toggleOpen;
}

function rawTree() {
    if($('#debugContainer').is(":visible")) {
        $('#debugContainer').hide();
    } else {
        $('#debugContainer').show();

        optionObject = {
            url: base + '/tree',
            type: 'GET',
            dataType: 'html'
        };
        apiCaller(optionObject).then(function(data) {
            $('#debugContainer').html(data);

        });
    }

}

function loadTree() {
    optionObject = {
        url: base + '/tree/html',
        type: 'GET',
        dataType: 'html'
    };
    apiCaller(optionObject).then(function(data) {
        $('#treeContainer').html(data);
        // Remove old events
        $("label").off(groupEvent);
        $(".user").off(userEvent);

        // Reattach events
        $("label").on(groupEvent);
        $(".user").on(userEvent);

    });
}

function deleteTree() {
    optionObject = {
        url: base + '/tree/delete',
        type: 'POST',
        dataType: 'html'
    };
    apiCaller(optionObject).then(function(data) {
        $('#treeContainer').html(data);
        // Remove old events
        $("label").off(groupEvent);
        $(".user").off(userEvent);

        // Reattach events
        $("label").on(groupEvent);
        $(".user").on(userEvent);

    });
}