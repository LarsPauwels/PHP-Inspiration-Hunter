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
            dataType: "text"
        })
        .done(function(res) {
            console.log(res);
        });

        e.preventDefault();
    });
});