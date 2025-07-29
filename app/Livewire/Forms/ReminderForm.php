<?php

namespace App\Livewire\Forms;

use App\Models\Reminder;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ReminderForm extends Form
{
    #[Validate('required|max:255')]
    public string $title = '';

    #[Validate('required|max:16')]
    public string $color = '';

    #[Validate('required', 'date')]
    public string $datetime = '';

    #[Validate('boolean|nullable')]
    public bool $is_completed = false;

    #[Validate('required', 'integer', 'exists:users,id')]
    public ?int $user_id = null;

    public Reminder $reminder;

    public function init(Reminder $reminder): void
    {
        $this->reminder = $reminder;
        $this->user_id = auth()->id();

        if ($reminder->exists){
            $this->title = $reminder->title;
            $this->color = $reminder->color;
            $this->datetime = $reminder->datetime->startOfMinute();
            $this->is_completed = (bool) $reminder->is_completed;
        }
    }

    public function save(array $recurrence): void
    {
        $data = $this->validate();

        $data['recurrence'] = $recurrence;

        $this->reminder->fill($data)->save();
    }
}
