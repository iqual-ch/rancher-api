<?php
use Tyldar\Rancher\Rancher;
try
{
  $rancher = new Rancher("https://rancher.iqual.ch/v3/", "token-vfnf6", "klcwc249zcscjnf2shzhxf4hshrx5zs746dqrpftvv2m96n6g5mlw5");
  //echo json_encode($rancher->containers()->getAll());
  $hosts = $rancher->projects()->getAll();
  foreach($hosts as $host) {
    echo $host->id;
    echo "\n";
  }


}
catch(Exception $e)
{
  var_dump($e->getResponse()->getBody()->getContents());
}
?>