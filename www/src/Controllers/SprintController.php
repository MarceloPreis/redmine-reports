<?php 
namespace Opt\RedmineReports\Controllers;

use Opt\RedmineReports\Models\Project;
use \Opt\RedmineReports\Models\Sprint;

class SprintController {
    
    public static function index($id, $request) {
        $sprint = $id ? Sprint::id($id) : new Sprint(['project_id' => $request['project_id']]);

        $sprint->loadIssues();
        return $sprint;
    }

    public static function listAll() {
        $content = file_get_contents('./src/storage/sprints.json');
        $sprints = json_decode($content, true) ?: [];
        return array_map(fn($attrs) => new Sprint($attrs), $sprints);
    } 
    
    public static function save($request) {
        if ($request['id'])
            return SprintController::update($request['id'], $request);
        
        $content = file_get_contents('./src/storage/sprints.json');
        $sprints = json_decode($content, true) ?: [];
        $sprint = new Sprint($request);
        $sprint->id = end($sprints)->id + 1;

        array_push($sprints, $sprint);

        file_put_contents('./src/storage/sprints.json', json_encode($sprints));
        return $sprint;
    }

    public static function delete($id) {
        $content = file_get_contents('./src/storage/sprints.json');
        $sprints = json_decode($content, true);
        
        foreach ($sprints as $key => $sprint) {
            if ($sprint['id'] == $id) {
                $deleted = $sprints[$key];
                $deleted['deleted'] = true;
                unset($sprints[$key]);

                file_put_contents('./src/storage/sprints.json', json_encode($sprints));
                return $deleted;
            }
        }
    
    }
    
    public static function update($id, $request) {
        $content = file_get_contents('./src/storage/sprints.json');
        $sprints = json_decode($content, true);
    
        foreach ($sprints as $key => $sprint) {
            if ($sprint['id'] == $id) {
                $sprint[$key] = new Sprint($request);
                file_put_contents('./src/storage/sprints.json', json_encode($sprints));
                
                return $sprint[$key];
            }
        }
    
    }
    
}

?>