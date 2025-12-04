<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Prediction Report #{{ $p->id }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px
        }

        .box {
            border: 1px solid #ddd;
            padding: 12px;
            margin: 8px 0
        }
    </style>
</head>

<body>
    <h2>Prediction Report #{{ $p->id }}</h2>
    <div class="box"><strong>Predicted height:</strong> {{ number_format($p->prediction, 3) }} cm</div>
    <div class="box"><strong>Features</strong>
        <ul>
            @foreach ($p->features as $k => $v)
                <li><strong>{{ $k }}:</strong> {{ $v }}</li>
            @endforeach
        </ul>
    </div>
    <div class="box"><strong>Created at:</strong> {{ $p->created_at }}</div>
</body>

</html>
