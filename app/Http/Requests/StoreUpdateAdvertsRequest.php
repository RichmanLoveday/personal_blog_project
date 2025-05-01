<?php

namespace App\Http\Requests;

use App\Models\AdvertPlacement;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateAdvertsRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'start_date' => 'required|date|date_format:d-m-Y',
            'end_date' => 'required|date|date_format:d-m-Y|after:start_date',
            'url' => 'required|url',
            'placements' => 'required|array|min:1',
            'placements.*.image' => 'required_without:placements.*.id|nullable|image|mimes:jpeg,png,jpg|max:5000',
            'placements.*.position' => 'required|string|max:255',
            'placements.*.page' => 'required|string|max:255',
        ];
    }



    public function after()
    {
        return [
            function ($validator) {
                //? loop through placements

                foreach ($this->placements as $index => $placement) {
                    dd($placement);
                    //? call checkIfPositionAndPagesCombinationExist for each placement
                    if (!isset($placement['position']) || !isset($placement['page']) || isset($placement['id']))
                        continue;

                    if ($this->checkIfPositionAndPagesCombinationExist($placement['position'], $placement['page'])) {
                        //? if true, add error to validator
                        $validator->errors()->add(
                            "placements.{$index}.page",
                            'This combination of position and page already exists for another advert.'
                        );
                    }
                }
            }
        ];
    }


    public function checkIfPositionAndPagesCombinationExist(string $position, string $page): bool
    {
        //? check combination on advertPlacement table
        $placementCombination = AdvertPlacement::where('position', $position)
            ->where('page', $page)
            ->exists();

        if ($placementCombination) return true;

        return false;
    }
}
