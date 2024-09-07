<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilePendukungRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'file_pendukung' => [
				'required',
				'array',
			],
			'file_pendukung.*' => [
				'max:25600',
				'mimes:jpeg,png,gif,bmp,svg,webp,mp4,avi,mov,wmv,flv,mkv,webm,3gp,pdf,doc,docx,xls,xlsx,txt,rtf,csv,ppt,pptx,odp'
			],
		];
	}
}
