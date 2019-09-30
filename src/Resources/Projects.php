<?php
namespace Tyldar\Rancher\Resources;

use Tyldar\Rancher\Models\Project;

use Tyldar\Rancher\Inputs\InstanceConsole;

class Projects
{
  private $client;
  private $endpoint;

  public function __construct($client)
  {
    $this->client = $client;
    $this->endpoint = 'projects';
  }

  private function format($project, $tmp)
  {
    $tmp->set($project);
    return $tmp;
  }

  public function getAll()
  {
    $retn = [];

    $projects = $this->client->request('GET', $this->endpoint, [])->data;
    foreach($projects as $key=>$project)
    {
      if($project->type != "project")
        continue;

      array_push($retn, $this->format($project, new Project()));
    }
    return $retn;
  }

  public function get($id)
  {
    $project = $this->client->request('GET', $this->endpoint.'/'.$id, []);
    return $this->format($project, new Project());
  }

  public function create(Project $cont)
  {
    $project = $this->client->request('POST', $this->endpoint, $cont->toArray());
    return $this->format($project, new Project());
  }

  public function remove($id)
  {
    $project = $this->client->request('DELETE', $this->endpoint.'/'.$id, []);
    return $this->format($project, new Project());
  }
}
?>