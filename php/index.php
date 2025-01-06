


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
        .boxalert {

            background-color: orange;
            border:1px solid red;
            color:black;
            font-size:1.4rem;
            font-weight: bold;
            width:100%;
            height:100px;

        }
        .title {
            text-align:center;
        }
    </style>
     <script>
   window.setTimeout( function() {
  window.location.reload();
}, 5000);
</script>
</head>
<body>
   
    <h1 class="title">System Monitor</h1>
    <hr>

    <?php
    $filePath = '/proc/sys_monitor';
    $text="";

    // Controlla se il file esiste ed è leggibile
    if (is_readable($filePath)) {
        // Legge il contenuto del file
        $content = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $message="";
        ?>
      
        <?php
        $alert="";
        if ($content !== false) {
            $text.= "<table>";
            $text.= "<tr><th>Key</th><th>Value</th></tr>";

            // Processa ogni riga del file
            foreach ($content as $line) {
                if (str_contains($line, 'ALERT')) {
                    $alert.=$line."<br><br>";
                    continue;
                }
                $parts = preg_split('/\s+/', $line, 2);
                if (count($parts) === 2) {
                    $key = htmlspecialchars($parts[0]);
                    $value = htmlspecialchars($parts[1]);
                    $text.= "<tr><td>$key</td><td>$value</td></tr>";
                }
            }

            $text.= "</table>";
        } else {
            echo "<p class='error'>Errore durante la lettura del file $filePath.</p>";
        }
    } else {
        echo "<p class='error'>Il file $filePath non esiste o non è leggibile.</p>";
    }
    if (empty($alert))
      $alert="No alert message.";
    ?>
      <div class="boxalert">
           <?= $alert;?>

    </div>
    <div>
<?= $text;?>

    </div>
</body>
</html>
