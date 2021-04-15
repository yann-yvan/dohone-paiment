<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

<style>
    body {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        height: 100vh;
        font-family: "Roboto", sans-serif;
    }
    body .loader {
        display: flex;
        font-size: 2em;
    }
    body .loader .dots {
        display: flex;
        position: relative;
        top: 20px;
        left: -10px;
        width: 100px;
        -webkit-animation: dots 4s ease infinite 1s;
        animation: dots 4s ease infinite 1s;
    }
    body .loader .dots div {
        position: relative;
        width: 10px;
        height: 10px;
        margin-right: 10px;
        border-radius: 100%;
        background-color: black;
    }
    body .loader .dots div:nth-child(1) {
        width: 0px;
        height: 0px;
        margin: 5px;
        margin-right: 15px;
        -webkit-animation: show-dot 4s ease-out infinite 1s;
        animation: show-dot 4s ease-out infinite 1s;
    }
    body .loader .dots div:nth-child(4) {
        background-color: transparent;
        -webkit-animation: dot-fall-left 4s linear infinite 1s;
        animation: dot-fall-left 4s linear infinite 1s;
    }
    body .loader .dots div:nth-child(4):before {
        position: absolute;
        width: 10px;
        height: 10px;
        margin-right: 10px;
        border-radius: 100%;
        background-color: black;
        content: "";
        -webkit-animation: dot-fall-top 4s cubic-bezier(0.46, 0.02, 0.94, 0.54) infinite 1s;
        animation: dot-fall-top 4s cubic-bezier(0.46, 0.02, 0.94, 0.54) infinite 1s;
    }

    @-webkit-keyframes dots {
        0% {
            left: -10px;
        }
        20%, 100% {
            left: 10px;
        }
    }

    @keyframes dots {
        0% {
            left: -10px;
        }
        20%, 100% {
            left: 10px;
        }
    }
    @-webkit-keyframes show-dot {
        0%, 20% {
            width: 0px;
            height: 0px;
            margin: 5px;
            margin-right: 15px;
        }
        30%, 100% {
            width: 10px;
            height: 10px;
            margin: 0px;
            margin-right: 10px;
        }
    }
    @keyframes show-dot {
        0%, 20% {
            width: 0px;
            height: 0px;
            margin: 5px;
            margin-right: 15px;
        }
        30%, 100% {
            width: 10px;
            height: 10px;
            margin: 0px;
            margin-right: 10px;
        }
    }
    @-webkit-keyframes dot-fall-left {
        0%, 5% {
            left: 0px;
        }
        100% {
            left: 200px;
        }
    }
    @keyframes dot-fall-left {
        0%, 5% {
            left: 0px;
        }
        100% {
            left: 200px;
        }
    }
    @-webkit-keyframes dot-fall-top {
        0%, 5% {
            top: 0px;
        }
        30%, 100% {
            top: 50vh;
        }
    }
    @keyframes dot-fall-top {
        0%, 5% {
            top: 0px;
        }
        30%, 100% {
            top: 50vh;
        }
    }
</style>


</head>

<body>

<div class="loader">
    <div class="text">DOHONE is Loading</div>
    <div class="dots">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<form action="{{config('dohone.payInUrl')}}" method="POST" id="form" hidden>
    <input type="hidden" name="cmd" value="start"> <!--
Cette Valeur est à ne pas changer et elle est Obligatoire -->
    <input type="hidden" name="rN" value="{{$data['rN']}}"> <!-- le
nom de votre client qui effectue le paiement. c'est facultatif. -->
    <input type="hidden" name="rT" value="{{$data['rT']}}">
    <!-- Numéro Téléphone du client qui effectue le paiement (Obligatoire) -->
    <input type="hidden" name="rE" value="{{$data['rE']}}">
    <!-- Adresse email du client qui effectue le paiement. c'est facultatif. -->
    <input type="hidden" name="rH" value="{{$data['rH']}}">
    <!-- Votre Code-marchand que vous avez reçu par mail (Obligatoire) -->
    <input type="hidden" name="rI" value="{{$data['rI']}}"> <!-- Le
numéro de votre commande. Si votre système ne gère pas de numéro de commande, vous pouvez enlevez ce champs.
c'est facultatif. Mais si vous fournissez le numéro de commande, il doit être unique. Les doublons sont éjectés
du côté de DOHONE. -->
    <input type="hidden" name="rMt" value="{{$data['rMt']}}"> <!--
Montant TOTAL des achats (Obligatoire). C’est le montant qui devra être payé par votre client. Par défaut la
dévise de ce montant est l'euro, Sauf si vous précisez une autre devise sous le paramètre 'rDvs' ci-après. -->
    <input type="hidden" name="rDvs" value="{{$data['rDvs']}}"> <!-- La
devise correspondante au montant que vous avez donné. Ce paramètre est facultatif. Dans le cas où vous ne
précisez pas ce paramètre, la devise est EUR. Vous avez le choix entre 3 devises uniquement : EUR, XAF, USD -->
    <input type="hidden" name="rOnly" value="{{$data['rOnly']}}">
    <!-- Ceci est optionnel. Si vous souhaitez que votre API n’affiche que certains opérateurs, vous pouvez
    préciser ces opérateurs ici. 1=MTN, 2=Orange, 3=Express Union, 5=Visa via UBA, 10=Dohone, 14= Visa via Wari,
    15=Wari card,16=VISA/MASTERCARD, 17=YUP. -->
    <input type="hidden" name="rLocale" value="{{$data['rLocale']}}">
    <!-- le choix de la langue. fr ou en -->
    <input type="hidden" name="source" value="{{$data['source']}}">
    <!-- Le nom commercial de votre site (Obligatoire) -->
    <input type="hidden" name="endPage" value="{{$data['endPage']}}">
    <!-- Adresse de redirection en cas de SUCCESS de paiement (Obligatoire) -->
    <input type="hidden" name="notifyPage" value="{{$data['notifyPage']}}">
    <!-- Adresse de notification automatique de votre site en cas de succès de paiement -->
    <input type="hidden" name="cancelPage" value="{{$data['cancelPage']}}">
    <!-- Adresse de redirection en cas de Annulation de paiement par le client -->
    <input type="hidden" name="logo" value="{{$data['logo']}}">
    <!--une adresse url menant au logo de votre site si vous voulez voir apparaitre ce logo pendant le
    paiement (Facultatif) -->
    <input type="hidden" name="motif" value="{{$data['motif']}}">
    <!-- le motif est facultatif. Si il est précisé, il sera inscrit dans votre historique DOHONE version
    excel. Ceci peut être important pour votre comptabilité. -->
    <input type="submit" value="Valider">
</form>


<script>
    window.onload = function () {
        window.setTimeout(function () {
            document.getElementById('form').submit();
        }, 2000)
    };
</script>


</body>

</html>