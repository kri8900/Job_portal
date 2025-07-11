<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Top Events for You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        body {
            background-image: url(https://th.bing.com/th/id/OIP.B8SiYe2rUIYdtP2NAjkHewHaE8?rs=1&pid=ImgDetMain);
            background-size: cover;
            font-family: 'Roboto', sans-serif;
            z-index: 0.5;
        }
        .top {
            color: blue;
            padding: 10px;
            padding-right: 5rem;
            padding-left: 5rem;
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: white;
            margin: auto;
            margin-top: 2rem;
            width: fit-content;
        }

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #ffffff;
            border: 5px solid brown;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #007bff;
        }

        .card-text {
            font-size: 1rem;
            font-weight: 400;
            color: #333333;
        }

        .card-text small {
            display: block;
            margin-bottom: 5px;
            font-size: 0.875rem;
            color: #666666;
        }
    </style>
</head>

<body>
    <h1 class="text-center top">Top Events for You</h1>
    <div class="container">
        <div class="row">
            <?php
            include "config.php";
            
            $sql = "SELECT id, event_title, company_name, date, lastDate, event_type, prizes, event_description FROM events";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-4 col-md-6 col-sm-12 p-4">';
                    echo '  <div class="card">';
                    echo '    <div class="card-body">';
                    echo '      <h5 class="card-title">'.$row["event_title"].'</h5>';
                    echo '      <p class="card-text">'.$row["event_description"].'</p>';
                    echo '      <p class="card-text"><small class="text-muted">Company: '.$row["company_name"].'</small></p>';
                    echo '      <p class="card-text"><small class="text-muted">Date: '.$row["date"].'</small></p>';
                    echo '      <p class="card-text"><small class="text-muted">Last Date to Apply: '.$row["lastDate"].'</small></p>';
                    echo '      <p class="card-text"><small class="text-muted">Event Type: '.$row["event_type"].'</small></p>';
                    echo '      <p class="card-text"><small class="text-muted">Prizes: '.$row["prizes"].'</small></p>';
                    echo '      <a href="applyEvents.php?event_id='.$row["id"].'" class="btn btn-primary">Enroll Now</a>';
                    echo '    </div>';
                    echo '  </div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No events found</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</html>
