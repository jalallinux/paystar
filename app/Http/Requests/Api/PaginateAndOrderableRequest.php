<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

abstract class PaginateAndOrderableRequest extends FormRequest
{
    public function orderBy(): string
    {
        return 'created_at';
    }

    public function orderType(): string
    {
        return $this->query('orderType','desc');
    }

    public function rules(): array
    {
        return array_merge($this->defaultRules(), $this->addRules());
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'page' => $this->query('page', 1),
            'perPage' => $this->query('perPage', 15),
            'orderBy' => $this->query('orderBy', $this->orderBy()),
            'orderType' => $this->orderType(),
        ]);
    }

    protected function orderedColumns(): array
    {
        return ['created_at', 'updated_at'];
    }

    protected function addRules(): array
    {
        return [];
    }

    protected function defaultRules(): array
    {
        return [
            'page' => ['required', 'numeric', 'min:1'],
            'perPage' => ['required', 'numeric', 'min:-1', 'max:100'],
            'orderBy' => ['required', 'in:' . implode(',', $this->orderedColumns())],
            'orderType' => ['required_with:orderBy', 'in:asc,desc,ASC,DESC'],
        ];
    }
}
