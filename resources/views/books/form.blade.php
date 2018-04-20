{!! Form::model($book, ['class' => 'form-horizontal', 'url' => action("BooksController@$action", $book), 'method' => $action == 'store' ? 'POST' : 'PUT', 'files' => true]) !!}
<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Titre du texte</label>
    <div class="col-sm-10">
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        {!! Form::hidden('slug', null, ['class' => 'form-control', 'id' => 'slug']) !!}
    </div>
</div>
<div class="form-group">
    <label for="sousgenre" class="col-sm-2 control-label">Genre</label>
    <div class="col-sm-10">
        {!! Form::select('genre_id', $all_genres, null, ['class' => 'form-control'])  !!}
    </div>
</div>


    <div class="form-group">
        <label for="" class="col-sm-2 control-label">Avatar <p>L'image se redimensionnera en 320 * 450 pixels</p></label>
        <div class="col-sm-8">
            <label for="avatar" class="img-upload">
                <div class="hover-img">
                    {!! Form::file('avatar', ['class' => 'form-control', 'id' => 'avatar']) !!}
                    <br>
                    <p class=""><img src="{{ url('/img/icon/folder.png') }}" alt="upload" class="img-mini-rectangle"> Importer une image...</p>
                </div>
                <img src="{{ url($book->avatar) }}" alt="your avatar" id="avatar-display" />
                <div id="zone">

                </div>
            </label>
        </div>

        <script>
            document.getElementById('avatar').onchange = function (e) {
                loadImage(
                    e.target.files[0],
                    function (img) {
                        $('#zone').empty();
                        $('#avatar-display').hide();
                        $('#zone').append(img);
                        $('#zone').width(img.width);
                        $('#zone').height(img.height);
                    },
                    {maxWidth: 600} // Options
                );
            };
        </script>
    </div>
<div class="form-group">
    <label for="" class="col-sm-2 control-label">Résumé</label>
    <div class="col-sm-10">
        {!! Form::textarea('summary', null, ['class' => 'form-control', 'id' => 'summary']) !!}
    </div>
</div>

<div class="form-group">
    <label for="tags" class="col-sm-2 control-label">Tags</label>
    <div class="col-sm-10">
        {!! Form::select('tag_id[]', $tags->pluck('name', 'id'), $book->tags()->pluck('id', 'name'), ['multiple', 'class' => 'form-control', 'id' => 'tags'] ) !!}
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-sm-offset-2 col-sm-10 pull-left">Vous ne trouvez pas le tag que vous voulez ? Créez en un nouveau puis appuyez sur espace, il se trouvera dans la liste ci-dessus</label>
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::text('', null, ['class' => 'form-control', 'id' => 'tag'] ) !!}
    </div>
</div>
<script>
    $('#tag').keydown(function(e) {
        if(e.which == "32")
        {
            var indicator = true;
            var tag = $(this).val();
            if(tag.length > "2"){
                var lasopt = $('#tags option:last-child').val();
                lasopt = parseInt(lasopt) + 1;
                var option = '<option value="'+tag+'">'+tag+'</option>';
                var tab = [];


                $('#tags option').each(function(elem){
                    tab.push($(this).text());
                });

                tab.forEach(function(elem){
                    console.log('tag = ' + tag + ' | elem = ' + elem + ' | tagmaj = ' + capitalizeFirstLetter(tag));
                    if(tag == elem || capitalizeFirstLetter(tag) == elem){
                        indicator = false;
                    }
                });
                if(indicator){
                    $('#tags').append(option);
                }
                $(this).val("");
            }
        }
    });

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
</script>
<div class="form-group">
    <label for="online" class="col-sm-2 control-label">
        En ligne ?
    </label>
    <div class="col-sm-10">
        {!! Form::checkbox('online', true, true, ['id' => 'online']) !!}
    </div>
</div>
<div class="form-group">
    <label for="statut" class="col-sm-2 control-label">Statut</label>
    <div class="col-sm-10">
        {!! Form::select('statut_id', $all_statuts, null, ['class' => 'form-control'])  !!}
    </div>
</div>
<div class="form-group">
    <label for="statut" class="col-sm-2 control-label">Ce texte est il la suite d'un des textes suivants ?</label>
    <div class="col-sm-10">
        {!! Form::select('parent_id', $my_books, null, ['class' => 'form-control'])  !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-primary"><?= ($action == 'store') ? 'Créer' : 'Modifier'?></button>
    </div>
</div>
{!! Form::close() !!}