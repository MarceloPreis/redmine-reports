<?php
use Opt\RedmineReports\Controllers\DashboardController;
use Klein\Klein;
use Opt\RedmineReports\Controllers\ProjectController;
use Opt\RedmineReports\Controllers\SprintController;

$app = new Klein();

$layout = function($service) {
    $service->layout(__DIR__ .  '/views/layout.php');
};

$app->respond('GET', '/', function ($req, $res, $service) use ($layout) {
    $layout($service);
    $service->render(__DIR__ . '/views/home.php', []);
});

$app->respond('/dashboard', function ($req, $res, $service) use ($layout) {
    $data = DashboardController::index($req->params());
    $layout($service);
    $service->render(__DIR__ . '/views/dashboard.php', $data);
});

$app->respond('GET', '/project/[:id]', function ($req, $res, $service) use ($layout) {
    $project = ProjectController::index($req->id);
    $layout($service);
    $service->render(__DIR__ . '/views/project_form.php', ['project' => $project]);
});

$app->respond('GET', '/sprint/[:id]?', function ($req, $res, $service) use ($layout) {
    $sprint = SprintController::index($req->id, $req->params());
    $layout($service);
    $service->render(__DIR__ . '/views/sprint_form.php', ['sprint' => $sprint]);
});

$app->with('/api', function() use ($app) {
    $app->respond('POST', '/sprint', function ($req, $res,) {
        $sprint = SprintController::save($req->params());
        $res->redirect("/project/$sprint->project_id");
    });
    
    $app->respond('POST', '/sprint/[:id]/delete', function ($req, $res, $service) {
        ds('ASFD');
        $sprint = SprintController::delete($req->id, $req);
        $res->json(['status' => 'success', 'data' => $sprint]);
    });
});

$app->dispatch();
