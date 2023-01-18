<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Modules\Assignments\Entities\Assignment;
use Modules\Car\Entities\Car;
use Modules\Notes\Entities\Note;
use Modules\Referrals\Entities\Referral;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Relation::enforceMorphMap([]);

        Relation::enforceMorphMap([
            Referral::class => Referral::class,
            Car::class => Car::class,
            Note::class => Note::class,
            Assignment::class => Assignment::class,
        ]);

        Builder::macro('whereLike', function(string $column, string $search) {
            return $this->orWhere($column, 'LIKE', '%'.$search.'%');
        });

    }
}
