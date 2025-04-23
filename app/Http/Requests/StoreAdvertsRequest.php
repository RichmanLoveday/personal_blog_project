<?php

namespace App\Http\Requests;

use App\Models\AdvertPlacement;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertsRequest extends FormRequest
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
            'start_date' => 'required|date|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date|date_format:Y-m-d H:i:s|after:start_date',
            'url' => 'nullable|url',
            'placements' => 'required|array|min:1',
            'placecents.*image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'placements.*.position' => 'required|string|max:255',
            'placements.*.page' => 'required|string|max:255',
        ];
    }


    public function messages()
    {
        return [
            'title.required' => 'Please enter title',
            'start_date.required' => 'Please enter start date',
            'end_date.required' => 'Please enter end date',
            'url.url' => 'Please enter a valid URL',
            'placements.required' => 'Please select at least one placement',
            'placements.array' => 'Invalid placements format',
            'placements.*position.required' => 'Please select a position for each placement',
            'placements.*page.required' => 'Please select a page for each placement',
            'placecents.*.image.required' => 'Please upload an image for each placement',
            'placecents.*.image.image' => 'The file must be an image',
            'placecents.*.image.mimes' => 'The image must be a file of type: jpeg, png, jpg',
            'placecents.*.image.max' => 'The image may not be greater than 2MB',
        ];
    }


    public function after()
    {
        return [
            function ($validator) {
                //? loop through placements

                foreach ($this->placements as $index => $placement) {
                    //? call checkIfPositionAndPagesCombinationExist for each placement
                    if (!isset($placement['position']) || !isset($placement['page'])) continue;

                    if ($this->checkIfPositionAndPagesCombinationExist($placement['position'], $placement['page'])) {
                        //? if true, add error to validator
                        $validator->errors()->add(
                            'placements.',
                            'Adverts name already exist, please change'
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
