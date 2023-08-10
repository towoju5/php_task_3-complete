<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="/assets/jquery-3.6.0.min.js"></script>

    <title>Task 2.</title>
    <style>
        body {
            background-color: #2cadf5;
            padding: 40px 20px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        li {
            list-style: none;
        }
        .clicks {
            color: #000;
            font-family: Inter;
            font-size: 48px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }

        .btn-primary, .btn-primary:hover {
            background: #2CADF5;
            border-radius: 0;
        }
        a:hover {
            text-decoration: none;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">


</head>

<body class="mt-10px">
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="bg-white mb-3" data-widget-name="weather-info">
                    <div class="card-body text-center">
                        <div id="weatherImage">
                            <img src="#" alt="#" id="img-weather">
                        </div>
                        <div id="weatherDegree" class="h1"></div>
                    </div>
                </div>
                <div class="bg-white p-3 mb-3" data-widget-name="numbers-of-clicks">
                    <div class="card-body">
                        <p class="text-center">Number of Clicks</p>
                        <p class="clicks text-center"" id="no_clicks"></p>
                    </div>
                </div>
                <div class="bg-white p-3 mb-3" data-widget-name="xml-export">
                    <div class="card-body">
                        <p class="text-center text-center"">Export XML</p>
                        <a href="/api/xml-export"><button class="btn btn-primary btn-lg btn-block">Export</button></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="bg-white mb-3" data-widget-name="airport-search-form">
                    <div class="card-body">
                        <input type="text" id="searchInput" class="form-control" placeholder="Dropdown autocomplete of airports">
                        <div id="autocompleteResults"></div>
                    </div>
                </div>

                <div class="bg-white mb-3" data-widget-name="openlayer-map">
                    <div class="card-body">
                        <div id="openlayer-map" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>

                <div class="bg-white mb-3" data-widget-name="artic-distance">
                    <div class="card-body">
                        <p class="text-center">Distance from Artic</p>
                        <h4 class="text-center" id="d_artic">0</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="bg-white mb-3" data-widget-name="nigeria-time">
                    <div class="card-body text-center">
                        <p>Nigeria Time</p>
                        <div class="h2" id="nigeria-time"></div>
                    </div>
                </div>
                <div class="bg-white mb-3" data-widget-name="pakistan-time">
                    <div class="card-body text-center">
                        <p>Pakistan Time</p>
                        <div class="h2" id="pakistan-time"></div>
                    </div>
                </div>

                <div class="bg-white mb-3" data-widget-name="reddit">
                    <div class="card-body">
                        <p>Reddit Widget - Top 4 Even Posts</p>
                        <?php foreach ($reddit as $post) : ?>
                            <div class="border mb-2 p-1">
                                <p><small>Posted by: <?php echo $post['data']['author']; ?></small></p>
                                <strong><?php echo $post['data']['title']; ?></strong>
                                <a href="<?php echo $post['data']['url']; ?>"><span><?= substr($post['data']['url'], 0, 15) ?></span></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="bg-white mb-3" data-widget-name="london_time">
                    <div class="card-body text-center">
                        <p>London Time</p>
                        <div class="h2" id="london-time"></div>
                    </div>
                </div>
                <div class="bg-white mb-3" data-widget-name="est_time">
                    <div class="card-body text-center">
                        <p>EST Time</p>
                        <div class="h2" id="est-time"></div>
                    </div>
                </div>
                <!-- // bills count  -->
                <div class="bg-white mb-3" data-widget-name="bill_counts">
                    <div class="card-body text-center">
                        <p class="text-center">Count # of coins</p>
                        <input type="number" class="form-control mb-3" placeholder="Enter Amount: $" step="0.01" min="0" id="amount" name="amount" required>
                        <button type="submit" class="btn btn-block btn-primary" id="calculateButton">Calculate</button>
                        <div id="bill_counts_result"></div>
                    </div>
                </div>
                <!-- // bills count  -->
                <div class="bg-white mb-3" data-widget-name="image-upload">
                    <div class="card-body text-center">
                    <?php echo form_open_multipart('welcome/image'); ?>
                        <input accept="image/*" class="form-control" hidden type='file' name="image" id="imgInp">
                        <img id="blah" src="<?= $image ?>" alt="your image" onclick="$('#imgInp').click()" width="100%" class="py-3">
                        <button class="btn btn-block btn-primary" type="submit">Upload</button>
                    <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="assets/script.js"></script>
</body>

</html>