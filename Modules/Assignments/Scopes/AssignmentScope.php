<?php

namespace Modules\Assignments\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AssignmentScope {

    public function scopeOfStatus(Builder $query, $status = [1, 11, 12, 17])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeOpen(Builder $query,
        $status = [1, 2, 3, 4, 8, 11, 12, 14, 15, 17, 18, 19, 20, 21, 22, 23, 28, 14, 29, 27, 33, 34, 35, 37,38,39])
    {

        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeRequestDocusign(Builder $query, $status = [29])
    {

        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeDocusignSent(Builder $query, $status = [14])
    {

        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeMessageSent(Builder $query, $status = [28])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeNojobs(Builder $query, $status = [8])
    {

        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeMessages(Builder $query, $status = [1])
    {

        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeReadytobill(Builder $query, $status = [4])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeRevisebill(Builder $query, $status = [24])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeRevisetree(Builder $query, $status = [6, 5, 9, 10, 24,], $job_type = 11)
    {
        return $query
            ->with('job_types')
            ->whereHas('job_types', function(Builder $q) use ($job_type) {
                if ($job_type != NULL) {
                    $q->whereIn('assignment_job_type_id', [$job_type]);
                }
            })
            ->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeCollection(Builder $query,
        $status_collection = [2, 3, 4, 5, 6, 9, 11, 19, 21, 22, 23, 24, 25, 26, 27, 28, 29], $status = [5, 9, 10, 24])
    {
        return $query
            ->whereIn('status_collection_id', collect($status_collection))->whereNotNull('id')
            ->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeFollowup60(Builder $query, $status = [5, 9, 10, 24])
    {
        return $query
            ->with('finance')
            ->where('collection.days_from_billing', '<', 60)
            ->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeLandline(Builder $query, $status = [30])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeLate(Builder $query, $status = [27])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeThig(Builder $query, $status = [31])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeUniv(Builder $query, $status = [32])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeCleanUp(Builder $query, $status = [34, 35])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeSchedJobs(Builder $query, $date, $status = [2, 3, 4, 5, 8, 7, 20])
    {
        return $query
            ->with('scheduling')
            ->whereHas('scheduling', function(Builder $q) use ($date) {
                $q->whereDate('start_date', $date);
            })->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeTextJobs(Builder $query, $date, $status = [2])
    {
        return $query
            ->with('scheduling')
            ->whereHas('scheduling', function(Builder $q) use ($date) {
                $q->whereDate('start_date', $date);
            })->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeSearchtop(Builder $query, $search)
    {
        return $query
            ->when($search, function($query, $search) {
                $query
                    ->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('id', 'like', '%'.$search.'%')
                    ->orWhere('claim_number', 'like', '%'.$search.'%');
            });
    }

    public function scopeSearch(Builder $query, $search)
    {

        $search = trim($search);

        return $query
            ->when($search, function($query, $search) {
                $query
                    ->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('id', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('street', 'like', '%'.$search.'%')
                    ->orWhere('city', 'like', '%'.$search.'%')
                    ->orWhere('state', 'like', '%'.$search.'%')
                    ->orWhere('zipcode', 'like', '%'.$search.'%')
                    ->orWhere('claim_number', 'like', '%'.$search.'%')
                    ->orWhere->searchTerms($search, 'city')
                    ->orWhere->searchUsers($search)
                    ->orWhere->searchReferral($search)
                    ->orWhere->searchPhones($search)
                    ->orWhere->searchStatus($search);
            });
    }

    public function scopeSearchTerms(Builder $query, $search, $field) {}

    public function scopeSearchUsers(Builder $query, $search)
    {
        return $query
            ->whereHas('user_created', function(Builder $q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            });
    }

    public function scopeSearchReferral(Builder $query, $search)
    {
        return $query
            ->with(['referral', 'carrier'])
            ->whereHas('referral', function(Builder $q) use ($search) {
                $q->where('company_entity', 'like', '%'.$search.'%');
            })
            ->orWhereHas('carrier', function(Builder $q) use ($search) {
                $q->where('company_entity', 'like', '%'.$search.'%');
            });
    }

    public function scopeSearchPhones(Builder $query, $search)
    {
        return $query
            ->with('phones')
            ->whereHas('phones', function(Builder $q) use ($search) {
                $q->where('phone', 'like', '%'.$search.'%');
            });
    }

    public function scopeSearchStatus(Builder $query, $search)
    {
        return $query
            ->whereHas('status', function(Builder $q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            });
    }

    public function scopeDateSchedulled(Builder $query, $date_from, $date_to, $tech_id = NULL, $job_type = NULL)
    {
        return $query
            ->with('scheduling')
            ->with('job_types')
            ->whereHas('scheduling', function(Builder $q) use ($tech_id) {
                if ($tech_id != NULL) {
                    $q->where('tech_id', '=', $tech_id);
                }
            })
            ->whereHas('job_types', function(Builder $q) use ($job_type) {
                if ($job_type != NULL) {
                    $q->whereIn('assignment_job_type_id', [$job_type]);
                }
            })
            ->whereHas('scheduling', function(Builder $q) use ($date_from) {
                $q->whereDate('start_date', '>=', $date_from);
            })
            ->whereHas('scheduling', function(Builder $q) use ($date_to) {
                $q->whereDate('start_date', '<=', $date_to);
            });
    }

    public function scopeDateSchedulledWorker(Builder $query, $date_from, $date_to, $tech_id = NULL, $job_type = NULL)
    {
        return $query
            ->with('scheduling')
            ->with('job_types')
            ->whereHas('workers', function(Builder $q) use ($tech_id) {
                if ($tech_id != NULL) {
                    $tech_id = is_array($tech_id) ? $tech_id : [$tech_id];
                    $q->whereIn('worker_id', $tech_id);
                }
            })
           ->whereHas('job_types', function(Builder $q) use ($job_type) {
                if ($job_type != NULL) {
                    $job_type = is_array($job_type) ? $job_type : [$job_type];
                    $q->whereIn('assignment_job_type_id', $job_type);
                }
            })
            ->whereHas('scheduling', function(Builder $q) use ($date_from, $date_to) {
                $q->whereDate('start_date', '>=', $date_from)
                  ->whereDate('start_date', '<=', $date_to);
            });
    }
    public function scopeDateSchedulledMkt(Builder $query, $date_from, $date_to, $tech_id = NULL, $referral_id = NULL,  $state = NULL, $referral_type = NULL)
{
    return $query
        ->with('scheduling')
        ->whereHas('commissions', function(Builder $q) use ($tech_id) {
            if ($tech_id != NULL) {
                $tech_id = is_array($tech_id) ? $tech_id : [$tech_id];
                $q->whereIn('user_id', $tech_id);
            }
        })
        ->when($state, function($q, $state) {
            if ($state != NULL) {
                $state = is_array($state) ? $state : [$state];
                $q->whereIn('state', $state);
            }
        })
        ->whereHas('referral', function(Builder $q) use ($referral_id, $referral_type) {
            if ($referral_id != NULL) {
                $referral_id = is_array($referral_id) ? $referral_id : [$referral_id];
                $q->whereIn('referral_id', $referral_id);
            }
            if ($referral_type != NULL) {
                $referral_type = is_array($referral_type) ? $referral_type : [$referral_type];
                $q->whereIn('referral_type_id', $referral_type);
            }

        })


        ->whereHas('scheduling', function(Builder $q) use ($date_from, $date_to) {
            $q->whereDate('start_date', '>=', $date_from)
                ->whereDate('start_date', '<=', $date_to);
        })
        ;
}

    public function scopeSchedulledSystem(Builder $query, $date, $tech_id = NULL)
    {
        return $query
            ->where('status_id', '=', 2)
            ->with('scheduling')
            ->whereHas('scheduling', function(Builder $q) use ($tech_id) {
                if ($tech_id != NULL) {
                    $q->where('tech_id', '=', $tech_id);
                }
            })
            ->whereHas('scheduling', function(Builder $q) use ($date) {
                $q->whereDate('start_date', $date);
            });
    }

    public function scopeDateBilled(Builder $query, $date_from, $date_to, $tech_id = NULL, $user_id = NULL)
    {
        return $query
            ->with('invoices')
            ->with('commissions')
            ->whereHas('commissions', function(Builder $q) use ($user_id) {
                if ($user_id != NULL) {
                    $q->where('user_id', '=', $user_id);
                }
            })
            ->whereHas('invoices', function(Builder $q) use ($date_from) {
                $q->whereDate('billed_date', '>=', $date_from);
            })
            ->whereHas('invoices', function(Builder $q) use ($date_to) {
                $q->whereDate('billed_date', '<=', $date_to);
            });
    }

    public function scopeDatePaid(Builder $query, $date_from, $date_to, $user_id = NULL)
    {
        return $query
            ->with('payments')
            ->with('commissions')
            ->whereHas('commissions', function(Builder $q) use ($user_id) {
                if ($user_id != NULL) {
                    $q->where('user_id', '=', $user_id);
                }
            })
            ->whereHas('payments', function(Builder $q) use ($date_from) {
                $q->whereDate('payment_date', '>=', $date_from);
            })
            ->whereHas('payments', function(Builder $q) use ($date_to) {
                $q->whereDate('payment_date', '<=', $date_to);
            });
    }

    public function scopeTech(Builder $query, $tech_id = NULL)
    {
        return $query
            ->with('scheduling')
            ->whereHas('scheduling', function(Builder $q) use ($tech_id) {
                if ($tech_id != NULL) {
                    $q->where('tech_id', '=', $tech_id);
                }
            });
    }

    public function scopeDateCreated(Builder $query, $date_from, $date_to, $tech_id = NULL, $job_type = NULL)
    {
        return $query
            ->with('job_types')
            ->whereHas('job_types', function(Builder $q) use ($job_type) {
                if ($job_type != NULL) {
                    $q->whereIn('assignment_job_type_id', [$job_type]);
                }
            })
            ->when($date_from, function(Builder $q, $date_from) {
                $q->whereDate('created_at', '>=', $date_from);
            })
            ->when($date_to, function(Builder $q, $date_to) {
                $q->whereDate('created_at', '<=', $date_to);
            });
    }

    public function scopeSearchTags(Builder $query, $tags = NULL)
    {
        return $query
            ->with('tags')
            ->whereHas('tags', function(Builder $q) use ($tags) {
                if ($tags != NULL) {
                    $q->whereIn('tag_id', $tags);
                }
            });
    }

    public function scopeMissingAssignments(Builder $query, $status = [], $tags = [])
    {

        return $query
            ->with('tags')
            ->whereHas('tags', function(Builder $q) use ($tags) {
                if ($tags != NULL) {
                    $q->whereIn('tag_id', $tags);
                }
            })
            ->orWhere->when($status, function(Builder $query, $status) {
                $query->whereIn('status_id', $status);
            });
    }

}