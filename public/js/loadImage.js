/**
 * Created by Loic on 03/11/2017.
 */

$('#avatar').onchange = function (e) {
    loadImage(
        e.target.files[0],
        function (img) {
            console.log(img);
            $('#avatar-display').append(img);
            $('#avatar-display').width(img.width);
            $('#avatar-display').height(img.height);
        },
        {maxWidth: 600} // Options
    );
};
