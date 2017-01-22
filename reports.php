<?php
require 'inc/functions.php';

$page = "reports";
$pageTitle = "Reports | Time Tracker";
$filter = 'all';

if(!empty($_GET['filter'])){
    $filter = explode(':',filter_input(INPUT_GET,'filter',FILTER_SANITIZE_STRING));
}

include 'inc/header.php';
?>
<div class="col-container page-container">
    <div class="col col-70-md col-60-lg col-center">
        <div class="col-container">
            <h1 class='actions-header'>Reports</h1>
            <form class="form-container form-report" action="reports.php" method="get">
            <label for="filter">Filter: </label>
            <select id="filter" name="filter">
                <option value="">Select One</option>
                <optgroup label="Project">
                <?php
                    foreach(get_project_list() as $item){
                        echo '<option value="project:' . $item['project_id'] . '">';
                        echo $item['title'] . "</option> \n";
                    }
                ?>
                </optgroup>
                <optgroup label="Category">
                    <option value="category:Billable">Billable</option>
                    <option value="category:Charity">Charity</option>
                    <option value="category:Personal">Personal</option>
                </optgroup>
                <optgroup label="Date">
                    <option value="date:<?php 
                        echo date('m/d/Y',strtotime('-2 Sunday'));
                        echo ":";
                        echo date('m/d/Y',strtotime('-1 Saturday'));
                    ?>"> Last Week</option>

                      <option value="date:<?php 
                        echo date('m/d/Y',strtotime('-1 Sunday'));
                        echo ":";
                        echo date('m/d/Y');
                    ?>"> This Week</option>

                      <option value="date:<?php 
                        echo date('m/d/Y',strtotime('first day of last month'));
                        echo ":";
                        echo date('m/d/Y',strtotime('last day of last month'));
                    ?>"> Last Month</option>

                       <option value="date:<?php 
                        echo date('m/d/Y',strtotime('first day of this month'));
                        echo ":";
                        echo date('m/d/Y');
                    ?>"> This Month</option>
                </optgroup>
            </select>
            <input class="button" type="submit" value="Run"/>
            </form>
        </div>
        <div class="section page">
            <div class="wrapper">
                <table>
                <?php
               $total = $project_id = $project_total =  0;
                $tasks = get_task_list($filter);
                   foreach(get_task_list($filter) as $item){
                       if($project_id != $item['project_id']){
                            $project_id = $item['project_id'];
                            echo "<thead> \n";
                            echo "<tr> \n";
                            echo "<th> " . $item['project'] . " </th> \n";
                            echo "<th> Date </th> \n";
                            echo "<th> Time </th> \n";
                            echo "</tr> \n";
                            echo "</thead> \n";
                       }
                        $project_total += $item['time'];
                        $total += $item['time'];
                        echo "<tr>\n";
                        echo '<td>' . $item['title'] . "</td>\n";
                        echo '<td>' . $item['date'] . "</td>\n";
                        echo '<td>' . $item['time'] . "</td>\n";

                        if(next($tasks)['project_id'] != $item['project_id']){
                                echo "<tr> \n";
                                echo "<th class='project-total-label' colspan='2'>Project Total </th>";
                                echo "<th class='project-total-number'> $project_total </th> \n";
                                echo "</tr> \n";
                                $project_total = 0;

                        }
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

