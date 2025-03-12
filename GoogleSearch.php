<?php
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = urlencode($_GET['search']);

    $apiKey = 'AIzaSyC1h6lhYKWGap20WoAHFKtyKHwUApjAqos';
    $cx = '23c632b2727ea4586';
    $url = "https://www.googleapis.com/customsearch/v1?key={$apiKey}&cx={$cx}&q={$search}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $items = json_decode($response, true);
    $items = isset($items['items']) ? $items['items'] : [];
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пошук Google</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .result {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin: 10px auto;
        }

        .result a {
            color: #007BFF;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }

        .result p {
            font-size: 14px;
            color: #555;
        }

        .no-results {
            color: #888;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>

<h2>Пошук Google</h2>

<form method="GET">
    <label for="search">Пошук:</label>
    <input type="text" id="search" name="search" required placeholder="Введіть запит для пошуку">
    <button type="submit">Шукати</button>
</form>

<?php if (!empty($items)): ?>
    <h2>Результати:</h2>
    <?php foreach ($items as $item): ?>
        <div class="result">
            <a href="<?php echo htmlspecialchars($item["link"]); ?>" target="_blank">
                <?php echo htmlspecialchars($item["title"]); ?>
            </a>
            <p><?php echo htmlspecialchars($item["snippet"]); ?></p>
        </div>
    <?php endforeach; ?>
<?php elseif (isset($_GET['search'])): ?>
    <p class="no-results">На жаль, за вашим запитом нічого не знайдено.</p>
<?php endif; ?>

</body>
</html>
