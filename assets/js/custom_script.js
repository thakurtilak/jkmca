$(document).ready(function () {
    // $fn.scrollSpeed(step, speed, easing);
    //jQuery.scrollSpeed(100, 800);
});
$(document).ready(function () {
    /*Active class js*/
    var url = window.location;
    $('.side_menu ul a').filter(function () {
        return this.href == url;
    }).parent().addClass('active');

    // for treeview
    $('ul.sub_menu  a').filter(function () {
        return this.href == url;
    }).closest('.sub_menu ').addClass('in');

    /*Active class js*/

    jQuery('img.svg').each(function () {
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        jQuery.get(imgURL, function (data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');

            // Add replaced image's ID to the new SVG
            if (typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if (typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass + ' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Replace image with new SVG
            $img.replaceWith($svg);

        }, 'xml');
    });
    //End svg Js
    //Custom Upload Field
    (function ($) {

        // Browser supports HTML5 multiple file?
        var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
            isIE = /msie/i.test(navigator.userAgent);

        $.fn.customFile = function () {
            return this.each(function () {

                var $file = $(this).addClass('custom-file-upload-hidden'), // the original file input
                    $wrap = $('<div class="file-upload-wrapper">'),
                    $input = $('<input type="text" name="file-upload-input" class="file-upload-input" placeholder="Agreement Upload*" />'),
                // Button that will be used in non-IE browsers
                    $button = $('<button type="button" class="file-upload-button file-upload-select"></button>'),
                // Hack for IE
                    $label = $('<label class="file-upload-button" for="' + $file[0].id + '">Select a File</label>');

                // Hide by shifting to the left so we
                // can still trigger events
                $file.css({
                    position: 'absolute',
                    left: '-9999px'
                });
                $wrap.insertAfter($file)
                    .append($file, $input, ( isIE ? $label : $button ));

                // Prevent focus
                $file.attr('tabIndex', -1);
                $button.attr('tabIndex', -1);

                $(document).on('click', '.file-upload-select', function () {
                    $file.focus().click(); // Open dialog
                });
                /*$button.on('click', function () {
                 $file.focus().click(); // Open dialog
                 });*/

                $file.change(function () {

                    var files = [], fileArr, filename;

                    // If multiple is supported then extract
                    // all filenames from the file array
                    if (multipleSupport) {
                        fileArr = $file[0].files;
                        for (var i = 0, len = fileArr.length; i < len; i++) {
                            files.push(fileArr[i].name);
                        }
                        filename = files.join(', ');

                        // If not supported then just take the value
                        // and remove the path to just show the filename
                    } else {
                        filename = $file.val().split('\\').pop();
                    }
                    var $id = $(this).attr('id');
                    console.log($id);
                    //$input.val( filename ) // Set the value
                    //  .attr('title', filename) // Show filename in title tootlip
                    //  .focus(); // Regain focus

                });

                $input.on({
                    blur: function () {
                        $file.trigger('blur');
                    },
                    keydown: function (e) {
                        if (e.which === 13) { // Enter
                            if (!isIE) {
                                $file.trigger('click');
                            }
                        } else if (e.which === 8 || e.which === 46) { // Backspace & Del
                            // On some browsers the value is read-only
                            // with this trick we remove the old input and add
                            // a clean clone with all the original events attached
                            $file.replaceWith($file = $file.clone(true));
                            $file.trigger('change');
                            $input.val('');
                        } else if (e.which === 9) { // TAB
                            return;
                        } else { // All other keys
                            return false;
                        }
                    }
                });

            });

        };

        // Old browser fallback
        if (!multipleSupport) {
            $(document).on('change', 'input.customfile', function () {

                var $this = $(this),
                // Create a unique ID so we
                // can attach the label to the input
                    uniqId = 'customfile_' + (new Date()).getTime(),
                    $wrap = $this.parent(),

                // Filter empty input
                    $inputs = $wrap.siblings().find('.file-upload-input')
                        .filter(function () {
                            return !this.value
                        }),

                    $file = $('<input type="file" id="' + uniqId + '" name="' + $this.attr('name') + '"/>');

                // 1ms timeout so it runs after all other events
                // that modify the value have triggered
                setTimeout(function () {
                    // Add a new input
                    if ($this.val()) {
                        // Check for empty fields to prevent
                        // creating new inputs when changing files
                        if (!$inputs.length) {
                            $wrap.after($file);
                            $file.customFile();
                        }
                        // Remove and reorganize inputs
                    } else {
                        $inputs.parent().remove();
                        // Move the input so it's always last on the list
                        $wrap.appendTo($wrap.parent());
                        $wrap.find('input').focus();
                    }
                }, 1);

            });
        }

    }

    (jQuery));
    // $('input[type=file]').customFile();
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
});