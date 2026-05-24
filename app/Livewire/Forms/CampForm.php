<?php

namespace App\Livewire\Forms;

use App\Enums\CampStatus;
use App\Enums\CampTypes;
use App\Enums\Provinces;
use App\Models\Camp;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Livewire\WithFileUploads;

class CampForm extends Form
{
    use WithFileUploads;

    public string $title = '';

    public string $description = '';

    public string $start_date = '';

    public string $end_date = '';

    public string $type = 'stage';

    public ?int $participants = null;

    public ?string $details = null;

    public ?string $constraints = null;

    public ?string $address = null;

    public ?string $number = null;

    public ?string $city = null;

    public string $province = 'liege';

    public ?int $postal_code = null;

    public array $roles = [];

    public string $status = 'draft';

    public $banner = null;

    public array $galeries = [];

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'type' => ['required', Rule::enum(CampTypes::class)],
            'participants' => ['nullable', 'integer'],
            'details' => ['nullable', 'string'],
            'constraints' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['required', Rule::enum(Provinces::class)],
            'postal_code' => ['nullable', 'integer'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(CampStatus::class)],
            'banner' => ['nullable', 'image', 'max:2048'],
            'galeries' => ['nullable', 'array'],
            'galeries.*' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function store(User $user): Camp
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'type' => $this->type,
            'participants' => $this->participants,
            'details' => $this->details,
            'constraints' => $this->constraints,
            'address' => $this->address,
            'number' => $this->number,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'roles' => $this->roles,
            'status' => $this->status,
            'user_id' => $user->id,
        ];

        if ($this->banner) {
            $data['banner'] = $this->banner->store('camps', 'public');
        }

        $camp = Camp::create($data);

        if ($this->galeries) {
            foreach ($this->galeries as $galery) {
                $camp->galeries()->create([
                    'path' => $galery->store('camps/galeries', 'public'),
                ]);
            }
        }

        return $camp;
    }

    public function update(Camp $camp): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'type' => $this->type,
            'participants' => $this->participants,
            'details' => $this->details,
            'constraints' => $this->constraints,
            'address' => $this->address,
            'number' => $this->number,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'roles' => $this->roles,
            'status' => $this->status,
            'user_id' => $camp->user_id,
        ];

        if ($this->banner) {
            if ($camp->banner) {
                Storage::disk('public')->delete($camp->banner);
            }
            $data['banner'] = $this->banner->store('camps/banners', 'public');
        }

        if ($this->galeries) {
            foreach ($this->galeries as $galery) {
                $camp->galeries()->create([
                    'path' => $galery->store('camps/galeries', 'public'),
                ]);
            }
        }

        $camp->update($data);
    }
}
