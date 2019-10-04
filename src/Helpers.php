<?php
namespace Tyldar\Rancher;

use Tyldar\Rancher\Models\Ingress;
use Tyldar\Rancher\Resources\Containers;
use Tyldar\Rancher\Resources\Ingresses;
use Tyldar\Rancher\Resources\Services;

use Tyldar\Rancher\Models\Container;
use Tyldar\Rancher\Models\Service;

class Helpers
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function createContainer($name, $image, $ports)
    {
        $containers = new Containers($this->client);

        $cont = new Container();
        $cont->name = $name;

        //Eg: docker:nginx
        $cont->imageUuid = $image;

        //Eg: [30001:80/tcp]
        $cont->ports = $ports;

        $cont->secrets = [];

        //Why ?
        $cont->labels = [
            "io.label.test"=>"test",
            "io.label.test2"=>"test2"
        ];
        $cont->environment = [
            "test"=>"test"
        ];

        return $containers->create($cont);
    }

    public function createService($name, $image, $ports)
    {
        $services = new Services($this->client);

        $cont = new Container();
        $cont->name = $name;

        //Eg: docker:nginx
        $cont->imageUuid = $image;

        //Eg: [30001:80/tcp]
        $cont->ports = $ports;

        $cont->secrets = [];

        //Why ?
        $cont->labels = [
            "io.label.test"=>"test",
            "io.label.test2"=>"test2"
        ];
        $cont->environment = [
            "test"=>"test"
        ];

        $service = new Service();
        $service->name = $name;
        $service->imageUuid = $image;
        $service->launchConfig = $cont;
        $service->stackId = "1st6";
        $service->secondaryLaunchConfigs = [];

        return $services->create($service);
    }

    public function createIngress($domain_name, $namespace_id, $project_id, $host, $service_id)
    {
      $ingresses = new Ingresses($this->client, $project_id);

      $ingress = new Ingress();
      $ingress->annotations = [
        "certmanager.k8s.io/cluster-issuer"=>"letsencrypt-prod",
        "nginx.ingress.kubernetes.io/proxy-body-size"=> "100M",
        "nginx.ingress.kubernetes.io/proxy-buffer-size"=> "16K"
      ];
      $ingress->name = $domain_name . '-docker-dev-iqual-ch-ingress';
      $ingress->namespaceId = $namespace_id;
      $ingress->projectId = $project_id;
      $ingress->rules = [[
          'host' => $host,
          "paths"=> [
            [
              "serviceId"=> $service_id,
              "targetPort"=> 80,
              "type"=> "/v3/project/schemas/httpIngressPath"
            ]
          ],
          "type"=> "/v3/project/schemas/ingressRule"
        ]
      ];

      $ingress->tls->certificateId = $namespace_id . ":" . $domain_name ."-docker-dev-iqual-ch-autogen";
      $ingress->tls->hosts = [$host];

      return $ingresses->create($ingress);
    }
};