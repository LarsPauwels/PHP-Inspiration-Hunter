$(document).ready(function() {
    $("section").on("click", function(e){
        if (e.target.matches(".fa-flag")) {
            var postId = $(e.target).parent("a").data("id");
            var that = $(e.target).parent("a");

            $.ajax({
                method: "POST",
                url: "ajax/report.php",
                data: {
                    postId: postId
                }, 
                dataType: "json"
            }).done(function(res) {
                if (res.status == "success") {
                    that.addClass("reported");
                } else if (res.status == "fails") {
                    that.removeClass("reported");
                }
            });
            e.preventDefault();
        }
    });
});