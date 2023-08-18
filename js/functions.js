
// helper funtion to determine if a value is a number
function isNumeric(value) {
    return /^-?\d+$/.test(value);
}


// helper function to determine if a text overflows
function isEllipsisActive(e) {
    return (e.offsetWidth < e.scrollWidth);
}


// helper function to convert rgb value to hex value
function rgb2hex(rgb) {
    if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}


// helper function to check if a color is "light"
function isLight(hexColor) {
    var r = parseInt(hexColor.substr(1, 2), 16);
    var g = parseInt(hexColor.substr(3, 2), 16);
    var b = parseInt(hexColor.substr(5, 2), 16);

    // change the value at the end of the formula to change the lightness threshold - lower is darker
    return (r * 299 + g * 587 + b * 114) / 1000 > 230;
}

function isLighter(hexColor) {
    var r = parseInt(hexColor.substr(1, 2), 16);
    var g = parseInt(hexColor.substr(3, 2), 16);
    var b = parseInt(hexColor.substr(5, 2), 16);

    // change the value at the end of the formula to change the lightness threshold - lower is darker
    return (r * 299 + g * 587 + b * 114) / 1000 > 130;
}


// function that inserts the data from the database in the html
function insert_live_data(channel_id, type) {
    // receive data from GET request
    $.ajax({
        type: "GET",
        data: {
            ID: channel_id,
        },
        url: "../php/get_data.php",
        success: function (data) {
            
            // Go through all entries in the database response
            $.each((data[0]), function(key, value) {
    
                // Only use real DB returns - DB also returns values with a number count instead of key name (e.g. 0: 'teamname')
                if (!isNumeric(key)) {

                    //convert booleans
                    if (value == 0) {
                        bool_value = false;
                    } else if (value == 1) {
                        bool_value = true;
                    }

                    if (key == "visible") {
                        visible = value;
                    } else if (key == "showRGX") {
                        showRGX = value;
                        $('#showRGX').prop('checked', bool_value);
                    } else if (key == "isPro") {
                        isPro = value;
                        $('#isPro').prop('checked', bool_value);
                    } else if (key == "showHeading") {
                        showHeading = value;
                        $('#showHeading').prop('checked', bool_value);
                    } else {
                        // Go through all html elements that have an id
                        $.each($("*[id]"), function(j, elem) {

                            // extract id value
                            var id = $(elem).attr("id")

                            // Check if element id matches key name
                            if (id == key) {
                                if (type == "stream") {
                                    $(elem).text(value);
                                    // make text smaller if it overflows
                                    // console.log($(elem).text(), isEllipsisActive($(elem)));
                                    while(isEllipsisActive($(elem))) {
                                        fontSize = pareseInt($(elem).css('font-size'));
                                        $(elem).css('font-size', fontSize - 1 + "px")
                                    }
                                } else if (type == "admin") {
                                    $(elem).val(value);
                                }
                            }
                        });

                    }
                }
            });
        }
    });
}



// function that uploads all the local data to the database
function upload_local_data(channel_id, elemList) {
 
    if ($('#showRGX').is(":checked")) {
        showRGX = 1
    } else {
        showRGX = 0
    }

    if ($('#isPro').is(":checked")) {
        isPro = 1
    } else {
        isPro = 0
    }

    if ($('#showHeading').is(":checked")) {
        showHeading = 1
    } else {
        showHeading = 0
    }

    if (typeof elemList == 'undefined') {
        elemList = $("*[database-variable]");
    }
    
    var dataObject = {};
    dataObject['ID'] = channel_id;
    dataObject['visible'] = visible;
    $.each($(elemList), function(i, elem) {
        var $elem = $(elem);
        var type = $elem.attr("type");
        var id = $elem.attr("id");
        var value;
        if (type == "checkbox") {
            if ($elem.is(":checked")) {
                value = 1;
            } else {
                value = 0;
            }
        } else {
            value = $elem.val();
        }
        dataObject[id] = value;
    });

    console.log(dataObject);

    $.ajax({
        type: 'POST',
        url: '../php/update_data.php',
        data: dataObject,
        dataType: 'json',
    });
}


function update_RGX($rgx) {
    if (showRGX == 1) {
        $rgx.show();
    } else {
        $rgx.hide();
    }

    if (isPro == 1) {
        $rgx.addClass('pro');
    } else {
        $rgx.removeClass('pro');
    }
}

function update_heading($heading) {
    if (showHeading == 1) {
        $heading.show();
    } else if (showHeading == 0) {
        $heading.hide();
    }
}


function change_channel(channel, type) {
    insert_live_data(channel, type);
    // apply all the special variables - with a bit delay so the database values are safely loaded
    setTimeout(function() {
        
    }, 500)
}