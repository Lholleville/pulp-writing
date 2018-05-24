<div class="row">
    <div class="col-sm-12">
        <h2>Mon journal</h2>


        <div class="diary">
            @foreach($user->journals as $post)
                <p>{!! $post->content !!}</p>
                <hr>
                @foreach($post->comments as $comment)
                    <p>{!! $comment->content !!}</p>
                @endforeach
                <div class="col-sm-6">
                    @include('comments.form', ['action' => 'store','id' => $post->id, 'mode' => 'journal'])
                    {{--<form action="{{ action('CommentsController@create', $comment) }}" method="POST" class="form-horizontal">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="" class="control-label">--}}
                                {{--Votre réponse...--}}
                            {{--</label>--}}
                            {{--<textarea name="content" id="content" class="form-control"></textarea>--}}
                        {{--</div>--}}
                        {{--<input type="hidden" name="journal_id" value="{{ $post->id }}">--}}
                        {{--<div class="form-group">--}}
                            {{--<button type="submit" class="btn btn-primary">Envoyer</button>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                </div>
            @endforeach
        </div>
    </div>
</div>
