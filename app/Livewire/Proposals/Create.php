<?php

namespace App\Livewire\Proposals;

use App\Models\Project;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public Project $project;

    public bool $modal = false;

    #[Validate('required', 'email')]
    public string $email = "";

    #[Rule('required', 'numeric', 'gr:0')]
    public int $hours = 0;

    public bool $agree = false;

    public function save()
    {
        $this->validate();
        if (!$this->agree) {
            $this->addError('agree', 'Você precisa concordar com os termos para enviar a proposta.');
            return;
        }

        $this->project->proposals()
            ->updateOrCreate(
                [
                    'email' => $this->email
                ],
                [
                    'hours' => $this->hours
                ]
            );

        $this->dispatch('proposal::created');
        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.proposals.create');
    }
}
