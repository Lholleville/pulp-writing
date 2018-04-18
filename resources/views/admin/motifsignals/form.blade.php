{!! Form::model($motif, ['class' => 'form-horizontal', 'url' => action("MotifsignalsController@$action", $motif), 'method' => $action == 'store' ? 'POST' : 'PUT' ]) !!}
<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Nom du motif</label>
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
    <label for="sousgenre" class="col-sm-2 control-label">Catégorie</label>
    <div class="col-sm-10">
        {!! Form::select('parent_group', $motif_categorie, null, ['class' => 'form-control'])  !!}
    </div>
</div>

<div class="form-group">
    <label for="sousgenre" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        {!! Form::textarea('description', null, ['class' => 'form-control'])  !!}
    </div>
</div>
@if($action == 'update')
    <div class="form-group">
        <label for="importance" class="col-sm-2 control-label">Importance</label>
        <div class="col-sm-10">
            {!! Form::select('importance',['1' => 'Mineure', '2' => 'Moyenne', '3' => 'Forte'], null, ['class' => 'form-control']) !!}
        </div>
    </div>
@endif
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-primary"><?= ($action == 'store') ? 'Créer' : 'Modifier'?></button>
    </div>
</div>
{!! Form::close() !!}