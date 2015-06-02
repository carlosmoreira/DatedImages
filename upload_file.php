<input type="text" class="selected_image" />
<input type="button" class="upload_image_button" value="Upload Image">


<script>
    jQuery(document).ready(function() {

        jQuery('#selected_image').click(function() {
            console.log("Test");
            //formfield = jQuery('#upload_image').attr('name');
            //tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            //return false;
        });

        window.send_to_editor = function(html) {
            imgurl = jQuery('img',html).attr('src');
            jQuery('#upload_image').val(imgurl);
            tb_remove();
        }

    });
</script>