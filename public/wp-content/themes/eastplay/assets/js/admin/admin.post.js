jQuery(document).ready(function(a){a(".select2").select2();a(".eastheme-cover-upload").on("click",function(d){d.preventDefault();var b=a(this);var c=wp.media.frames.file_frame=wp.media({title:b.data("uploader_title"),button:{text:b.data("uploader_button_text"),},multiple:false});c.on("select",function(){var e=c.state().get("selection").first().toJSON();b.prev(".eastheme-cover-url").val(e.url).change()});c.open()});a(".eastheme-thumbnail-upload").on("click",function(d){d.preventDefault();var b=a(this);var c=wp.media.frames.file_frame=wp.media({title:b.data("uploader_title"),button:{text:b.data("uploader_button_text"),},multiple:false});c.on("select",function(){var e=c.state().get("selection").first().toJSON();b.prev(".eastheme-thumbnail-url").val(e.url).change()});c.open()});a(".timeupdate").timepicker();a("#add-row-player").on("click",function(){var b=a(".empty-row-player.screen-reader-text-player").clone(true);b.removeClass("empty-row-player screen-reader-text-player");b.insertBefore("#eastheme-fieldset-player tbody>tr:last");return false});a(".remove-row-player").on("click",function(){a(this).parents("tr").remove();return false});a("#eastheme-fieldset-player tbody").sortable({items:".tritem",opacity:0.8,cursor:"move",});a("#add-row").on("click",function(){var b=a(".empty-row.screen-reader-text").clone(true);b.removeClass("empty-row screen-reader-text");b.insertBefore("#repeatable-fieldset-one tbody>tr:last");return false});a(".remove-row").on("click",function(){a(this).parents("tr").remove();return false});a("#repeatable-fieldset-one tbody").sortable({items:".tritem",opacity:0.8,cursor:"move",})});
