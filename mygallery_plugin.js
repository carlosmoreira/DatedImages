(function () {
    tinymce.create('tinymce.plugins.dicm', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init: function (ed, url) {


            ed.addButton('showrecent', {
                text: "Dated Image",
                title: 'Show or hide an image according to a certain date period',
                cmd: 'showrecent',
                image: url + '/recent.jpg'
            });


            ed.addCommand('showrecent', function () {

                ed.windowManager.open({
                    title: 'Date Image',
                    body: [
                        {
                            type: 'textbox',
                            name: 'startDate',
                            label: 'Start Date',
                            id: 'id_start_date'
                        },
                        {
                            type: 'textbox',
                            name: 'endDate',
                            label: 'End Date',
                            id: 'id_end_date'
                        },

                        {
                            type: 'textbox',
                            name: 'img_url',
                            id: 'img_url',
                            disabled: "disabled"
                        },
                        {
                            id: "myUpload",
                            text: "Upload",
                            type: 'button',
                            name: 'title',
                            label: 'Select Image',
                            inline: 1,
                            onclick: function () {

                                formfield = jQuery('#upload_image').attr('name');
                                tb_show('', 'media-upload.php?type=image&amp;TB_iframe=false');
                                $('#TB_window').css('z-index', '100102');
                                window.send_to_editor = function (html) {
                                    imgurl = jQuery('img', html).attr('src');
                                    jQuery('#img_url').val(imgurl);
                                    tb_remove();
                                }
                                return false;
                            }
                        }

                    ],
                    onsubmit: function (e) {
                        console.log("e",e);
                        ed.insertContent("[DateImage src='"+ e.data.img_url +"' start_date='"+ e.data.startDate+"' end_date='"+ e.data.endDate +"']");
                    }
                });

                $("input#id_start_date, input#id_end_date").datepicker({dateFormat :  "yy-mm-dd"});
                $("input#id_start_date").blur();
            });

        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl: function (n, cm) {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo: function () {
            return {
                longname: 'DateImage',
                author: 'Carlos Moreira',
                authorurl: 'http://therealcarlos.com/',
                infourl: 'http://therealcarlos.com/dated-images-plugin/',
                version: "1.0"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('dicm', tinymce.plugins.dicm);
})();