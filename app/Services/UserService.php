<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserService
{
	/**
	 * Deletes the avatar image if it exists in the public disk.
	 *
	 * @param string $path
	 * @return void
	 */
	public function deleteAvatar(?string $path): void
	{
		if (!empty($path) && Storage::disk('public')->exists($path)) {
			Storage::disk('public')->delete($path);
		}
	}
}
