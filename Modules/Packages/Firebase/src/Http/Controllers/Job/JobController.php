<?php

namespace Callkruger\Api\Http\Controllers\Job;

use Callkruger\Api\Http\Controllers\Controller;
use Callkruger\Api\Manager;
use Illuminate\Support\Arr;
use Kreait\Firebase\Database;

class JobController extends Controller {

    /**
     * JobController constructor.
     */
    public function __construct ()
    {
    }

    public function index ()
    {
        dump(callkruger('users')->sync(75));
        //callkruger('jobs')->sync(8841, FALSE);
    }

    public function index22 ()
    {
        callkruger()->sync(NULL, FALSE, 'subscribe');
        //callkruger('jobs')->sync(8841, FALSE);
    }

    public function index3 (Manager $manager, Database $database)
    {

        $provider = api_provider('reports');

        /*        $model = new \ReflectionClass(data_get($provider, 'model'));
                $model = $model->newInstance();

                $data       = $model->find(54);*/

        $network = collect($this->data())->serialize($provider, 'network');
        $local   = collect($network)->serialize('reports');

        dump($network, $local);

        return;

        callkruger('reports')->sync(NULL, FALSE, 'retrieve');

        return;

        $provider = api_provider('jobs');

        $model = new \ReflectionClass(data_get($provider, 'model'));
        $model = $model->newInstance();

        $data = $model->find(8307);

        dump($data->toArray());

        return;
        dump(callkruger('jobs')->sync(6470));

        return;

        $provider = api_provider('reports');
        $model    = new \ReflectionClass(data_get($provider, 'model'));
        $model    = $model->newInstance();

        /*        $resource = collect($this->data())->serialize('reports', 'network');*/
        $data = $model->find(53)->update([]);
        dump($data);

        $data2 = $model->actionTable()->find(53);
        dump($data2);

        return;
        /*        $data = $model->create($resource);*/
    }

    public function index2 (Manager $manager, Database $database)
    {

        dump(callkruger('jobs')->sync(6470));

        return;

        $provider = api_provider('reports');

        $model = new \ReflectionClass(data_get($provider, 'model'));
        $model = $model->newInstance();

        $data = $model->find(53);

        /*        $collection = collect($this->data())->serialize('reports', 'network');
                $model->create($collection);*/

        dump($data->toArray());

        return;

        /*        $provider   = api_provider('reports');

                $model = new \ReflectionClass(data_get($provider, 'model'));
                $model = $model->newInstance();

                $data = $model->whereIn('id', [1,2,3,4,5])->get();

                return;*/

        $credentials = [
            'username' => 'michelvieira@outlook.com',
            'password' => '123456'
        ];

        $manager->auth2('reports')->login($this->data());

        return;
        $data = $this->data();

        $provider   = api_provider('reports');
        $attributes = data_get($provider, 'attributes');
        $attributes = collect(Arr::dot($attributes));

        $casts = data_get($provider, 'casts');

        $model = new \ReflectionClass(data_get($provider, 'model'));
        $model = $model->newInstance();

        /*        $resource = $attributes->map(function ($field, $id) use ($data, $casts) {
                    $cast = data_get($casts, $id ?? $field);
                    $col  = data_get($data, $field) ?? NULL;
                    $col  = $this->casts($col, $cast, $id);

                    return is_string($col) ? trim($col) : $col;
                });*/

        $filters = data_get($provider, 'filters');

        /*        $saveNetwork = collect($model->find(5))->serialize('reports');*/
        $saveLocal = collect($data)->serialize('reports', TRUE);
        $flight    = $model->updateOrCreate(collect($saveLocal)->only($filters)->all(), collect($saveLocal)
            ->except($filters)->all());
        /*        dump($flight->tarpSize()->delete());
                dump($flight->tarpSize()->createMany($saveLocal['tarp_size']));*/
        dump($saveLocal);
        /*        dump($flight->tarpSize()->delete());
                dump($flight->tarpSize()->createMany($saveLocal['tarp_size']->all()));*/ /*



dump($create, $update);

$flight = $model->updateOrCreate($update, $create);*/ /*
                $attributes->map(function ($value, $key) use ($data, $casts) {
                    dump($key);
                });*/

        /*        $create = $resource->except($filters)->all();
                $update = $resource->only($filters)->all();

                $flight = $model->updateOrCreate(
                    $update,
                    $create
                );*/

        /*        $model->create($resource);*/

        return;
        /*        $test = $manager->where(['id' => 6468])->orWhere(['id' => 6468])->sync(true);*/
        /*        $test = $manager->provider('jobs')->sync(6468);*/
        $test = $manager->sync();
        dump($test);

        /*        $manager->retrieve();
                dump('');*/

        return;
        /*        $manager->syncAll();
                dump('teste');
                return;*/

        /*        $manager->syncAll();
                return;*/

        $attributes = collect(api_provider('pictures')['attributes']);
        $model      = app(\Callkruger\Api\Models\Admin\Picture::class);

        $reference = $database->getReference('pictures');
        $filter    = $reference->orderByKey()->limitToFirst(10);

        $values = $filter->getValue();

        $dot = collect(Arr::dot($attributes->flip()));

        if ( $values ) {
            foreach ( $values as $key => $value ) {
                $save = $dot->map(function ($col) use ($value) {
                    return $value[$col] ?? NULL;
                })->all();
                $model->create($save);
                $reference->getChild($key)->remove();
            }
        }
        dump('teste');

        /*        dump(collect($snapshot->getChild('7631')->getReference()->orderByKey()->startAfter('MctQOqZN5d9ovOsz2FQ')->getSnapshot()));
                */ /*        $child = $reference->orderByChild('status')->equalTo('uploading')->getSnapshot();*/ /*        $child = $reference;

                $database->runTransaction(function (Transaction $transaction) use ($reference, $columns, $model) {

                    $dot    = collect(Arr::dot($columns->flip()));
                    $values = collect($reference->getValue());

                    if ( $values->count() ) {

                        $values->each(function ($item) use ($dot, $model) {
                            $save = $dot->map(function ($col) use ($item) {
                                return $item[$col] ?? NULL;
                            })->all();

                            $model->create($save);
                        });

                        $transaction->snapshot($reference);
                        $transaction->remove($reference);
                    }
                });*/

        /*        $manager->sync('jobs', '6468', true);
                dump('teste');*/

        /*        $job      = Job::first();
                $provider = api_provider('jobs');
                $fields   = collect(api_provider('jobs')['columns']);

                $dot  = collect(Arr::dot($fields));
                $data = $dot->map(function ($db, $api) use ($job) {
                    $data = $job[$db];

                    return is_string($data) ? trim($data) : $data;
                });

                dump(undot($data));*/

        /*$fields->mapWithKeys(function($item, $key){
            if ( is_array($item) ) {
                dump($item);
            }
        });*/

        /*        $manager->sync('jobs', '6470', true);
                return;
                //return Job::all();*/
        /*        $listJobs = JobResource::collection(Job::status()->notSynced()->get())->jsonSerialize();
                if($listJobs){
                    foreach ($listJobs as $job){
                        $manager->sync('jobs', $job['job_id']);
                    }
                }*/
    }

    protected function data ()
    {
        return [
            "job_id"   => 8336,
            "job_type" => 1,
            "report"   => [
                "checklist"      => [
                    [
                        "name"  => "tarp_alterations",
                        "value" => 1
                    ],
                    [
                        "name"  => "height_accommodation",
                        "value" => 1
                    ]
                ],
                "elements"       => [
                    "infos"    => "test off ",
                    "pitch"    => 8,
                    "sandbags" => "13"
                ],
                "fields"         => [
                    [
                        "name"  => "sandbags",
                        "value" => "13"
                    ],
                    [
                        "name"  => "infos",
                        "value" => "test off "
                    ],
                    [
                        "name"  => "pitch",
                        "value" => 8
                    ]
                ],
                "report_options" => [1, 5],
                "tarp_size"      => [
                    [
                        "height"   => "30",
                        "quantity" => "1",
                        "stock"    => 1,
                        "width"    => "20"
                    ]
                ],
                "workers"        => [1, 21]
            ]
        ];

        return [
            "id"       => 1,
            "job_id"   => 6453,
            "job_type" => 2,
            "report"   => [
                "checklist"      => [
                    ["name" => "height_accommodation", "value" => 1],
                    ["name" => "tarp_alterations", "value" => 0]
                ],
                "elements"       => [
                    "infos"    => "Teste",
                    "sandbags" => "203"
                ],
                "fields"         => [
                    ["name" => "sandbags", "value" => "203"],
                    ["name" => "infos", "value" => "Teste"]
                ],
                "report_options" => [13, 3, 16],
                "tarp_size"      => [
                    ["height" => "34", "quantity" => "1", "stock" => 1, "width" => "450"],
                    ["height" => "2", "quantity" => "3", "stock" => 4, "width" => "1"]
                ],
                "workers"        => [7, 15]
            ]
        ];
    }

}
