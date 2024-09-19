$(document).ready(function() {
     /*$('.datepicker').bootstrapMaterialDatePicker({ 
        time: false }).on('change', function(e){
            $(this).parent('.form-line').addClass('focused');
            return true;
        }); */
    $('#media_uploader').filer({
        limit: null,
        maxSize: 2,
        extensions: null,
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="fa fa-upload"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
        showThumbs: true,
        appendTo: null,
        theme: "dragdropbox",
        templates: {
            box: '<ul class="jFiler-item-list"></ul>',
            item: '<li class="jFiler-item">\
                        <div class="jFiler-item-container waves-effect waves-dark">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                    <div class="jFiler-item-status"></div>\
                                    <div class="jFiler-item-info">\
                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                    </div>\
                                    {{fi-image}}\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row">\
                                    <ul class="list-inline pull-left">\
                                        <li>{{fi-progressBar}}</li>\
                                    </ul>\
                                    <ul class="list-inline pull-right">\
                                        <li><span class="media-send-to-edit waves-effect waves-dark btn btn-primary" onclick="return send_media_to_edit(this);">Edit</span></li>\
                                        <li><span class="icon-jfi-trash media-send-to-trash"></span></li>\
                                    </ul>\
                                </div>\
                            </div>\
                        </div>\
                    </li>',
            itemAppend: '<li class="jFiler-item " data-media="{{fi-size}}" data-src="{{fi-url}}">\
                        <div class="jFiler-item-container waves-effect waves-dark">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                    <div class="jFiler-item-status"></div>\
                                    <div class="jFiler-item-info">\
                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                    </div>\
                                    {{fi-image}}\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row">\
                                    <ul class="list-inline pull-left">\
                                        <span class="jFiler-item-others">{{fi-icon}} {{fi-type}}</span>\
                                    </ul>\
                                    <ul class="list-inline pull-right">\
                                        <li><span class="media-send-to-edit waves-effect waves-dark btn btn-primary" onclick="return send_media_to_edit(this);">Edit</span></li>\
                                        <li><span class="icon-jfi-trash media-send-to-trash"></span></li>\
                                    </ul>\
                                </div>\
                            </div>\
                        </div>\
                    </li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            removeConfirmation: false,
            _selectors: {
                list: '.jFiler-item-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action',
            }
        },
        uploadFile: {
            url: site_url+'/admin/dashboard/media',
            data: {},
            type: 'POST',
            enctype: 'multipart/form-data',
            beforeSend: function(){},
            success: function(data, el){
                data = $.parseJSON(data);
                if(data.error_msg!='' && data.error_msg!=undefined){
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                        $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-check-circle\"></i> "+data.error_msg+"</div>").hide().appendTo(parent).fadeIn("slow");    
                    });
                }else if(data.success_msg!='' && data.success_msg!=undefined){
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                        $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> "+data.success_msg+"</div>").hide().appendTo(parent).fadeIn("slow");    
                    });
                    el.attr({ 'data-media': data.media_id });
                    el.attr({ 'data-src': data.media_url });

                    media_select_action();
                    send_media_to_trash();

                }             
            },
            error: function(el){
                var parent = el.find(".jFiler-jProgressBar").parent();
                el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                    $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");    
                });
                send_media_to_trash();
            },
            statusCode: {},
            onProgress: function(){},
        },
        dragDrop: {
            dragEnter: function(){},
            dragLeave: function(){},
            drop: function(){},
        },
        addMore: false,
        clipBoardPaste: false,
        excludeName: null,
        beforeShow: function(){return true},
        onSelect: function(){},
        afterShow: function(){},
        onRemove: function(e, data){
            return confirm('Are you sure want to delete?');
        },
        onEmpty: function(){},
        captions: {
            button: "Choose Files",
            feedback: "Choose files To Upload",
            feedback2: "files were chosen",
            drop: "Drop file here to Upload",
            removeConfirmation: "Are you sure you want to remove this file?",
            errors: {
                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
            }
        },
        files:files
    });




var scroll_append = true;
$('#AllMediaContainer').on('scroll', function () {
    if($('.jFiler-item-list > li').length>0){
     var scrolled_position = $('.jFiler-item-list > li').last().offset().top-500-$(this).outerHeight(true);
     //alert($('#AllMediaContainer').scrollTop());
        if($('#AllMediaContainer').scrollTop() > scrolled_position){
            if(scroll_append==true){
                scroll_append = false;
                var total_count = $('.jFiler-item-list > li').length;
                var keyword = $('#MediaKeyword').val();

                $.ajax({
                    type:'POST',
                    data:{'action':'load_more', 'count':total_count, 'keyword':keyword},
                    url:site_url+'/admin/dashboard/media/ajax',
                    success:function(response){
                        $('.jFiler-item-list').append(response);
                        scroll_append = true;
                        media_select_action();
                        send_media_to_trash();
                    }
                });
            }
        }
    }
});

    var scroll_append = true;
    $('#MediaKeyword').on('keyup', function () {
        if(scroll_append==true){
            scroll_append = false;
            var keyword = $('#MediaKeyword').val();
            $('.jFiler-item-list').html('');
            $.ajax({
                type:'POST',
                data:{'action':'load_more', 'count':0, 'keyword':keyword},
                url:site_url+'/admin/dashboard/media/ajax',
                success:function(response){
                    $('.jFiler-item-list').append(response);
                    scroll_append = true;
                    media_select_action();
                    send_media_to_trash();
                }
            });
        }
    });
    send_media_to_trash();
    media_option_init();
    media_select_action();
    clear_media_init();
});
function send_media_to_trash()
{
    $('.media-send-to-trash').each(function(){
        $(this).off();
        $(this).click(function(event){
            event.preventDefault();
           var deleting_media_id = $(this).closest('.jFiler-item');
            var media_id = deleting_media_id.data('media');
            if(media_id!=''){
                confirmed =  confirm('Are you sure want to delete this file');
                if(confirmed){
                    $.ajax({
                        type:'POST',
                        data:{'action':'trash_media', 'media_id':media_id},
                        url:site_url+'/admin/dashboard/media/ajax',
                        success:function(response){
                            response = $.parseJSON(response);
                            if(response.success_msg!='' && response.success_msg!=undefined){
                                alert(response.success_msg);
                                deleting_media_id.fadeOut('slow');
                            }else{
                                alert('Error while deleting media.');
                            }
                        }                
                    });
                }else{
                    return false;
                }
            }else{
                deleting_media_id.fadeOut('slow');
            }
        });
    });
}
function send_media_to_edit(el)
{
    var item = $(el).parent().parent().parent().parent().parent().parent();
    var alt = item.find('b').html();
    var mediaid = item.data('media');
    $('#MediaEditModal').modal('show');
    $('#MediaEditModal').find('#main_media_title').val(alt);
    $('#MediaEditModal').find('#main_media_title').attr({'value' : alt});
    $('#MediaEditModal').find('#MediaIdForEdit').val(mediaid);
    $('#MediaEditModal').find('#MediaIdForEdit').attr({'value' : mediaid});
    $('#UpdateAltInMedia').click(function(e){
        $(this).off();
        e.preventDefault();
        var data = $("#MediaEditForm").serialize();
        $.ajax({
            type:'POST',
            data:data,
            url:site_url+'/admin/dashboard/media/ajax',
            success:function(response){
                item.find('b').html(response.alt);
                item.attr({'data-src':site_url+'/'+response.folder_path+response.original_file});
                item.find('img').attr({'src':site_url+'/'+response.folder_path+response.original_file});
                $('#MediaEditModal').modal('hide');
                $('#MediaEditModal').find('#main_media_file_name').val("");
                $('#MediaEditModal').find('#main_media_file_name').attr({'value' : ""});
            }
        });
    });
    return false;
}
function on_click_media_edit(el, alt, mediaid)
{
    $('#MediaEditModal').modal('show');
    $('#MediaEditModal').find('#main_media_title').val(alt);
    $('#MediaEditModal').find('#main_media_title').attr({'value' : alt});
    $('#MediaEditModal').find('#MediaIdForEdit').val(mediaid);
    $('#MediaEditModal').find('#MediaIdForEdit').attr({'value' : mediaid});
    $('#UpdateAltInMedia').click(function(e){
        $(this).off();
        e.preventDefault();
        var data = $("#MediaEditForm").serialize();
        $.ajax({
            type:'POST',
            data:data,
            url:site_url+'/admin/dashboard/media/ajax',
            success:function(response){                
                $('#MediaEditModal').modal('hide');
                $('#MediaEditModal').find('#main_media_file_name').val("");
                $('#MediaEditModal').find('#main_media_file_name').attr({'value' : ""});
            }
        });
    });
    return false;
}

function edit_media_content(media_id)
{
    $.ajax({
        type:'POST',
        data:{'action':'edit_media', 'media_id':media_id},
        url:site_url+'/admin/dashboard/media/ajax',
        success:function(response){
            response = $.parseJSON(response);
            if(response.success_msg!='' && response.success_msg!=undefined){
                alert(response.success_msg);
                //editing_media_id.fadeOut('slow');
            }else{
                alert('Error while updating media.');
            }
        }
    });
}
function media_option_init(){
    $('.media-open').on('click', function(e){
        e.preventDefault();
        $('#MediaModal').modal('show');        
        var data_for = $(this).attr("data-for");
        var data_type = $(this).attr("data-type");
        $('#MediaModal').attr({'data-for': data_for});
        $('#MediaModal').attr({'data-type': data_type});
    });
}
function media_editor_setups(ed)
{
    ed.on('keyup', function () {
        ed.save();
    });
    ed.ui.registry.addButton('mybutton', {
        title : 'Add Image',
        icon:'image',
        onAction : function() {
            current_id = ed.id;
            $('#MediaModal').modal('show');
                media_type = $('#MediaModal').attr({'data-type' : 'editor'});
                media_for = $('#MediaModal').attr({'data-for': current_id});
            }
    });
}
function clear_media_init(){
    $('.clear-media').click(function(){
        $(this).parent().find('.media-image-content').html('');
        $(this).parent().find('input').attr({ 'value' : '' });
        $(this).parent().find('input').val('');
    });
}
function media_select_action(){
    $('#MediaModal .jFiler-item').click(function(){
        $('.jFiler-item-list > li').each(function(){
            $(this).attr({'area-checked': 'false'});
        });
        $(this).attr({'area-checked': 'true'});
    });
}
$(document).ready(function(){
$('#SelectAndInsertMedia').on('click', function(){
    var media_for   =   $('#MediaModal').attr('data-for');
    var media_id;
    var media_type  =   $('#MediaModal').attr('data-type');
    var media_src;
    var media_alt;

    $('.jFiler-item-list li').each(function(){
        if ($(this).attr('area-checked') == 'true') {
             media_id = $(this).attr('data-media');
             media_src = $(this).attr('data-src');
             media_alt = $(this).find('.jFiler-item-title b').html();
        };
    });
    if (media_type == 'editor') {
        tinymce.get(media_for).execCommand('mceInsertContent', false, '<img src="'+ media_src + '" alt="'+media_alt+'">');
    }else{
        $('#' + media_for ).attr({"value": media_id});
        $('#' + media_for + '_preview').html('<img src="' + media_src + '">');
    }
    $('#MediaModal').modal('hide');

    $('.jFiler-item-list li').each(function(){
        $(this).attr({'area-checked': 'false'});
    });
});
});
function clone(clone_id,  clone_to)
{   
    $( clone_id ).clone().appendTo("#" + clone_to).css({
        'left':'50px',
        'opacity':0
    }).animate(
        {
            'left':'0',
            'opacity' : 1
        },400,
        function(){
            change_id(clone_to);
            init_shortable();
            media_option_init();
        }
        );
    return false;
}
function clone_before(clone_id, clone_to, el)
{   
    before_content = $(el).parent();
    $("#"+clone_id + " > div").clone().insertBefore(before_content);

    change_id(clone_to);
        
    media_option_init();
    return false;
}
function delete_row(el, clone_to, parent_class)
{   
    $(el).closest('.'+parent_class).animate(
        {
            'left':'50px',
            'opacity' : 0
        },400,
        function(){
            $(this).remove();
            change_id(clone_to);
            change_id(clone_to);
            media_option_init();
        }
        );
    return false;

}
function change_id(clone_to)
{   
    var count = 1;
    var main_name = $("#"+clone_to).attr('data-name');
    var all_item  = $("#"+clone_to).attr('data-item');
    var first_item  = $("#"+clone_to).attr('data-first');
    var second_item  = $("#"+clone_to).attr('data-second');
    var third_item  = $("#"+clone_to).attr('data-third');
    var fourth_item  = $("#"+clone_to).attr('data-fourth');
    var fifth_item  = $("#"+clone_to).attr('data-fifth');
    var inside_this = $('#'+clone_to).attr('data-inside');
    if (inside_this==null) {
        inside_this = 'div';
    }

        $("#"+clone_to+" > " + inside_this).each(function(){

                $(this).attr({'data-position': count});
                $(this).find('.'+first_item).attr({'name':main_name+'['+count+']['+first_item+']'}).removeAttr('disabled');


                $(this).find('.'+second_item).attr({
                    'name':main_name+'['+count+']['+second_item+']',
                    'id'  : main_name+'_'+count+'_'+second_item
                }).removeAttr('disabled');


                $(this).find('.'+third_item).attr({'name':main_name+'['+count+']['+third_item+']'}).removeAttr('disabled');
                $(this).find('.'+fourth_item).attr({'name':main_name+'['+count+']['+fourth_item+']'}).removeAttr('disabled');
                $(this).find('.'+fifth_item).attr({'name':main_name+'['+count+']['+fifth_item+']'}).removeAttr('disabled');



                $(this).find('.media-open').attr({'data-for':main_name+'_'+count});
                $(this).find('.image-preview').attr({'id':main_name+'_'+count+'_preview'});
                $(this).find('.image_id_content').attr({'id':main_name+'_'+count});

                $(this).find('.position').attr({'data-position':count});
                $(this).find('.position').html( count );

            count=count+1;

            $('.datepicker1').removeClass('hasDatepicker');
            $('.datepicker1').removeAttr('id');
            $('.datepicker1').datepicker({ dateFormat: 'yy-mm-dd', format: 'yy-mm-dd' });
            $('.datepicker2').removeClass('hasDatepicker');
            $('.datepicker2').removeAttr('id');
            $('.datepicker2').datepicker({ dateFormat: 'yy-mm-dd', format: 'yy-mm-dd' });
        });
        clear_media_init();
}
function init_shortable() {
    $('.sortable').sortable({
    refreshPositions: true, 
    opacity: 0.6,
    cursor: 'move',
    containment: "parent",
    items: ".row-sh",
    // placeholder: 'ros-shh-contents',
    helper: 'clone',
    appendTo: 'body',
    forcePlaceholderSize: true,
    handle:'.handle',
      // axis:'y',
        distance: 15,
        update: function( event, ui ) {
            if (ui.item) {
                changed_id = $(ui.item).parent().attr("id");
                change_id(changed_id);
            }
        }
    });
}

$(document).ready(function(){
    init_shortable();
    tiny_editor_init('.E');
});

$(document).ready(function(){
    var ctnt = 0;
    $('.menu_list tbody tr').each(function(){ 
        ctnt++;
        $(this).find('.count').html(ctnt);
    });

});
$(document).ready(function(){
   
    $('select').not(".cloned").select2({
        minimumResultsForSearch: Infinity,
        width:300
    });
    $('select.withsearch').select2({
        width:300
    });
    $('select.withtags').select2({
        width:300,
        tags:true
    });
});
$('#List_Sortable').sortable({
    cursor: "move",
    items: "tr",
    helper: 'clone',
    appendTo: 'body',
    handle:'.handle',
    containment: "parent",
    forcePlaceholderSize: true,
    //axis:'y',
    update: function (event, ui) {
        var Alldata;
        var MenuData = new Array();
        
        var order_change_variable = "change_order";

        var this_id = $(ui.item).parent().attr("id");
        var this_to = $(ui.item).parent().attr("data-for");
        var this_url = $(ui.item).parent().attr("data-url");
        
        $('#'+this_id+' tr').each(function(row, tr){
            MenuData[row]={
                "order" : $(tr).find('.main_id').text()
            }    
        }); 

        Alldata = JSON.stringify(MenuData);
        var msg = '<section class="content-header"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Sucessfully Updated Menu Order</div></section>';
           $.ajax({
                type: "POST",
                url: this_url,
                data: { "action" : order_change_variable,  "AMenuData" : Alldata },
                success:function(data){
                  $("#notification-container").html(msg);
                },error:function(){ 
                    alert('error');
                }
        });
    }
});
/**
 *textarea_to_init: Textarea class to init editoe
 **/
function tiny_editor_init(textarea_to_init){
    tinymce.init({
        selector: textarea_to_init,
            height: 350,
            setup : media_editor_setups,
            relative_urls : false,
            browser_spellcheck: true,
            branding: false,
            paste_as_text: true,
            plugins: [
                'advlist pageembed autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'template paste textcolor colorpicker textpattern'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: ' media | forecolor backcolor | mybutton'
    });
}
/**
 *cloned_element_class: Item to check how much clone object in initial
 *element_to_clone: element which have to clone {{#div_id > div}}
 *appendto: id where to clone cloned object
 *textarea_class: class of the textarea to initialized tinymce editor
 *textarea_id: id for the cloned textarea
 *clone_with_editor('#cloned_container > div', '#clone_container > div', '#cloned_container', '.itinerary-detail', 'repeat')
 *Note: name of input and textarea must be like in array eg: {{detail[]}}
 */
 function uniqId() {
  return Math.round(new Date().getTime() + (Math.random() * 100));
}
function clone_with_editor(cloned_element_class, element_to_clone, appendto, textarea_class, textarea_id){
    random_textarea_id = uniqId();
    var cloned_itinerary = $(element_to_clone).clone().appendTo(appendto);
        $(cloned_itinerary).find(textarea_class).attr({'id' :  textarea_id +  random_textarea_id });
         tinymce.init({ 
            selector: '#'+textarea_id+random_textarea_id,
            setup : media_editor_setups,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | mybutton"
        });
}

/**
 *clone_object: Item to clone (element to clone to)
 *els: normally {{this}}
 *input_class: Class of the textarea for editor initialize
 *repeat_id: Id to Repeat for the textarea
 *closest_before_which: before which close element to clone
 *clone_before_with_editor('#clone_container > div', this, 'itinerary-detail', 'repeat')
 *Note: name of input and textarea must be like in array eg: {{detail[]}}
 */
function clone_before_with_editor(clone_object, els, input_class,repeat_id,closest_before_which){
    random_textarea_id = uniqId();
    before_contents = $(els).closest(closest_before_which);

    var cloned_itinerary = $(clone_object).clone().insertBefore(before_contents);
    $(cloned_itinerary).find('.'+input_class).attr({'id' :  repeat_id +  random_textarea_id });
        tinymce.init({ 
            selector: '#'+repeat_id+random_textarea_id,
            setup : media_editor_setups,
            plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | mybutton" 
        });
}
/**
 *c:normally {{this}}
 *parent_class: parent class to remove
 **/
function remove_row_with_editor(c, parent_class){
    $(c).closest('.'+parent_class).animate({
            'position':'relative',
            'left':'50px',
            'opacity' : 0
        },400,
        function(){
            $(this).remove();
        }
    );
    return false;
}
/**
 *id: Id from the database
 *module: mod_{{module_name}}
 *el: normally {{this}}
 *example:change_status("2", this, ajax_url)
 */
function change_status(id, el, ajax_url, action_s="change_status"){ 
    $.ajax({
        type:'POST',
        url: ajax_url,
        data: {"action": action_s, "post_id" : id},
        success:function(data){
            datas = jQuery.parseJSON(data);
            $(el).html(datas.contents);
        }
    });
}
$(document).ready(function() {
    $(".datepicker").bootstrapMaterialDatePicker({ 
        time: false }).on('change', function(e){
            $(this).parent('.form-line').addClass('focused');
            return true;
        }); 
        

});


$(function () {
  $('[data-toggle="popover"]').popover({
    trigger: 'hover'
  });
  $('[title]').not('[data-toggle="popover"]').tooltip();
  
    $('#link_from').change(function(){
        var data_val = $(this).val();
        $.ajax({
            type: 'post',
            data: { 'action'  : 'list_menu', 'menu_from' : data_val  },
            url: site_url+"/admin/dashboard/menu/ajax",
            success: function(data){
                $('#menu_link').html(data);
            }
        });
    });
    $('#menu_link').change(function(){
        if($(this).val() != '') { 
            var now_val = $(this).find('option:selected').html();
            now_val = now_val.split("-");
            now_val = now_val.join("");
            now_val = $.trim(now_val);
            $('#menu_title').attr({'placeholder' : now_val});
        }else{
            $('#menu_title').attr({'placeholder' : ''});
        }
    });
});
$(document).ready(function(){
   $('#link_type').change(function(){
        if ( $(this).val()  == 0 ) {
            $('#internal_link_group').slideDown("slow");
            $('#external_link_group').slideUp("slow");
        }else{
            $('#external_link_group').slideDown("slow");
            $('#internal_link_group').slideUp("slow");
        };
    });
});

/*var needToConfirm = false;

$('form').on('keyup change', 'input, select, textarea', function(){
    needToConfirm  = true;
});
window.onbeforeunload = confirmExit;
function confirmExit()
{
if (needToConfirm)
  return "message to display in dialog box";
}*/