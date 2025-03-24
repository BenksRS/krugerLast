<?php

    namespace Modules\Password\Entities;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Modules\User\Entities\User;

    class Password extends Model {

        use HasFactory;

        protected $fillable = ['name', 'description', 'url', 'username', 'password', 'is_admin', 'created_by', 'updated_by'];

        public function user_created ()
        {
            return $this->belongsTo(User::class, 'created_by');
        }

        public function user_updated ()
        {
            return $this->belongsTo(User::class, 'updated_by');
        }

        protected static function newFactory ()
        {
            return \Modules\Password\Database\factories\PasswordFactory::new();
        }

        protected static function boot ()
        {
            parent::boot();

            $user    = auth()->user();
            $userId = $user->id ?? 73;

            static::creating(function ( $model ) use ( $userId ) {
                $model->created_by = $userId;
                $model->updated_by = $userId;
            });

            static::updating(function ( $model ) use ( $userId ) {
                $model->updated_by = $userId;
            });
        }

    }