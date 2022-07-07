<?php

namespace Modules\Core\Utils\Database\Mixins;

use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;

/**
 * @mixin Blueprint
 */
class SchemaMixin {

	public function fk ()
	{
		/**
		 * @param string $foreign
		 * @param string $table
		 * @param string $references
		 * @param bool   $nullable
		 *
		 * @return \Illuminate\Database\Schema\ForeignKeyDefinition
		 */
		return function ($foreign, $table, $references = 'id', $nullable = FALSE) {
			return $this
				->foreignId($foreign)
				->nullable($nullable)
				->constrained($table)
				->references($references);
		};
	}

	public function by ()
	{
		/**
		 * @param mixed $foreign
		 * @param bool  $nullable
		 *
		 */
		return function ($foreign = 'user_id', $nullable = FALSE) {

			$table = new Expression('users');

			if ( !is_array($foreign) ) $foreign = [$foreign];

			foreach ( $foreign as $key ) {
				$this->foreignId($key)->nullable($nullable)->constrained($table)->onUpdate('cascade');
			}

			return $this;
		};
	}

	public function at ()
	{
		/**
		 * @param mixed $columns
		 * @param bool  $nullable
		 *
		 */
		return function ($columns, $nullable = TRUE) {

			if ( !is_array($columns) ) $columns = [$columns];

			foreach ( $columns as $column ) {
				$this->timestamp($column)->nullable($nullable);
			}

			return $this;
		};
	}

	public function address ()
	{
		return function () {

			$this->text('street')->nullable();
			$this->text('city')->nullable();
			$this->text('state')->nullable();
			$this->text('zipcode')->nullable();

			return $this;
		};
	}

	public function phone ()
	{
		return function () {

			$this->string('contact')->nullable();
			$this->string('phone');
			$this->status('preferred');

			return $this;
		};
	}

	public function status ()
	{
		return function ($column, $default = 'N') {

			return $this->enum($column, ['Y', 'N'])->default($default);
		};
	}

	public function activityModel ()
	{
		/**
		 * @param string|array $columns
		 * @param string       $table
		 */
		return function (array|string $columns = ['created_by', 'updated_by'], string $table = 'users') {

			if ( is_array($columns) ) {
				foreach ( $columns as $column ) {
					$this->foreignId($column)->nullable()->constrained(new Expression($table))->onUpdate('cascade');
				}
			} else {
				$this->foreignId($columns)->constrained(new Expression($table))->onUpdate('cascade');
			}
		};
	}

}