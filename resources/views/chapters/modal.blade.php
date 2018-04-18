<div class="modal fade" tabindex="-1" role="dialog" id="annotation_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Annoter : </h4>
            </div>
            {!! Form::model($note, ['url' => action("NotesController@store"), 'class' => 'form-horizontal', 'method' => 'POST']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::textarea('content', null ,['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::select('motif_id',$motifs_annotation,null ,['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::text('chapter_id',$chapter->slug,['class' => 'form-control']) !!}
                    </div>
                    <div class="hidden">
                        <div class="col-sm-3">
                            {!! Form::text('start',null,['class' => 'form-control', 'id' => 'startPos']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('end',null,['class' => 'form-control', 'id' => 'endPos']) !!}
                        </div>
                        <div class="col-sm-12">
                            {!! Form::text('selected',null,['class' => 'form-control', 'id' => 'selected_form']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Annoter</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->