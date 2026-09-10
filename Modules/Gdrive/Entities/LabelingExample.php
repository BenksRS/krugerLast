<?php

namespace Modules\Gdrive\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LabelingExample extends Model
{
    protected $table = 'labeling_examples';

    protected $fillable = [
        'image_path', 'description', 'category', 'note', 'job_number', 'active', 'created_by',
    ];

    protected $casts = ['active' => 'boolean'];

    public function absolutePath(): string
    {
        return storage_path('app/' . $this->image_path);
    }

    public function getPreviewUrlAttribute(): ?string
    {
        return route('gdrive.labeling_example_image', ['id' => $this->id]);
    }

    public function deleteFile(): void
    {
        if ($this->image_path && Storage::disk('local')->exists($this->image_path)) {
            Storage::disk('local')->delete($this->image_path);
        }
    }
}
