<?php
require 'inc/functions.php';

$page = "reports";
$pageTitle = "Reports | Time Tracker";

include 'inc/header.php';
?>
<div class="col-container page-container">
    <div class="col col-70-md col-60-lg col-center">
        <div class="col-container">
            <h1 class='actions-header'>Reports</h1>
        </div>
        <div class="section page">
            <div class="wrapper">
                <table>
                <?php
                $total = 0;
                    foreach(get_task_list() as $item){
                        $total += $item['time'];
                        echo "<tr>\n";
                        echo '<td>' . $item['title'] . "</td>\n";
                        echo '<td>' . $item['date'] . "</td>\n";
                        echo '<td>' . $item['time'] . "</td>\n";
                        echo "</tr>\n";
                    }
                ?>
                    <tr>
                        <th class='grand-total-label' colspan='2'>Grand Total</th>
                        <th class='grand-total-number'><?php echo $total; ?></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>

