<?php

namespace App\Traits;

use Exception;

trait PreventModificationOfIdOne
{
	/**
	 * Deletes the record if the id is not equal to 1.
	 *
	 * @throws Exception
	 * @return void
	 */
	public function delete(): void
	{
		if (intval($this->id) === 1) {
			throw new Exception('Cannot delete record with id = 1');
		}

		parent::delete();
	}

	/**
	 * Updates the current record with the given attributes.
	 *
	 * @param array $attributes
	 * @param array $options
	 * @throws Exception
	 * @return void
	 */
	public function update(array $attributes = [], array $options = []): void
	{
		if (intval($this->id) === 1) {
			throw new Exception('Cannot update record with id = 1');
		}

		parent::update($attributes, $options);
	}
}
