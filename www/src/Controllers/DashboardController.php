<?php 
namespace Opt\RedmineReports\Controllers;

use Opt\RedmineReports\Models\Project;
use \Opt\RedmineReports\Models\Sprint;

class DashboardController {
    
    public static function index($request = []) {
        $opt = (object) ['sprint' => 0, ...$request];
        $project = Project::id($opt->project_id);
        $sprint = Sprint::id($opt->sprint);
        $sprint->project_id = $project->id;
        
        $sprints = Sprint::SPRINTS;
        $sprint->loadIssues();

        return ['sprintOptions' => $sprints, 'sprint' => $sprint, 'project' => $project];
    }
}

?>