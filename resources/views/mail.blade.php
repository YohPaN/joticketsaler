<div>
    <p>Bonjour,</p>
    <br>
    <p>Voici votre e-ticket pour les JO 2024: </p>
    <div>
        @foreach ($offers as $key => $offer)
            <h1>{{ $key }}</h1>
            @for ($i = 0; $i < count($offer); $i++)
                <img alt="QR Code" src="{{ $message->embedData(html_entity_decode(QrCode::format('png')->generate($offer[$i]->ticket_user_id)), 'QrCode-'.$key.'-'.$i.'.png') }}">
                <br>
            @endfor
        @endforeach
    </div>
    <br>
    <p>Bonne réception !</p>
    <p>Les organisateurs</p>
</div>
