<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentsLinks extends Model {

    use HasFactory;

    protected $table    = 'assignments_links';

    protected $fillable = [
        'assignment_id',
        'name',
        'link',
        'created_by'
    ];

    protected $appends  = ['link_view'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'id');
    }

    public function getLinkViewAttribute()
    {
        $rawLink = trim($this->link);

        if (!$rawLink) {
            return NULL;
        }

        // 1. Garante que o hyperlink tenha protocolo
        $hasProtocol = str_starts_with($rawLink, 'http://') || str_starts_with($rawLink, 'https://');
        $hyperlink   = $hasProtocol ? $rawLink : 'https://'.$rawLink;

        // 2. Remove protocolo
        $label = preg_replace('#^https?://#i', '', $rawLink);

        // 3. Remove www.
        $label = preg_replace('#^www\.#i', '', $label);

        // 4. Remove query string
        $label = explode('?', $label)[0];

        // 5. Remove tudo após a primeira "/"
        $label = explode('/', $label)[0];

        return [
            'label'     => 'www.'.$label,
            'hyperlink' => $hyperlink,
        ];
    }

    protected static function boot ()
    {
        parent::boot();

        $user    = auth()->user();
        $userId = $user->id ?? 73;

        static::creating(function ( $model ) use ( $userId ) {
            $model->created_by = $userId;
        });
    }

}