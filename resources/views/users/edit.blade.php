@extends('layouts.app')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Mon compte<a class="pull-right add_button"><span class="glyphicon glyphicon-eye-open"></span></a></div>
        <div class="panel-body">
            {!! Form::model($user, ['class' => 'form-horizontal', 'files' => true, 'url' => action("UsersController@update", $user), 'method' => 'PUT']) !!}
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <h2>Mes informations</h2>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-4 control-label">Pseudo</label>
                <div class="col-sm-6">
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-4 control-label">Email</label>
                <div class="col-sm-6">
                    {!! Form::email('email', null, ['class' => 'form-control', 'disabled']) !!}
                </div>
            </div>


            <div class="form-group">
                <label for="" class="col-md-4 control-label">Décrivez vous</label>
                <div class="col-sm-6">
                    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <script>
                // Replace the <textarea id="content"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('description');
            </script>
            <div class="form-group">
                <label for="" class="col-md-4 control-label">Avatar</label>
                <div class="col-sm-8">
                    <label for="avatar" class="img-upload">
                        <div class="hover-img">
                            {!! Form::file('avatar', ['class' => 'form-control', 'id' => 'avatar']) !!}
                            <br>
                            <p class=""><img src="{{ url('/img/icon/folder.png') }}" alt="upload" class="img-mini-rectangle"> Importer une image...</p>
                        </div>
                        <img src="{{ url($user->avatar) }}" alt="your avatar" id="avatar-display" />
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
                <label for="" class="col-md-4 control-label">Vous êtes ...</label>
                <div class="col-md-6">
                    <div class="radio">
                        <div class="col-sm-4"><input type="radio" name="sex" value="1" <?= ($user->sex == "Homme") ?  'checked = "checked"' : ''?>>Un homme</div>
                        <div class="col-sm-4"><input type="radio" name="sex" value="2" <?= ($user->sex == "Femme") ? 'checked = "checked"' : ''?>> Une femme</div>
                        <div class="col-sm-4"><input type="radio" name="sex" value="0" <?= ($user->sex == "Non renseigné") ? 'checked = "checked"' : ''?>> Je ne veux pas le dire</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-4 control-label">Votre date de naissance</label>
                <div class="col-sm-6">
                    {!! Form::text('birthday', null, ['class' => 'form-control form-datepicker-birthday', 'placeholder' => 'jj/mm/aaaa']) !!}
                </div>
            </div>
            <script>
                $('.form-datepicker').datepicker({
                    format : 'dd/mm/yyyy H:i:s',
                    weekStart : 1
                });

                $('.form-datepicker-birthday').datepicker({
                    format : 'dd/mm/yyyy',
                    weekStart : 1
                });
            </script>
            <div class="form-group">
                <label for="country" class="col-md-4 control-label">Pays</label>
                <div class="col-sm-6">
                    {!! Form::text('country', null, ['class' => 'form-control', 'id' => 'country']) !!}
                </div>
            </div>
            <script>
                $("#country").countrySelect({
                    preferredCountries : ['fr', 'be', 'ch', 'ca']
                });
            </script>

            <div class="form-group">
                <label for="" class="col-md-4 control-label">
                    Voulez vous vous inscrire à la newsletter ?
                </label>
                <div class="col-sm-6">
                    {!! Form::checkbox('new_letter') !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Éditer</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
