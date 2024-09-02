<?php
	
	namespace Modules\Assignments\Entities;
	
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Support\Str;
	
	class Gallery extends Model {
		
		use HasFactory;
		
		protected $table    = 'gallery';
		
		protected $with     = ['category'];
		
		protected $fillable = [
			'assignment_id',
			'category_id',
			'created_by',
			'updated_by',
			'img_id',
			'b64',
			'type',
			'label',
		];
		
		public function category ()
		{
			return $this->hasOne(GalleryCategory::class, 'id', 'category_id');
		}
		
		public function getCreatedDateAttribute ()
		{
			
			$return = "-";
			if ( $this->created_at ) {
				$return = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('m/d/Y g:i A');
			}
			
			return $return;
		}
		
		public function getLabelAttribute ($value)
		{
			return $this->formatLabel($value ?? NULL);
		}
		
		protected function formatLabel ($value)
		{
			
			if ( is_null($value) ) {
				return NULL;
			}
			
			$prefixes = ['bf_', 'bf_of_', 'af_', 'af_of_'];
			$labelMap = [
				'the_ladder'       => 'The Ladder',
				'front_view_right' => 'Front View Right',
				'back_view_right'  => 'Back View Right',
				'front_view_left'  => 'Front View Left',
				'back_view_left'   => 'Back View Left',
				'view_left'        => 'View Left',
				'view_right'       => 'View Right',
			];
			
			$labelKey = Str::replace($prefixes, '', $value);
			$label    = ucwords($labelMap[$labelKey] ?? $labelKey);
			
			return $label;
		}
		
		protected static function newFactory ()
		{
			return \Modules\Assignments\Database\factories\GalleryFactory::new();
		}
		
	}