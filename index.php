<?php
// Configurazione iniziale
$length = isset($_POST['l']) ? (int)$_POST['l'] : 14;
if ($length < 7) $length = 7;
if ($length > 30) $length = 30;

$path_parole_base = __DIR__ . '/661562_parole_italiane';

// --- FUNZIONI DI GENERAZIONE ---
function generateStrongPassword($length = 14) {
    $sets = [
        'l' => 'abcdefghjkmnpqrstuvwxyz',
        'u' => 'ABCDEFGHJKMNPQRSTUVWXYZ',
        'd' => '23456789',
        's' => '!@#$%&*?'
    ];
    
    $password = '';
    $all = '';
    
    // Garantisce almeno un carattere per ogni set scelto
    foreach ($sets as $set) {
        $password .= $set[array_rand(str_split($set))];
        $all .= $set;
    }
    
    $all_arr = str_split($all);
    for ($i = 0; $i < $length - count($sets); $i++) {
        $password .= $all_arr[array_rand($all_arr)];
    }
    
    return str_shuffle($password);
}

function getRandomLine($base_path, $len) { 
    $filename = $base_path . '_' . $len . '_letter.txt';
    if (!file_exists($filename)) return "ErroreFile";

    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); 
    return $lines[array_rand($lines)];
} 

function upperacharacter($input) {
    $input = trim($input);
    if (empty($input)) return "";
    $arr = str_split($input);
    $idx = rand(0, count($arr) - 1);
    $arr[$idx] = strtoupper($arr[$idx]);
    return implode('', $arr);
}

function getspecials() {
    $specials = ['!', '?', '.', '_', '=', '-'];
    return $specials[array_rand($specials)];
}

/*function generateHumanPassword($length, $path_base) {
    // Calcolo lunghezza parola: totale - (2 speciali + 2 numeri + 1 speciale) = -5
    $word_len = $length - 5;
    if ($word_len < 3) $word_len = 3;

    $parola = upperacharacter(getRandomLine($path_base, $word_len));
    
    $parts = [
        $parola,
        getspecials(),
        getspecials(),
        rand(10, 99),
        getspecials()
    ];

    shuffle($parts);
    return implode('', $parts);
}*/

function generateHumanPassword($length, $path_base) {
    $parts = [];
    
    // Se la lunghezza è superiore a 19, dividiamo in due parole
    if ($length > 19) {
        // Calcoliamo lo spazio rimanente per le parole
        // Togliamo 5 caratteri (3 speciali + 2 cifre del numero rand)
        $total_words_space = $length - 5;

        // Dividiamo lo spazio in due: una parte fissa a 10 e il resto
        // (Puoi cambiare 10 con un altro numero o usare rand(5, $total_words_space - 5))
        $word1_len = 10;
        $word2_len = $total_words_space - $word1_len;

        // Recuperiamo le due parole dai rispettivi dizionari
        $parts[] = upperacharacter(getRandomLine($path_base, $word1_len));
        $parts[] = upperacharacter(getRandomLine($path_base, $word2_len));
    } else {
        // Logica standard per password fino a 19 caratteri
        $word_len = $length - 5;
        if ($word_len < 3) $word_len = 3;
        $parts[] = upperacharacter(getRandomLine($path_base, $word_len));
    }

    // Aggiungiamo i componenti comuni (3 speciali + numero a 2 cifre)
    $parts[] = getspecials();
    $parts[] = getspecials();
    $parts[] = getspecials();
    $parts[] = rand(10, 99);

    // Mescoliamo i pezzi per rendere la struttura imprevedibile
    shuffle($parts);
    
    return implode('', $parts);
}

// Generazione immediata per la visualizzazione
$pass_human = generateHumanPassword($length, $path_parole_base);
$pass_strong = generateStrongPassword($length);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generatore di Password Sicure</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h5 class="section">Generatore di Password</h5>
    <p class="description">
        Genera password sicure che non vengono memorizzate sul server. 
        Puoi scegliere tra una versione facile da ricordare (Human-friendly) o una complessa.
    </p>

    <form class="config-form" method="POST">
        <label for="l">Lunghezza desiderata (min 7 - MAX 30):</label>
        <input type="number" id="l" name="l" value="<?php echo $length; ?>" min="7" max="30">
        <button type="submit" class="btn-generate">Genera Nuove</button>
    </form>

    <div class="password-box">
        <label>Password Semplice (Italiano)</label>
        <div class="input-group">
            <input type="text" id="pass_human" value="<?php echo htmlspecialchars($pass_human); ?>" readonly>
            <button class="btn-copy" onclick="copyToClipboard('pass_human')">Copia</button>
        </div>
    </div>

    <div class="password-box">
        <label>Password Complicata (Strong)</label>
        <div class="input-group">
            <input type="text" id="pass_strong" value="<?php echo htmlspecialchars($pass_strong); ?>" readonly>
            <button class="btn-copy" onclick="copyToClipboard('pass_strong')">Copia</button>
        </div>
    </div>

    <div class="footer-links">
        by <a href="https://www.selectallfromdual.com">Dummy-X</a> | Consigliamo <a href="https://www.selectallfromdual.com/blog/286" target="_blank">KeePass</a> | 
        Sorgente su <a href="https://github.com/FrancescoCeliento/toolGenPasswordITA" target="_blank">GitHub</a>
    </div>
</div>

<script>
function copyToClipboard(id) {
    const el = document.getElementById(id);
    el.select();
    el.setSelectionRange(0, 999); // Mobile compatibility
    
    try {
        document.execCommand('copy');
        const btn = el.nextElementSibling;
        const originalText = btn.innerText;
        btn.innerText = 'Fatto!';
        btn.style.backgroundColor = '#2ecc71';
        
        setTimeout(() => {
            btn.innerText = originalText;
            btn.style.backgroundColor = '';
        }, 1500);
    } catch (err) {
        alert('Errore durante la copia');
    }
}
</script>

</body>
</html>
