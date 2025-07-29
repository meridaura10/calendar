<?php

namespace App\Livewire\Reminder;

use App\Livewire\Forms\ReminderForm;
use App\Models\Reminder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class Form extends Component
{
    public ReminderForm $form;

    public string $type = 'none';

    public array $days = [];

    public int $month = 0;

    public array $yearly = [
        'day' => 0,
        'month' => 0,
    ];

    public function mount(Reminder $reminder): void
    {
        $this->form->init($reminder);

        if($reminder->recurrence){
            $this->setRecurrence(json_decode($reminder->recurrence));
        }
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setRecurrence(object $reminder): void
    {
        if ($reminder->type == 'none' || $reminder->type == 'daily') {
            return;
        }

        if ($reminder->type === 'days' || $reminder->type === 'yearly'){
            $this->{$reminder->type} = (array) $reminder->data;
        }
    }

    public function getRecurrence(): array
    {
        $data = ['type' => $this->type];


        if ($this->type === 'none' || $this->type === 'daily') {
            $data['data'] = null;
        } else {
            $data['data'] = $this->{$data['type']};
        }

        return $data;
    }

    public function save(): Redirector
    {
        if (isset($this->form->reminder->id)){
            $this->authorize('destroy', $this->form->reminder);
        }

        $this->form->save($this->getRecurrence());

        return redirect()->route('calendar.index')->with('success', 'Нагадування збережено!');
    }

    public function render(): View
    {
        return view('livewire.reminder.form');
    }
}
