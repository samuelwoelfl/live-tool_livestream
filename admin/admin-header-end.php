</head>

<body>
    <script>
        $(document).ready(function() {

            // initialize variables for global usage
            visible = 0;
            showRGX = 1;
            isPro = 0;
            showHeading = 1;

            var $rgx = $('.rgx');
            var $heading = $('.heading_container');
            var $visibility_button = $('#toggle');
            var $checkboxes = $('input[type="checkbox"]')

            var $channel_input = $("#channel");
            var urlParams = new URLSearchParams(window.location.search);
            var url_id = urlParams.get('channel');
            if (url_id == null) {
                url_id = 1;
            }
            change_channel(url_id, "admin");
            $channel_input.val(url_id);

            // insert live data on first load to get up to date
            insert_live_data(url_id, "admin");
            // apply all the special variables - with a bit delay so the database values are safely loaded
            setTimeout(function() {
                update_visibility_button();
                update_heading($heading);
                update_RGX($rgx);
            }, 750)


            $channel_input.change(function() {
                var selectedValue = $(this).val();
                console.log("Selected value: " + selectedValue);
                change_channel(selectedValue, "admin");
            });


            // upload local data as any input values changes
            $('input:not([type=submit]), textarea').on('input', function() {
                upload_local_data($channel_input.val(), [this]);
                update_heading($heading);
                update_RGX($rgx);
            });


            $visibility_button.click(function() {
                if (visible == 1) {
                    visible = 0;
                } else {
                    visible = 1;
                }
                update_visibility_button();            
            });


            function update_visibility_button() {
                if (visible == 1) {
                    $visibility_button.text('Ausblenden');
                } else {
                    $visibility_button.text('Einblenden');
                }
                upload_local_data($channel_input.val());
            }

        });
    </script>