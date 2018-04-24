{!! Form::model($forum, ['class' => 'form-horizontal', 'url' => action("ForumsController@$action", $forum), 'method' => $action == 'store' ? 'POST' : 'PUT', 'files' => true]) !!}

<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Nom du forum</label>
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
    <label for="description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
    </div>
</div>
<div class="form-group">
    <label for="online" class="col-sm-2 control-label">
        En ligne ?
    </label>
    <div class="col-sm-10">
        {!! Form::checkbox('online', true, true, ['id' => 'online']) !!}
    </div>
</div>
<div class="form-group">
    <label for="collection" class="col-sm-2 control-label">Ce forum est-il relié à une collection ?</label>
    <div class="col-sm-10">
        {!! Form::select('collec_id', $collecs, null, ['class' => 'form-control', 'id' => 'collection'])  !!}
    </div>
</div>
<script>
    /*#modo.hide() dans custom.js */
    $('#collection').change(function(){
       if($('#collection option:selected').val() == "0"){
           $('#modos').show();
       }else{
           $('#modos').hide();
       }
    });
</script>
<div class="form-group" @if($action == 'store')id="modos"@else id="modos2" @endif>
    <label for="modos" class="col-sm-2 control-label">Modérateurs du forum (Laisser vide si vous indiquez une collection)</label>
    <div class="col-sm-10">
        {!! Form::select('user_id[]', $modos, $forum->users()->pluck('id', 'name'), ['class' => 'form-control', 'multiple'])  !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-primary"><?= ($action == 'store') ? 'Créer' : 'Modifier'?></button>
    </div>
</div>
{!! Form::close() !!}