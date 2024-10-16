<?php 
namespace Opt\RedmineReports\Controllers;

use Opt\RedmineReports\Models\Project;
use \Opt\RedmineReports\Models\Sprint;

class DashboardController {
    
    public static function index($request = []) {
        $opt = (object) ['sprint' => 1, ...$request];
        $project = Project::id($opt->project_id);
        $project->loadSprints();
        
        $sprint = Sprint::id($opt->sprint);
        $sprint->loadIssues();

        return ['sprint' => $sprint, 'project' => $project];
    }
}

?>