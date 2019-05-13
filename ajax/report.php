<?php
    require_once("../bootstrap/bootstrap.php");

    if (!empty($_POST)) {
        $report = new Post();
        $report->setPostId($_POST["postId"]);

        if ($report->notYetReported($_POST["postId"])) {
            $report->report();
            $report->deletePost();
            $result = [
                "status" => "success",
                "message" => "Reported post"
            ];
        } else {
            $result = [
                "status" => "error",
                "message" => "Already reported"
            ];
        }
       
        echo json_encode($result);
    }