<div>
    <p>Bonjour,</p>
    <br>
    <p>Voici votre e-ticket pour les JO 2024: </p>
    <div>
        <img alt="QR Code" src="{{ $message->embedData(html_entity_decode(QrCode::format('png')->generate($qrCode)), 'QrCode.png') }}">
    </div>
    <br>
    <p>Bonne réception !</p>
    <p>Les organisateurs</p>
</div>
