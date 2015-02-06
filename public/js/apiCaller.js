/**
 * Created by Nick Postma on 18-1-14.
 */

var apiCaller = function(options) {
    var deferred = $.Deferred();
    var defaults = {
        type: 'GET',
        data: {},
        dataType: 'json',
        async: true
    };
    $.extend(defaults, options);

    $.ajax({
        url: defaults.url,
        type: defaults.type,
        dataType: defaults.dataType,
        data: defaults.data,
        success: deferred.resolve
    })
    return deferred.promise();
}


