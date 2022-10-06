<?php

namespace Modules\Assignments\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AssignmentScope {

    public function scopeOfStatus (Builder $query, $status = [1, 11, 12, 17])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeOpen (Builder $query, $status = [1, 2, 3, 4, 8, 11, 12, 14, 15, 17, 18, 19, 20, 21, 22, 23, 28, 14, 29, 27])
    {

        return $query->whereIn('status_id', collect($status))->whereNotNull('id');

    }

    public function scopeRequestDocusign (Builder $query, $status = [29])
    {

        return $query->whereIn('status_id', collect($status))->whereNotNull('id');

    }

    public function scopeDocusignSent (Builder $query, $status = [14])
    {

        return $query->whereIn('status_id', collect($status))->whereNotNull('id');

    }

    public function scopeMessageSent (Builder $query, $status = [28])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeNojobs (Builder $query, $status = [8])
    {

        return $query->whereIn('status_id', collect($status))->whereNotNull('id');

    }

    public function scopeMessages (Builder $query, $status = [1])
    {

        return $query->whereIn('status_id', collect($status))->whereNotNull('id');

    }

    public function scopeReadytobill (Builder $query, $status = [4])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeRevisebill (Builder $query, $status = [24])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeCollection (Builder $query, $status = [5, 9, 10,])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeLandline (Builder $query, $status = [30])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeLate (Builder $query, $status = [27])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeThig (Builder $query, $status = [31])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeUniv (Builder $query, $status = [32])
    {
        return $query->whereIn('status_id', collect($status))->whereNotNull('id');
    }

    public function scopeTextJobs (Builder $query, $date, $status = [2])
    {
        return $query
            ->with('scheduling')
            ->whereHas('scheduling', function (Builder $q) use ($date) {
                $q->whereDate('start_date', $date);
            })->whereIn('status_id', collect($status))->whereNotNull('id');

    }

    public function scopeSearchtop (Builder $query, $search)
    {
        return $query
            ->when($search, function ($query, $search) {
                $query
                    ->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('claim_number', 'like', '%' . $search . '%');

            });
    }

    public function scopeSearch (Builder $query, $search)
    {

        $search = trim($search);

        return $query
            ->when($search, function ($query, $search) {
                $query
                    ->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('street', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('state', 'like', '%' . $search . '%')
                    ->orWhere('zipcode', 'like', '%' . $search . '%')
                    ->orWhere('claim_number', 'like', '%' . $search . '%')
                    ->orWhere->searchReferral($search)
                    ->orWhere->searchPhones($search);
            });
    }

    public function scopeSearchReferral (Builder $query, $search)
    {
        return $query
            ->with(['referral', 'carrier'])
            ->whereHas('referral', function (Builder $q) use ($search) {
                $q->where('company_entity', 'like', '%' . $search . '%');
            })
            ->orWhereHas('carrier', function (Builder $q) use ($search) {
                $q->where('company_entity', 'like', '%' . $search . '%');
            });
    }

    public function scopeSearchPhones (Builder $query, $search)
    {
        return $query
            ->with('phones')
            ->whereHas('phones', function (Builder $q) use ($search) {
                $q->where('phone', 'like', '%' . $search . '%');
            });
    }

    public function scopeDateSchedulled (Builder $query, $date_from, $date_to, $tech_id = NULL, $job_type = NULL)
    {
        return $query
            ->with('scheduling')
            ->with('job_types')
            ->whereHas('scheduling', function (Builder $q) use ($tech_id) {
                if ( $tech_id != NULL ) {
                    $q->where('tech_id', '=', $tech_id);
                }
            })
            ->whereHas('job_types', function (Builder $q) use ($job_type) {
                if ( $job_type != NULL ) {
                    $q->whereIn('assignment_job_type_id', [$job_type]);
                }
            })
            ->whereHas('scheduling', function (Builder $q) use ($date_from) {
                $q->whereDate('start_date', '>=', $date_from);
            })
            ->whereHas('scheduling', function (Builder $q) use ($date_to) {
                $q->whereDate('start_date', '<=', $date_to);
            });
    }

    public function scopeSchedulledSystem (Builder $query, $date, $tech_id = NULL)
    {
        return $query
            ->with('scheduling')
            ->whereHas('scheduling', function (Builder $q) use ($tech_id) {
                if ( $tech_id != NULL ) {
                    $q->where('tech_id', '=', $tech_id);
                }
            })
            ->whereHas('scheduling', function (Builder $q) use ($date) {
                $q->whereDate('start_date', $date);
            });
    }

    public function scopeDateBilled (Builder $query, $date_from, $date_to, $tech_id = NULL, $user_id = NULL)
    {
        return $query
            ->with('invoices')
            ->with('commissions')
            ->whereHas('commissions', function (Builder $q) use ($user_id) {
                if ( $user_id != NULL ) {
                    $q->where('user_id', '=', $user_id);
                }
            })
            ->whereHas('invoices', function (Builder $q) use ($date_from) {
                $q->whereDate('billed_date', '>=', $date_from);
            })
            ->whereHas('invoices', function (Builder $q) use ($date_to) {
                $q->whereDate('billed_date', '<=', $date_to);
            });
    }

    public function scopeDatePaid (Builder $query, $date_from, $date_to, $user_id = NULL)
    {
        return $query
            ->with('payments')
            ->with('commissions')
            ->whereHas('commissions', function (Builder $q) use ($user_id) {
                if ( $user_id != NULL ) {
                    $q->where('user_id', '=', $user_id);
                }
            })
            ->whereHas('payments', function (Builder $q) use ($date_from) {
                $q->whereDate('payment_date', '>=', $date_from);
            })
            ->whereHas('payments', function (Builder $q) use ($date_to) {
                $q->whereDate('payment_date', '<=', $date_to);
            });
    }

    public function scopeTech (Builder $query, $tech_id = NULL)
    {
        return $query
            ->with('scheduling')
            ->whereHas('scheduling', function (Builder $q) use ($tech_id) {
                if ( $tech_id != NULL ) {
                    $q->where('tech_id', '=', $tech_id);
                }
            });
    }

    public function scopeDateCreated (Builder $query, $date_from, $date_to, $tech_id = NULL, $job_type = NULL)
    {
        return $query
            ->with('job_types')
            ->whereHas('job_types', function (Builder $q) use ($job_type) {
                if ( $job_type != NULL ) {
                    $q->whereIn('assignment_job_type_id', [$job_type]);
                }
            })
            ->when($date_from, function (Builder $q, $date_from) {
                $q->whereDate('created_at', '>=', $date_from);
            })
            ->when($date_to, function (Builder $q, $date_to) {
                $q->whereDate('created_at', '<=', $date_to);
            });
    }

}
