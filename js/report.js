$(document).ready(function() {
    $(".fa-flag").on("click", function(e) {
        var postId = $(e.target).parent("a").data("id");
        console.log(postId);

        $.ajax({
            method: "POST",
            url: "ajax/report.php",
            data: {
                postId: postId
            }, 
            dataType: "json"
        })
        .done(function(res) {
            console.log(res);
            if (res.status = "success") {
                $(".info li.report i").click(function() {
                    $(this).parent().find(".info li.report i").css("color", "grey");
                    $(this).css("color", "grey");
                });
            } else if (res.status = "error") {

            }
        });

        e.preventDefault();
    });
});