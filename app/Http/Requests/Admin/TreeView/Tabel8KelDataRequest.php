<?php

namespace App\Http\Requests\Admin\TreeView;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class Tabel8KelDataRequest extends FormRequest
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
		if ($this->routeIs('admin.treeview.delapankeldata.store')) {
			return [
				'parent_id' => [
					'required',
					'integer',
					'exists:tabel_8keldata,id'
				],
				'nama_menu' => [
					'required',
					'string',
					'min:1',
					'max:200'
				],
				'skpd_id' => [
					'required',
					'integer',
					'exists:skpd,id'
				]
			];
		} else if ($this->routeIs('admin.treeview.delapankeldata.update')) {
			return [
				'parent_id' => [
					'required',
					'integer',
					'exists:tabel_8keldata,id'
				],
				'nama_menu' => [
					'required',
					'string',
					'min:1',
					'max:200'
				],
			];
		} else if ($this->routeIs('admin.treeview.delapankeldata.massDestroy')) {
			return [
				'ids' => [
					'required',
					'array'
				],
				'ids.*',
				[
					'integer',
					'exists:tabel_8keldata,id'
				]
			];
		} else {
			return [];
		}
	}

}
