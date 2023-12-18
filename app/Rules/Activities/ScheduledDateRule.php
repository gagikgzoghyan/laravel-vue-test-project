<?php

namespace App\Rules\Activities;

use App\Models\Activity;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ScheduledDateRule implements ValidationRule
{
    /**
     * @var Activity|null
     */
    private $activity;

    /**
     * @param Activity|null $activity
     */
    public function __construct(Activity $activity = null)
    {
        $this->activity = $activity;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->activity || $this->activity->scheduled_at !== $value) {
            $scheduledActivities = Activity::query()->where('scheduled_at', $value)->count();

            if ($scheduledActivities > 3) {
                $fail(__('validation.max_activity_count'));
            }
        }
    }
}
