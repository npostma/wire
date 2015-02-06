/**
 * Created by Nick Postma on 18-1-14.
 */
var base = '/wire/public';

var userEvent = {
    click : function (e)
    {
        $('#newNodeContainer').hide();
        var object = $(e.target).parent();
        apiCaller(getApiCallOptions(object)).then(function(data) {
            fillEditForm(data);
        });
        return false;
    }
};

// Binding onclick events on labels
var groupEvent = {
    click : function (e)
    {
        $('#newNodeContainer').show();


        apiCaller(getApiCallOptions($(e.target))).then(function(data) {
            fillEditForm(data);

            // The root node is different from the other group nodes.
            // No deletion, and no user adding at this level.
            if(data.nodeId == 1) {
                $('#deleteButton').hide();
                $('#userNodeType').hide();
                $('#newType').val(1);
            } else {
                $('#deleteButton').show();
                $('#userNodeType').show();
            }

        });
        return false;
    }
};

$(document).ready(function() {
    // Set the event on the root node
    $("label").on(groupEvent);

    // Callback handler for the edit node form on a submit event
    $("#nodeEditForm").submit(function(e) {
        e.preventDefault();

        var error = '';
        if($('#nodeId').val() < 1) {
            error += '\nEr is geen element geselecteerd.';
        }
        if($('#editName').val().length < 1) {
            error += '\nEr moet een naam worden invuld.';
        }
        if(error != '') {
            alert('Er is een fout opgetreden met de volgende melding(en):\n' + error);
            return false;
        }

        optionObject = {
            url: base + '/node/contents',
            type: 'POST',
            dataType: 'json',
            data: {
                name: $('#editName').val(),
                description: $('#editDescription').val(),
                nodeId: $('#nodeId').val()
            }
        };
        apiCaller(optionObject).then(function(data) {
            // Find label with a specific ID
            var label = $('label[data-nodeid="' + data.nodeId + '"]');
            if(label.length) {
                label.html(data.name);
                label.data('description', data.description);
                label.data('name', data.name);
            } else {
                // No label found? Then its a user!
                var li = $('li[data-nodeid="' + data.nodeId + '"]');
                li.data('description', data.description);
                li.data('name', data.name);
                li.children('a').html(data.name);
            }
        });
        e.preventDefault();
    });

    // Callback handler for the new node form on a submit event
    $("#nodeNewForm").submit(function(e) {
        e.preventDefault();

        var error = '';
        if($('#nodeId').val() < 1) {
            error += '\nEr is geen element geselecteerd.';
        }
        if($('#newType').val() < 1) {
            error += '\nEr is geen soort geselecteerd.';
        }
        if($('#newName').val().length < 1) {
            error += '\nEr moet een naam worden invuld.';
        }
        if(error != '') {
            alert('Er is een fout opgetreden met de volgende melding(en):\n' + error);
            return false;
        }

        optionObject = {
            url: base + '/node/add',
            type: 'POST',
            dataType: 'html',
            data: {
                nodeType: $('#newType').val(),
                name: $('#newName').val(),
                description: $('#newDescription').val(),
                parentNodeId: $('#nodeId').val()

            }
        };

        apiCaller(optionObject).then(function(data) {
            // Find label with a specific ID
            var ol = $('label[data-nodeid="' + $('#nodeId').val() + '"]').siblings('ol');
            ol.append(data);
            // Remove old events
            $("label").off(groupEvent);
            $(".user").off(userEvent);

            // Reattach events
            $("label").on(groupEvent);
            $(".user").on(userEvent);
        });
    });
});

function fillEditForm(data) {
    $('#editName').val(data.name);
    $('#editDescription').val(data.description);
    $('#nodeId').val(data.nodeId);
}

function getApiCallOptions (object ){
    return {
        url: base + '/node/contents',
        type: 'GET',
        dataType: 'json',
        data: {
            name: object.data('name'),
            description:  object.data('description'),
            nodeId:  object.data('nodeid')
        }
    };
}

function deleteNode() {
    if(confirm('Weet u zeker dat u dit element wilt verwijderen, met eventueel alle onderliggende data?')) {
        // Find label with a specific ID
        var label = $('label[data-nodeid="' + $('#nodeId').val() + '"]');
        if(label.length) {
            label.parent().remove();
        } else {
            // No label found? Then its a user!
            var li = $('li[data-nodeid="' + $('#nodeId').val() + '"]');
            li.remove();
        }
        optionObject = {
            url: base + '/node/delete',
            type: 'POST',
            dataType: 'html',
            data: {
                nodeId: $('#nodeId').val()
            }
        };
        apiCaller(optionObject).then(function(data) {
        });
    }
}