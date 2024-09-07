<?php

namespace App\Http\Requests\Admin\TreeView;

use Illuminate\Foundation\Http\FormRequest;

class TabelBpsRequest extends FormRequest
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
		if ($this->routeIs('admin.treeview.bps.store')) {
			return [
				'parent_id' => [
					'required',
					'integer',
					'exists:tabel_bps,id'
				],
				'nama_menu' => [
					'required',
					'string',
					'min:1',
					'max:255'
				]
			];
		} else if ($this->routeIs('admin.treeview.bps.update')) {
			return [
				'parent_id' => [
					'required',
					'integer',
					'exists:tabel_bps,id'
				],
				'nama_menu' => [
					'required',
					'string',
					'min:1',
					'max:200'
				]
			];
		} else if ($this->routeIs('admin.treeview.bps.massDestroy')) {
			return [
				'ids' => [
					'required',
					'array'
				],
				'ids.*',
				[
					'integer',
					'exists:tabel_bps,id'
				]
			];
		} else {
			return [

			];
		}
	}
}
