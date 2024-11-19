<html>
    <head>
        <title>Matrix Game</title>
    </head>
    <body>
        <h2>Matrix Game</h2>
        <form>
            User Input: <input type="number" name="matrix" step='1' value="<?php echo isset($_GET['matrix']) ? $_GET['matrix'] : ''?>"><br>
            Players: <input type="number" name="players" step='1' value="<?php echo isset($_GET['players']) ? $_GET['players'] : ''?>"><br>
            <input type="Submit" value="Start" name="submit">
            <a href="index.php"><input type="button" value="Restart"></a>
        </form>

        <?php
        if(isset($_GET['submit'])){
            $players = $_GET['players'];
            $matrix = $_GET['matrix'];
            $matrix_max = ($matrix*$matrix);
            // calculate Dice roll and players turns

            // Create coordinates
            $coordinates = ["(0)"];
            $dice_history = [];
            $player_position = [];
            $coordinate_pos = [];
            $winner_result = [];
            $win_res = 0;
            if($matrix > 1 && $players > 1){
                for ($i=0; $i < $matrix; $i++) {
                    $num = $i+1; 
                    if($num % 2){
                        for($j = 0; $j < $matrix; $j++) {
                            $coordinates[] = "($j, $i)";
                        }
                    } else {
                        for($j = $matrix-1; $j >= 0; $j--) {
                            $coordinates[] = "($j, $i)";
                        }
                    }
                }
                
                // Players and dice roll
                while ($win_res != 1) {
                    for ($i=1; $i <= $players; $i++) { 
                        $dice_roll = rand(1,6);
                        $dice_history[$i][] = $dice_roll;
                        $last_position_value = (isset($player_position[$i]) && count($player_position[$i]) > 0) ? end($player_position[$i]) : 0;
                        $update_position = $last_position_value + $dice_roll;
                        if($update_position <= $matrix_max){
                            $player_position[$i][] = $update_position;
                            $coordinate_pos[$i][] = $coordinates[$update_position];
                        } else {
                            $player_position[$i][] = $last_position_value;
                            $coordinate_pos[$i][] = $coordinates[$last_position_value];
                        }
                        if($update_position == $matrix_max){
                            $winner_result[$i] = "WINNER";
                            $win_res = 1;
                            break;
                        } else {
                            $winner_result[$i] = "LOOSE";
                        }
                    }
                }

            } else if($players <= 1) {
                // Error if players are less then 2
                echo "Players can't be less then equals to 1.";
                die();
            } else {
                // Error if Matrix is less then 2
                echo "Matrix can't be less then equals to 1.";
                die(); 
            }
            ?>
            <!-- Result Table -->
            <h3>Game Results</h3>
            <table border="1">
                <tr>
                    <th>Player No.</th>
                    <th>Dice Roll History</th>
                    <th>Position History</th>
                    <th>Coordinate History</th>
                    <th>Winner Status</th>
                </tr>
                <?php
                $num = 2;
                if(isset($players) && $players > 0){
                    for ($i=1; $i <= $players; $i++) { 
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo implode(", ", $dice_history[$i]); ?></td>
                            <td><?php echo implode(", ", $player_position[$i]); ?></td>
                            <td><?php echo implode(", ", $coordinate_pos[$i]); ?></td>
                            <td><?php echo $winner_result[$i]; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
            <?php
        }
        ?>
        
    </body>
</html>