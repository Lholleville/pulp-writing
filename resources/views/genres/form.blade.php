{!! Form::model($genre, ['class' => 'form-horizontal', 'url' => action("GenresController@$action", $genre), 'method' => $action == 'store' ? 'POST' : 'PUT' ]) !!}
<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Nom du genre</label>
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
    <label for="sousgenre" class="col-sm-2 control-label">Sous-genre</label>
    <div class="col-sm-10">
        {!! Form::select('parent_id', $all_genres, null, ['class' => 'form-control'])  !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-primary"><?= ($action == 'store') ? 'Créer' : 'Modifier'?></button>
    </div>
</div>
{!! Form::close() !!}