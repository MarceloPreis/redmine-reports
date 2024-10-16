<?php 
namespace Opt\RedmineReports\Controllers;

use Opt\RedmineReports\Models\Project;
use \Opt\RedmineReports\Models\Sprint;

class ProjectController {
    
    public static function index($id) {
        if (!$id) return new Project([]);

        $project = Project::id($id);
        $project->loadSprints();

        return $project;
    }
}

?>