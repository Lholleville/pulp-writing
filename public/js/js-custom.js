/**
 * Created by Loic on 07/03/2018.
 */


/*DATETIMEPICKER*/

$('.form-datepicker').datepicker({
    format : 'dd/mm/yyyy H:i:s',
    weekStart : 1
});

$('.form-datepicker-birthday').datepicker({
    format : 'dd/mm/yyyy',
    weekStart : 1
});
$('#modos').hide();


$('#avatar').onchange = function (e) {
    // loadImage(
    //     e.target.files[0],
    //     function (img) {
    //         console.log(img);
    //         $('#avatar-display').append(img);
    //         $('#avatar-display').width(img.width);
    //         $('#avatar-display').height(img.height);
    //     },
    //     {maxWidth: 600} // Options
    // );

    console.log("change");
};
$('select[multiple]').select2();

$(function () {
    $('[data-toggle="tooltip"]').tooltip({
        html: true
    });
});


/*ANNOTATION SYSTEM*/




var annotationIcon = $('#annotation_icon');
annotationIcon.addClass('hidden');
var txt = $('#chapitre').text().trim();

// var chapitre = document.getElementById('chapitre');
// var list = chapitre.childNodes;
// console.log(list);
// list.forEach(function(elem){
//     if(elem.nodeName == "BR"){
//         chapitre.removeChild(elem);
//     }
// });





$('#chapitre').mouseup(function(){

    var selectedTxt = "";
    var sel = window.getSelection();
    // var ranges = [];
    //
    // for(var i = 0; i < sel.rangeCount; i++) {
    //     ranges[i] = sel.getRangeAt(i);
    // }
    if (sel){

        selectedTxt = "";
        selectedTxt = sel.toString().trim();

        if(selectedTxt != ""){
            annotationIcon.removeClass('hidden');

            $(".modal-title").html("Annoter : ")
            $(".modal-title").append(selectedTxt);


            // var start = ranges[0].startOffset;
            // var end = ranges[0].endOffset;
            //
            // if(end < 0){
            //     end = start + selectedTxt.length;
            // }

            //console.log("start : " + start + ", end : " + end);
            $("#selected_form").val(selectedTxt);
            // $("#endPos").val(end);
            // $("#startPos").val(start);
            $("#annotation_modal").on('hide.bs.modal', function(e){
                annotationIcon.addClass('hidden');
            });
        }
    }
});



/* MESSAGE */
var zone = $(".comment_zone");
var is_hidden = true;
var form_hidden = true;
zone.hide();
$("button").filter(function(){
   return this.id.match(/post_[0-9]+/);
}).click(function(e){

    var id = "#comment_" + $(this).attr('id');

    if(is_hidden){
        $(this).html("Masquer les réponses");
        $(id).show().fadeIn();
    }else{
        $(this).html("Réafficher les réponses");
        zone.hide();
    }
    is_hidden = !is_hidden;

});

$("button").filter(function(){
    return this.id.match(/form_[0-9]+/);
}).click(function(e){
    var id = "#form_" + $(this).attr('id');
    console.log(id);
    if(form_hidden){
        $(this).html("Masquer le formulaire");
        $(id).show().fadeIn();
    }else{
        $(this).html("Répondre");
        zone.hide();
    }
    form_hidden = !form_hidden;
});


/*FORUMS*/

$('#disclaimerForum').modal();

/*SCROLL DIV*/
if($('#scroll').length){
    rsSingle = new RS.RocketScroll('#scroll');
    $("#conversation_scrollable").scrollTop($("#conversation_scrollable")[0].scrollHeight);
}


/*AJAX*/

