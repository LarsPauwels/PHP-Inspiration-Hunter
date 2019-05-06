$(document).ready(function() {
    $(".fa-flag").on("click", function(e) {
        var postId = $(e.target).parent("a").data("id");
        console.log(postId);

        e.preventDefault();
    });
});