<div>
    <p>Bonjour,</p>
    <br>
    <p>Voici votre e-ticket pour les JO 2024: </p>
    {!! DNS2D::getBarCodeHTML($qrCode, 'QRCODE') !!}
    <br>
    <p>Bonne réception !</p>
    <p>Les organisateurs</p>
</div>
