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
            'start_date' => 'required|date|date_format:d-m-Y',
            'end_date' => 'required|date|date_format:d-m-Y|after:start_date',
            'url' => 'required|url',
            'placements' => 'required|array|min:1',
            'placements.*.image' => 'required_without:placements.*.id|nullable|image|mimes:jpeg,png,jpg|max:5000',
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
            'placements.*.position.required' => 'Please select a position for each placement',
            'placements.*.page.required' => 'Please select a page for each placement',
            'placements.*.image.required' => 'Please upload an image for each placement',
            'placements.*.image.image' => 'The file must be an image',
            'placements.*.image.mimes' => 'The image must be a file of type: jpeg, png, jpg',
            'placements.*.image.max' => 'The image may not be greater than 2MB',
        ];
    }


    public function after()
    {
        return [
            function ($validator) {
                //? loop through placements

                foreach ($this->placements as $index => $placement) {
                    //? call checkIfPositionAndPagesCombinationExist for each placement
                    if (!isset($placement['position']) || !isset($placement['page']))
                        continue;

                    //? if id was given, check if the combination exist in the advertPlacement table
                    if ($this->checkIfCombinationExistForGivenId($placement['id'] ?? null, $placement['position'], $placement['page'])) {
                        //? if true, continue to next iteration
                        continue;
                    }

                    //? if not, check if the combination exist in the advertPlacement table
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


    /**
     * Check if a combination of position and page exists in the AdvertPlacement table.
     *
     * This method checks whether a specific combination of `position` and `page`
     * exists in the `AdvertPlacement` model. It is used to ensure that no duplicate
     * combinations are created for advert placements.
     *
     * @param string $position The position to check for.
     * @param string $page The page to check for.
     * @return bool True if the combination exists, false otherwise.
     */
    public function checkIfPositionAndPagesCombinationExist(string $position, string $page): bool
    {
        // Check combination in the AdvertPlacement table
        $placementCombination = AdvertPlacement::where('position', $position)
            ->where('page', $page)
            ->exists();

        if ($placementCombination) return true;

        return false;
    }


    /**
     * Check if a combination of position and page exists for a given AdvertPlacement ID.
     *
     * This method verifies whether a specific combination of `position` and `page`
     * exists in the `AdvertPlacement` model for the provided ID. If the ID is not
     * provided (null), the method will return false.
     *
     * @param int|null $id The ID of the AdvertPlacement to check (nullable).
     * @param string $position The position to check for.
     * @param string $page The page to check for.
     * @return bool True if the combination exists for the given ID, false otherwise.
     */
    public function checkIfCombinationExistForGivenId(?int $id, string $position, string $page): bool
    {
        if (isset($id)) {
            $placementCombination = AdvertPlacement::where('id', $id)
                ->where('position', $position)
                ->where('page', $page)
                ->exists();

            if ($placementCombination) return true;
        }

        return false;
    }
}
