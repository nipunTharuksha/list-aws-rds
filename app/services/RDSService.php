<?php

namespace App\services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class RDSService
{

    public string $id = 'rds';
    /**
     * @var array
     */
    private array $regions;
    private mixed $Client;
    private Collection $instances;

    public function __construct()
    {
        $this->Client = App::make('aws');
    }

    /**
     * @param $DBInstanceIdentifier
     * @return void
     */
    public function stop($DBInstanceIdentifier): void
    {
        $region = substr($DBInstanceIdentifier['AvailabilityZone'], 0, -1);

        $instance = $this->Client->createClient($this->id, ['region' => $region]);

        $instance->stopDBInstance([
            'DBInstanceIdentifier' => $DBInstanceIdentifier['DBInstanceIdentifier']
        ]);

    }

    /**
     * @param $DBInstanceIdentifier
     * @return void
     */
    public function start($DBInstanceIdentifier): void
    {
        $region = substr($DBInstanceIdentifier['AvailabilityZone'], 0, -1);

        $instance = $this->Client->createClient($this->id, ['region' => $region]);

        $instance->startDBInstance([
            'DBInstanceIdentifier' => $DBInstanceIdentifier['DBInstanceIdentifier']
        ]);

    }

    /**
     * @return Collection
     */
    public function instancesInStoppedState(): Collection
    {
        $this->getInstances();
        return $this->instances->where('DBInstanceStatus', 'stopped');
    }

    /**
     * @return Collection
     */
    public function getInstances(): Collection
    {
        $this->getAvailableRegions();
        $this->filterRegions();

        $this->instances = collect();

        foreach ($this->regions as $region) {
            $rds = $this->Client->createClient($this->id, ['region' => $region]);

            $clusters = $rds->DescribeDBInstances();

            if (count(collect($clusters)['DBInstances'])) {
                foreach (($clusters)['DBInstances'] as $DBInstance) {
                    $this->instances->add($DBInstance);
                }
            }
        }

        return $this->instances;

    }

    /**
     * @return array
     */
    public function getAvailableRegions(): array
    {
        /*  $client = $this->Client->createClient('rds');
          $regions = $client->describeSourceRegions();*/
        $client = $this->Client->createClient('ec2');
        $regions = $client->describeRegions();
        $this->regions = collect(collect($regions)['Regions'])->pluck('RegionName')->toArray();
        return $this->regions;
    }

    /**
     * @return void
     */
    public function filterRegions(): void
    {
        if (request()->has('region')) {
            $this->regions = collect($this->regions)->filter(fn($region) => $region === request()->get('region'))->toArray();
        }
    }

    /**
     * @return Collection
     */
    public function instancesInActiveState(): Collection
    {
        $this->getInstances();
        return $this->instances->where('DBInstanceStatus', 'available');
    }


    /**
     * @param $DBInstanceIdentifier
     * @return mixed
     */
    public function getEvents($DBInstanceIdentifier): mixed
    {
        $region = substr($DBInstanceIdentifier['AvailabilityZone'], 0, -1);

        $instance = $this->Client->createClient($this->id, ['region' => $region]);

        $events = $instance->describeEvents([
            'Duration' => 10000,
            'SourceIdentifier' => $DBInstanceIdentifier['DBInstanceIdentifier'],
            'SourceType' => 'db-instance'
        ])['Events'];

        return collect($events)->map(function($event,$index){
                return [
                    'id' => $index + 1,
                    'time' => Carbon::parse($event['Date'])->format('M d,Y g:i:A '),
                    'message' => $event['Message'],
                    'category' => Str::title($event['EventCategories'][0]),
                ];
        });

    }
}
