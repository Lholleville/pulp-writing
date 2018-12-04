@extends("layouts.app")

@section("content")

  <h1>Configuration</h1>

  <ul class="list-group">
      <li class="list-group-item">
          <div class="row">
              <div class="col-sm-3">
                  Nom
              </div>
              <div class="col-sm-3">
                  Active
              </div>
              <div class="col-sm-3">
                  Mode clef
              </div>
          </div>
      </li>
      @foreach($config as $conf)
          <li class="list-group-item">
              <div class="row">
                  <div class="col-sm-3">
                      {{ $conf->name }}
                  </div>
                  {!! Form::model($conf, ['class' => 'col-sm-9 form-horizontal']) !!}

                        <div class="col-sm-4 pretty p-switch p-fill">
                              {!! Form::checkbox('active', null, null, ['id' => 'active']) !!}
                              <div class="state">
                                  <label></label>
                              </div>
                          </div>

                          <div class="col-sm-4 pretty p-switch p-fill">
                              {!! Form::checkbox('keymode_enabled', null, null, ['id' => 'key']) !!}
                              <div class="state">
                                  <label></label>
                              </div>
                          </div>

                  {!! Form::close() !!}
              </div>
          </li>
          <script>
              $('#key').click(function () {
                 $.ajax({
                     url : "{{ url("admin/config/".$conf->id) }}",
                     type : "PUT"
                 });
              });
          </script>
      @endforeach
  </ul>


@endsection