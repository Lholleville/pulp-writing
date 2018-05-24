<div class="row">
    <div class="col-sm-12">
        {!! Form::model($comment, ['url' => action("CommentsController@$action", $comment), 'class' => 'form-horizontal', 'method' => $action == 'store' ? 'POST' : 'PUT']) !!}
            <div class="form-group">
                <div class="col-sm-12">
                    {!! Form::textarea('content', null, ['class' => 'form-control', 'id' => 'content']) !!}
                </div>
                <script>
                    CKEDITOR.replace('content');
                </script>
            </div>
            @if($action == 'store')
                @if($mode == 'chapter')
                    {!! Form::hidden('chapter_id', $id) !!}
                @elseif($mode == 'article')
                    {!! Form::hidden('article_id', $id) !!}
                @elseif($mode == 'concours')
                    {!! Form::hidden('text_id', $id) !!}
                @elseif($mode == 'message')
                    {!! Form::hidden('discussion_id', $id) !!}
                @elseif($mode == 'topic')
                    {!! Form::hidden('topic_id', $id) !!}
                @elseif($mode == 'journal')
                    {!! Form::hidden('journal_id', $id) !!}
                @endif
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><?= ($action == 'store') ? 'Commenter' : 'Éditer'?></button>
            </div>
        {!! Form::close() !!}
    </div>
</div>
