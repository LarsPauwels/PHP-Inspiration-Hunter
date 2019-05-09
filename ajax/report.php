<?php

    require_once("../bootstrap.php");

    if (!empty($_POST)) {
        $postId = $_POST["postId"];
        $userId = $_SESSION["user"]["id"];

        var_dump($postId);
        var_dump($userId);

        $report = new ReportPost();
        $report->setPostId($postId);
        $report->setUserId($userId);

        $result = [
            "status" => "success",
            "message" => "Report was saved"
        ];

        echo json_encode($result);
    }