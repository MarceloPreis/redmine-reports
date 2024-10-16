<?php 
namespace Opt\RedmineReports\Controllers;

use Opt\RedmineReports\Models\Project;
use \Opt\RedmineReports\Models\Sprint;

class SprintController {
    
    public static function index($id) {
        if (!$id) return new Sprint();

        $sprint = Sprint::id($id);
        return $sprint;
    }
    
    public static function save($request) {
        if ($request['id'])
            return SprintController::update($request['id'], $request);

        $content = file_get_contents('./src/storage/sprints.json');
        $sprints = json_decode($content, true);
        $sprint = new Sprint($request);
        
        array_push($sprints, $sprint);

        file_put_contents('./src/storage/sprints.json', json_encode($sprints));
        return $sprint;
    }

    public static function delete($id) {
        $content = file_get_contents('./src/storage/sprints.json');
        $sprints = json_decode($content, true);
    
        foreach ($sprints as $key => $sprint) {
            if ($sprint['id'] == $id) {
                unset($sprints[$key]);
                break;
            }
        }
    
        file_put_contents('./src/storage/sprints.json', json_encode($sprints));
        return true;
    }
    
    public static function update($id, $request) {
        $content = file_get_contents('./src/storage/sprints.json');
        $sprints = json_decode($content, true);
    
        foreach ($sprints as $key => $sprint) {
            if ($sprint['id'] == $id) {
                $sprint[$key] = new Sprint($request);
            }
        }
    
        file_put_contents('./src/storage/sprints.json', json_encode($sprints));
        return true;
    }
    
}

?>