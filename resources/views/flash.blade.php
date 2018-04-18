@if(count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Oups !</strong> Il y a quelques erreurs !
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success">
        {{
            session('success')
        }}
    </div>
@endif