<?php
namespace Tyldar\Rancher\Resources;

use Tyldar\Rancher\Models\Ingress;

use Tyldar\Rancher\Inputs\InstanceConsole;

class Ingresses
{
  private $client;
  private $endpoint;

  public function __construct($client, $project_id)
  {
    $this->client = $client;
    $this->endpoint = 'project/' . $project_id . '/ingresses';
  }

  private function format($ingress, $tmp)
  {
    $tmp->set($ingress);
    return $tmp;
  }

  public function getAll()
  {
    $retn = [];

    $ingresses = $this->client->request('GET', $this->endpoint, [])->data;
    foreach($ingresses as $key=>$ingress)
    {
      if($ingress->type != "ingress")
        continue;

      array_push($retn, $this->format($ingress, new Ingress()));
    }
    return $retn;
  }

  public function get($id)
  {
    $ingress = $this->client->request('GET', $this->endpoint.'/'.$id, []);
    return $this->format($ingress, new Ingress());
  }

  public function create(Ingress $cont)
  {
    $ingress = $this->client->request('POST', $this->endpoint, $cont->toArray());
    return $this->format($ingress, new Ingress());
  }

  public function remove($id)
  {
    $ingress = $this->client->request('DELETE', $this->endpoint.'/'.$id, []);
    return $this->format($ingress, new Ingress());
  }
}
?>