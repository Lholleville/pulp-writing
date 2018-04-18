<div class="form-group">
    <label for="title" class="col-sm-2 control-label">Titre du chapitre</label>
    <div class="col-sm-10">
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'title']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        {!! Form::hidden('slug', null, ['class' => 'form-control', 'id' => 'slug']) !!}
    </div>
</div>
<div class="form-group">
    <label for="POV" class="col-sm-2 control-label">Point de vue</label>
    <div class="col-sm-10">
        {!! Form::text('POV', null, ['class' => 'form-control', 'id' => 'POV']) !!}
    </div>
</div>
<div class="form-group">
    <label for="content" class="col-sm-2 control-label">Contenu du chapitre</label>
    <div class="col-sm-10">
        {!! Form::textarea('content', null, ['class' => 'form-control', 'id' => 'content']) !!}
    </div>
    <script>
        CKEDITOR.replace('content');
    </script>
</div>
@if($book !== null)
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Titre du livre</label>
        <div class="col-sm-10">
            <p class="form-control">{{ $book->name }}</p>
        </div>
    </div>
    {!! Form::hidden('book_id', $book->id) !!}
@endif
<div class="form-group">
    <label for="" class="col-sm-2 control-label">Illustration du chapitre <p>L'image se redimensionnera en 320 * 450 pixels</p></label>
    <div class="col-sm-8">
        <label for="avatar" class="img-upload">
            <div class="hover-img">
                {!! Form::file('avatar', ['class' => 'form-control', 'id' => 'avatar']) !!}
                <br>
                <p class=""><img src="{{ url('/img/icon/folder.png') }}" alt="upload" class="img-mini-rectangle"> Importer une image...</p>
            </div>
            <img src="{{ url($chapter->avatar) }}?{{time()}}" alt="your avatar" id="avatar-display" />
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
    <label for="" class="col-sm-2 control-label">
        En ligne ?
    </label>
    <div class="col-sm-10">
        {!! Form::checkbox('online', true, true) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-primary"><?= ($action == 'store') ? 'Créer' : 'Modifier'?></button>
    </div>
</div>
{!! Form::close() !!}