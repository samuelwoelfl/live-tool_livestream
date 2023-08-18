</head>

<body>
    <script> 
        $(document).ready(function() {

            var $message = $('.message');
            var $rgx = $('.rgx');
            var $heading = $('.heading_container');

            var urlParams = new URLSearchParams(window.location.search);
            var url_id = urlParams.get('channel');
            if (url_id == null) {
                url_id = 1;
            }
            console.log(url_id);

            // initialize variables for global usage
            visible = 0;
            showRGX = 1;
            isPro = 0;
            showHeading = 1;

            // update the page with the live data in the given interval
            setInterval(function () {
                insert_live_data(url_id, "stream");

                // show or hide message
                if (visible == 1) {
                    $message.slideDown('slow');
                } else if (visible == 0) {
                    $message.slideUp('slow');
                }

                update_heading($heading);
                update_RGX($rgx);
                
            }, 1000); // request every 1 seconds

        });
    </script>