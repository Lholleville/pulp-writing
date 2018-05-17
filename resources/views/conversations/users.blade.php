<div class="col-sm-4">
    <div class="list-group">
        @foreach($users as $user)
            <a class="list-group-item text-center" href="{{ route('messagerie.show', $user->id) }}">
                <img src="{{ url($user->avatar) }}" alt="Avatar de {{ $user->name }}" class="img-extra-mini circled float-left">
                {{ $user->name }}
                @if(isset($unread[$user->id]))
                    <span class="badge badge-pill badge-danger pull-right">
                        {{ $unread[$user->id] }}
                    </span>
                @endif
            </a>
        @endforeach
    </div>
</div>
