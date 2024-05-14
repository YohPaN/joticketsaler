<div>
    <p>Bonjour,</p>
    <br>
    <p>Voici votre e-ticket pour les JO 2024: </p>
    {!! QrCode::generate($qrCode); !!}
    <br>
    <p>Bonne réception !</p>
    <p>Les organisateurs</p>
</div>
