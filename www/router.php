<?php
use Opt\RedmineReports\Controllers\DashboardController;
use Klein\Klein;
use Opt\RedmineReports\Controllers\ProjectController;
use Opt\RedmineReports\Controllers\SprintController;

$app = new Klein();

$app->respond('GET', '/', function ($req, $res, $service) {
    $service->render(__DIR__ . '/views/home.php', []);
});

$app->respond('/dashboard', function ($req, $res, $service) {
    $data = DashboardController::index($req->params());
    $service->render(__DIR__ . '/views/dashboard.php', $data);
});

$app->respond('GET', '/project/[:id]', function ($req, $res, $service) {
    $project = ProjectController::index($req->id);
    $service->render(__DIR__ . '/views/project_form.php', ['project' => $project]);
});

$app->respond('GET', '/sprint/[:id]?', function ($req, $res, $service) {
    $sprint = SprintController::index($req->id);
    $service->render(__DIR__ . '/views/sprint_form.php', ['sprint' => $sprint]);
});

$app->respond('POST', '/add-sprint', function ($req, $res, $service) {
    $sprint = SprintController::save($req->params());
    $res->redirect("/project/$sprint->project_id");
});

$app->respond('POST', '/delete-sprint', function ($req, $res, $service) {
    $sprint = SprintController::save($req->params());
    $res->redirect("/project/$sprint->project_id");
});

$app->dispatch();
