<?php
namespace Opt\RedmineReports\Models;

use Opt\RedmineReports\Services\RedMine;
class Project {
    public $id;
    public $name;
    public $identifier;
    public $description;
    public $status;
    public $is_public;
    public $inherit_members;
    public $created_on;
    public $updated_on;
    public $sprints;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->identifier = $data['identifier'];
        $this->description = $data['description'];
        $this->status = $data['status'];
        $this->is_public = $data['is_public'];
        $this->inherit_members = $data['inherit_members'];
        $this->created_on = $data['created_on'];
        $this->updated_on = $data['updated_on'];
    }

    public static function id($id) {
        return new self((array) (new RedMine())->project($id));
    }


    public function loadSprints() {
        $content = file_get_contents('./src/storage/sprints.json');
        $sprints = json_decode($content, true);
        
        foreach ($sprints as $sprint) {
            if ($sprint['project_id'] == $this->id) {
                $this->sprints[] = new Sprint((array) $sprint);
            }
        }
    }
}
