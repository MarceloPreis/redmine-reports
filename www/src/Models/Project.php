<?php
namespace Opt\RedmineReports\Models;

use Opt\RedmineReports\Services\Redmine;

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
}
