$(function  () {
$(document).ready(function () {
$("ol.menu-admin").sortable({
        handle: '.menu-item-title',
        onDrop: function(item, container, _super) {
            _super(item, container);
            var index = $(item).index() + 1;
            var element_id = $(item).attr("menuitem-id");
            var parent = $(item).parents()[1];
            console.log(parent);
            var parent_id = $(parent).attr("menuitem-id");
            $.ajax({
                'type' : 'POST',
                'data' : 'menuItemUpdate=ok&id=' + element_id + '&sort='+index +'&parent='+parent_id,
                'url' : window.location.href,
                'success' : function(data){
                    console.log(data);
                    $('.menu-admin li').each(function(index,itemli){
                        var index = $(itemli).index() + 1;
                        var element_id = $(itemli).attr("menuitem-id");
                        var parent = $(itemli).parents()[1];
                        var parent_id = $(parent).attr("menuitem-id");
                        $.ajax({
                            'type' : 'POST',
                            'data' : 'menuItemUpdate=ok&id=' + element_id + '&sort='+index +'&parent='+parent_id,
                            'url' : window.location.href,
                        });
                    });
                }
            });
        },
    });
    $('.menu-item-get-settings').click(function(e){
        var parent = $(this).parents("li");
        var menu_id = parent.attr('menuitem-id');
        $('.menu-item-settings[menuitem-id='+menu_id+']').toggle();
    });
});

});