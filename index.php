<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>État des sites mozfr.org</title>
    <script src="htmx.org@2.0.4.js"></script>
    <style>
        body {
            font: 1.2em sans-serif;
            color: #161618;
            text-align:center;
        }

        h1 {
            letter-spacing: 1px;
            font-weight: normal;
            color: darkmagenta;
        }

        ul {
            list-style: none;
            margin: 2em 0;
        }

        a {
            text-decoration: none;
            color: darkblue;
        }

        img {
            height: 5em;
            opacity: 1 !important;
        }

        .container {
            margin: auto;
            width: 30em;
            height: 30em;
        }

        .item {
          margin: 2em 0;
          padding: 2em;
          border: 1px solid lightgray;
          border-radius: 0.2em;
          width: 26em;
        }

        .item li {
            vertical-align: middle;
            line-height: 2em;
            padding-left: 1em;
            text-align: left;
        }

        span {
            padding-right: 0.5em
        }

        .bad {
            color: red;
        }

        .good {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>État des sites mozfr.org</h1>
        <ul class="item"  hx-get="/sites.php" hx-trigger="load">
          <img alt="Chargement en cours…" class="htmx-indicator" src="bars.svg"/>
        </ul>
    </div>
</body>
</html>