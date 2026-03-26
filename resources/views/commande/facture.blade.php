<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $commandes->first()->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .table { w-full; border-collapse: collapse; width: 100%; }
        .table th, .table td { border-bottom: 1px solid #eee; padding: 10px; text-align: left; }
        .total { text-align: right; margin-top: 20px; font-size: 16px; font-weight: bold; }
        .footer { margin-top: 50px; font-style: italic; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE - ATELIER ARTISANAL</h1>
        <p>Client : {{ auth()->user()->name }} | Date : {{ now()->format('d/m/Y') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Article</th>
                <th>Taille</th>
                <th>Tissu</th>
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
            <tr>
                <td>{{ $commande->modele->nom }}</td>
                <td>{{ $commande->taille_choisie }}</td>
                <td>{{ $commande->tissu_choisi }}</td>
                <td>{{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        TOTAL : {{ number_format($commandes->sum('prix_total'), 0, ',', ' ') }} FCFA
    </div>

    <div class="footer">
        Référence de paiement : {{ $commandes->first()->telephone_paiement }} ({{ strtoupper($commandes->first()->operateur) }})
    </div>
</body>
</html>