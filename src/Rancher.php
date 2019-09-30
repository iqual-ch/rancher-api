<?php
namespace Tyldar\Rancher;

use Tyldar\Rancher\Client;
use Tyldar\Rancher\Helpers;
use Tyldar\Rancher\Models\Project;
use Tyldar\Rancher\Resources\Containers;
use Tyldar\Rancher\Resources\Projects;
use Tyldar\Rancher\Resources\Services;
use Tyldar\Rancher\Resources\Hosts;
use Tyldar\Rancher\Resources\Stacks;

class Rancher
{
    private $client;

    public function __construct($url, $access, $secret, $project = "")
    {
        $this->client = new Client($url, $access, $secret, $project);
    }

    public function helpers()
    {
        return new Helpers($this->client);
    }

    public function containers()
    {
        return new Containers($this->client);
    }

    public function services()
    {
        return new Services($this->client);
    }

    public function hosts()
    {
        return new Hosts($this->client);
    }

    public function stacks()
    {
        return new Stacks($this->client);
    }

    public function projects() {
      return new Projects($this->client);
    }
}

?>