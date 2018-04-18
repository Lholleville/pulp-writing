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



/* LIKE */
$('#like').hover(function(){
    $("#nonlike").removeClass("fa-heart-o").addClass("fa-heart");
}, function(){
    $("#nonlike").removeClass("fa-heart").addClass("fa-heart-o");
});

$('#like2').hover(function(){
    $("#nonlike2").removeClass("fa-heart-o").addClass("fa-heart");
}, function(){
    $("#nonlike2").removeClass("fa-heart").addClass("fa-heart-o");
});

$('#read').hover(function(){
    $("#nonread").removeClass("fa-eye-slash").addClass("fa-eye");
}, function(){
    $("#nonread").removeClass("fa-eye").addClass("fa-eye-slash");
});


