var $jQ = undefined;

require(["jquery"], function($){
    $jQ = jQuery.noConflict();
});

function showNewTaskInput(){
    $jQ("div[data-index='task_value'").hide();
    $jQ("select[name='task_value'").val('');
    $jQ('div[data-index="task_attribute_button"]').hide();
    $jQ('div[data-index="task_attribute_name"]').show();
}