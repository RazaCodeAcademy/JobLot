<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
		<title>
			JobLot | Home
		</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="{{ asset('/public/app-assets/images/ico/favicon.ico') }}" />
    </head>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .bgimg {
            background-image: url({{ asset('https://data.1freewallpapers.com/download/night-city-aerial-view-city-lights-overview-night-san-francisco-usa.jpg') }});
            height: 100%;
            background-position: center;
            background-size: cover;
            position: relative;
            color: white;
            font-family: "Courier New", Courier, monospace;
            font-size: 25px;
        }

        .topleft {
            position: absolute;
            top: 0;
            left: 16px;
        }

        .topright {
            position: absolute;
            top: 15px;
            right: 16px;
        }

        .bottomleft {
            position: absolute;
            bottom: 0;
            left: 16px;
        }

        .middle {
        position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        hr {
            margin: auto;
            width: 40%;
        }

        .btn{
            background: rgb(241,61,75);
            padding: 5px 25px 5px 25px;
            text-decoration: none;
            font-size: 22px;
            color: white;
            border-radius: 5px;
            transition: .5s linear;
        }

    </style>
    <body>

        <div class="bgimg">
        <div class="topleft">
            <img src="{{ asset('/public/app-assets/images/ico/favicon.ico') }}" style="width: 50px;height:50px">
        </div>
        <div class="topright">
            <a href="{{ route('login') }}" class="btn">Login</a>
        </div>
        <div class="middle">
            <h1>JOB LOT</h1>
            <hr>
            <p id="demo" style="font-size:30px"></p>
        </div>
        <div class="bottomleft">
            <p>JobLot</p>
        </div>
        </div>

        <script>
            // Set the date we're counting down to
            var countDownDate = new Date("Jun 10, 2021 15:37:25").getTime();

            // Update the count down every 1 second
            var countdownfunction = setInterval(function() {

                // Get todays date and time
                var now = new Date().getTime();
                
                // Find the distance between now an the count down date
                var distance = countDownDate - now;
                
                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                // Output the result in an element with id="demo"
                document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";
                
                // If the count down is over, write some text 
                if (distance < 0) {
                    clearInterval(countdownfunction);
                    document.getElementById("demo").innerHTML = "AVAILABLE";
                }
            }, 1000);
        </script>

    </body>
</html>
