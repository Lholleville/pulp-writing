{!! Form::model($statut, ['class' => 'form-horizontal', 'url' => action("StatutsController@$action", $statut), 'method' => $action == 'store' ? 'POST' : 'PUT' ]) !!}
<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Nom du statut</label>
    <div class="col-sm-10">
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Slug</label>
    <div class="col-sm-10">
        {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'name']) !!}
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Couleur du statut</label>
    <div class="col-sm-10">
        {!! Form::text('color', null, ['class' => 'jscolor form-control', 'id' => 'name']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-primary"><?= ($action == 'store') ? 'Créer' : 'Modifier'?></button>
    </div>
</div>
{!! Form::close() !!}