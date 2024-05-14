<div>
    <p>Bonjour,</p>
    <br>
    <p>Voici votre e-ticket pour les JO 2024: </p>
    <div>
        @php
            echo '<img style="width: 300px" src="'.(new chillerlan\QRCode\QRCode)->render($qrCode).'" alt="QR Code" />';
        @endphp
    </div>
    <br>
    <p>Bonne réception !</p>
    <p>Les organisateurs</p>
</div>
