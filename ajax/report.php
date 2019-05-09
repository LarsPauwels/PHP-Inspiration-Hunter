<?php
    require_once("../bootstrap.php");

    if (!empty($_POST)) {
        //$postId = $_POST["postId"];
        //$userId = $_SESSION["user"]["id"];
        $report = new ReportPost();
        $report->setPostId($_POST["postId"]);
        $report->setUserId($_SESSION["user"]["id"]);

        if ($report->notYetReported($_POST["postId"], $_SESSION["user"]["id"])) {
            $report->report();
            // $report->deletePost($_POST["postId"]);
            $result = [
                "status" => "success",
                "message" => "Reported post"
            ];
        } else {
            $result = [
                "status" => "error",
                "message" => "Unable to report"
            ];
        }
       
        echo json_encode($result);
    }