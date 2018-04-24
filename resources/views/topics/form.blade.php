{!! Form::model($topic, ['class' => 'form-horizontal', 'url' => $action == 'store' ? url('forum/'.$forum->slug.'/topic/create') : url('forum/'.$forum->slug.'/topic/'.$topic->slug.'/edit') , 'method' => $action == 'store' ? 'POST' : 'PUT', 'files' => true]) !!}
<div class="form-group">
    <label for="title" class="col-sm-2 control-label">Titre du sujet</label>
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
    <label for="content" class="col-sm-2 control-label">Lancez ici votre sujet de discussion...</label>
    <div class="col-sm-10">
        {!! Form::textarea('message', null, ['class' => 'form-control', 'id' => 'content']) !!}
    </div>
    <script>
        CKEDITOR.replace('content');
    </script>
</div>
@if($action == "update")
    <div class="form-group">
        <label for="" class="col-sm-2 control-label">
            En ligne ?
        </label>
        <div class="col-sm-10">
            {!! Form::checkbox('online', true, true) !!}
        </div>
    </div>
@endif
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-primary"><?= ($action == 'store') ? 'Créer' : 'Modifier'?></button>
    </div>
</div>
{!! Form::close() !!}