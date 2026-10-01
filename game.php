
<?php

$games = [];

if (file_exists("Games/Games.csv")) {
    $file = fopen("Games/Games.csv", "r");
    if ($file) {
        while (($row = fgetcsv($file)) !== false) {
            if (count($row) == 5) {
                $games[] = $row;
            }
        }
        fclose($file);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Game Inventory</title>
</head>
<body>
    <div class="jumbotron well ">
    
    <?php include 'includes/navigation.php'; ?>
    
    <h1>Game Inventory</h1>
    </div>
    <?php if (empty($games)): ?>
    
        <p>Arlighty all you have to do is go to the ->  INDEX <- tab and follow the steps.</p>
    
        <?php else: ?>
    <div class ="jumbotron text-center" >
            <table border="1">
            <tr>
                <th>]-Image-[</th>
                <th>  ]-Inventory Code-[  </th>
                <th>  ]-Video Game Name-[  </th>
                <th>  ]-Console-[  </th>
                <th>  ]-Price-[  </th>
            </tr>

            <?php foreach ($games as $game): ?>
            
                <tr>
                    <td>
                        <img src="uploads/<?php echo htmlspecialchars($game[4]); ?>"
                            alt="Game image"
                            width="100"
                            height="100"
                            style="object-fit: cover;">
                    </td>
                    <td><?php echo htmlspecialchars($game[0]); ?></td>
                    <td><?php echo htmlspecialchars($game[1]); ?></td>
                    <td><?php echo htmlspecialchars($game[2]); ?></td>
                    <td>$<?php echo number_format((float)$game[3], 2); ?></td>
                </tr>
            
                <?php endforeach; ?>
            </div>
        </table>

    <?php endif; ?>

</body>
</html>