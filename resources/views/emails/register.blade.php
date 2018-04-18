Bonjour

Merci {{ $user->name }} pour votre inscription
Vous pouvez valider votre compte en vous rendant sur le lien
{{ url('confirm', [$user->id, $token]) }}

Merci