<?php

namespace App\Http\Requests\Activities;

use App\Models\Activity;
use App\Rules\Activities\ScheduledDateRule;
use Illuminate\Foundation\Http\FormRequest;

class AddActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create', Activity::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Activity::$rules;
        $rules = array_merge_recursive($rules, [
            'scheduled_at' => [new ScheduledDateRule()],
        ]);

        return $rules;
    }
}
