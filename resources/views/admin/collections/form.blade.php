
{!! Form::model($collection, ['class' => 'form-horizontal', 'url' => action("CollecsController@$action", $collection), 'method' => $action == 'store' ? 'POST' : 'PUT', 'files' => true ]) !!}
<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Nom de la collection</label>
    <div class="col-sm-10">
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
    </div>
</div>
<div class="form-group">
    <label for="slug" class="col-sm-2 control-label">Slug</label>
    <div class="col-sm-10">
        {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug']) !!}
    </div>
</div>
<div class="form-group">
    <label for="" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        {{ Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) }}
    </div>
</div>
<div class="form-group">
    <label for="" class="col-sm-2 control-label">Avatar <p>L'image se redimensionnera en 800 * 350 pixels</p></label>
    <div class="col-sm-8">
        <label for="avatar" class="img-upload">
            <div class="hover-img">
                {!! Form::file('avatar', ['class' => 'form-control', 'id' => 'avatar']) !!}
                <br>
                <p class=""><img src="{{ url('/img/icon/folder.png') }}" alt="upload" class="img-mini-rectangle"> Importer une image...</p>
            </div>
            <img src="{{ url($collection->avatar) }}" alt="your avatar" id="avatar-display" />
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
    <label for="online" class="col-sm-2 control-label">
        Mettre en ligne
    </label>
    <div class="col-sm-10">
        {!! Form::checkbox('online', true, true, ['id' => 'online']) !!}
    </div>
</div>
<div class="form-group">
    <label for="primary" class="col-sm-2 control-label">
        Collection 0 ?
    </label>
    <div class="col-sm-10">
        {!! Form::checkbox('primary', null, null, ['id' => 'primary']) !!}
    </div>
</div>
<div class="form-group">
    <label for="role" class="col-sm-2 control-label">Modérateurs de la collection</label>
    <div class="col-sm-10">
        {!! Form::select('role_id[]', $modos, $collection->users()->pluck('id', 'name'), ['class' => 'form-control', 'id' => 'role', 'multiple']) !!}
    </div>
</div>

{{--<div class="form-group">--}}
    {{--<label for="sousgenre" class="col-sm-2 control-label">Sous-genre</label>--}}
    {{--<div class="col-sm-10">--}}
        {{--{!! Form::select('parent_id', $all_genres, null, ['class' => 'form-control'])  !!}--}}
    {{--</div>--}}
{{--</div>--}}
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-primary"><?= ($action == 'store') ? 'Créer' : 'Modifier'?></button>
    </div>
</div>
{!! Form::close() !!}