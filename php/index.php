<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sys Monitor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        table th {
            background-color: #4CAF50;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>System Monitor Information</h1>

    <?php
    $filePath = '/proc/sys_monitor';

    // Controlla se il file esiste ed è leggibile
    if (is_readable($filePath)) {
        // Legge il contenuto del file
        $content = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($content !== false) {
            echo "<table>";
            echo "<tr><th>Key</th><th>Value</th></tr>";

            // Processa ogni riga del file
            foreach ($content as $line) {
                // Dividi la riga in chiave e valore usando uno spazio o un tab come separatore
                $parts = preg_split('/\s+/', $line, 2);
                if (count($parts) === 2) {
                    $key = htmlspecialchars($parts[0]);
                    $value = htmlspecialchars($parts[1]);
                    echo "<tr><td>$key</td><td>$value</td></tr>";
                }
            }

            echo "</table>";
        } else {
            echo "<p class='error'>Errore durante la lettura del file $filePath.</p>";
        }
    } else {
        echo "<p class='error'>Il file $filePath non esiste o non è leggibile.</p>";
    }
    ?>
</body>
</html>
