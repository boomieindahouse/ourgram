<?php
    include("connect.php");
    include("functions.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/png" sizes="32px" href="/assets/favicon.ico">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/index.css">
    <link rel="stylesheet" href="/styles/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dashboard</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        #box_graph{
            height: 100%;
            width: 100%;
        }
        #box_graph > div{
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="dmenu">
        <nav>
            <li>
                <a href="/admin/dashboard">
                    <i class="fa fa-2x fa-home" aria-hidden="true"></i>

                </a>
            </li>
            <li>
                <a href="/admin/users">
                    <i class="fa fa-2x fa-user" aria-hidden="true"></i>

                </a>
            </li>
            <li>
                <a href="/admin/posts">
                    <i class="fa fa-2x fa-instagram" aria-hidden="true"></i>

                </a>
            </li>
            <li>
                <a href="/logout">
                    <i class="fa fa-2x fa-sign-out" aria-hidden="true"></i>

                </a>
            </li>
        </nav>
    </div>
    <div class="container dcontainer">
        <div class="dheader">
            <div class="dhead-lt">
                <h3>Dashboard</h3>
            </div>
            <div class="dhead-rt">
                <h5>Admin</h5>
            </div>
        </div>
        <div class="dbody">
            <div class="dbody-tp row">
                <div class="dbody-tp-lt">
                    <div class="box" id="box_graph">
                        
                    </div>
                </div>
                <div class="dbody-tp-rt">
                    <div class="box row">
                        <div class="icon">
                            <i class="fa fa-3x fa-user"></i>
                        </div>
                        <h2 class="count_users"><?php echo count_users($conn) ?></h2>
                    </div>
                    <div class="box row">
                        <div class="icon">
                            <i class="fa fa-3x fa-instagram"></i>
                        </div>
                        <h2 class="count_posts"><?php echo count_posts($conn) ?></h2>
                    </div>
                </div>
            </div>
            <div class="dbody-bt">
                <div class="box" style="background-image: url(/assets//1.jpg);"></div>
                <div class="box" style="background-image: url(/assets//2.jpg);"></div>
                <div class="box" style="background-image: url(/assets//3.jpg);"></div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        const count_users = document.querySelector(".count_users");
        const count_posts = document.querySelector(".count_posts");

      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Posts',     count_posts.innerText],
          ['Users',      count_users.innerText]
        ]);

        var options = {
          title: 'Users And Posts',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('box_graph'));
        chart.draw(data, options);
      }
    </script>
</body>

</html>