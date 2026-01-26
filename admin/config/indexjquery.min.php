<script type="text/javascript">
$(document).ready(function() {

    //  Staff Login Page
    <?php if(isset($_GET['stafflogin'])){?>
    $('#stafflogin').click(function(e) {
        e.preventDefault();
        var staff_ID = $('#username').val();
        var password = $('#password').val();
        // console.log(namme + ' ' + password)

        $.ajax({
            url: 'Functions.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                "staff_ID": staff_ID,
                "password": password,
                "type": "stafflogin"
            },

            success: function(response) {
                if (response.success == 'failed') {
                    // alert(response.message);
                    $.confirm({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: response.message,
                        animation: 'scale',
                        type: 'orange'
                    })

                    // setTimeout(function() {
                    //     location.reload(true)
                    // }, 5000);
                }

                if (response.success == 'successful') {
                    // console.log(response.message);
                    // setTimeout(function() {
                    window.location = response.link
                    // }, 3000);
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    })
    <?php } ?>


    // Student Login Page
    <?php if(isset($_GET['studentlogin'])){?>
    $('#studentlogin').click(function(e) {
        e.preventDefault();
        var student_ID = $('#student_ID').val();
        var password = $('#password').val();
        // console.log(namme + ' ' + password)

        $.ajax({
            url: 'Functions.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                "student_ID": student_ID,
                "password": password,
                "type": "studentlogin"
            },

            success: function(response) {
                if (response.success == 'failed') {
                    $.confirm({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: response.message,
                        animation: 'scale',
                        type: 'orange'
                    })
                } else if (response.success == 'successful') {
                    window.location = response.link
                } else if (response.success = 'unpermitted') {
                    $.confirm({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: response.message,
                        animation: 'scale',
                        type: 'orange'
                    })
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    })
    <?php } ?>

})
</script>