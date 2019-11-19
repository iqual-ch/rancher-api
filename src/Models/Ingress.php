<?php
namespace Tyldar\Rancher\Models;

use Tyldar\Rancher\Models\AbstractModel;

class Ingress extends AbstractModel
{
  public $actions;

  public $annotations;

  public $baseType;

  public $clusterId;

  public $conditions;

  public $id;

  public $description;

  public $links;

  public $name;

  public $namespaceId;

  public $podSecurityPolicyTemplateId;

  public $state;

  public $transitioning;

  public $transitioningMessage;

  public $type;

  public $uuid;

  public $publicEndpoints;

  public $tls;

  public $projectId;

  public $rules;

}