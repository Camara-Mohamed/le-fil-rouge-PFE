<?php

namespace App\Livewire\Forms;

use App\Enums\CampStatus;
use App\Enums\CampTypes;
use App\Enums\Provinces;
use App\Enums\UserRoles;
use App\Models\Camp;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum as EnumRule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CampForm extends Form
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:1000')]
    public string $description = '';

    #[Validate('required|date')]
    public string $start_date = '';

    #[Validate('required|date|after:start_date')]
    public string $end_date = '';

    #[Validate(['required', new EnumRule(CampTypes::class)])]
    public string $type = 'stage';

    #[Validate('nullable|integer')]
    public ?int $participants = null;

    #[Validate('nullable|string')]
    public ?string $details = null;

    #[Validate('nullable|string')]
    public ?string $constraints = null;

    #[Validate('nullable|string|max:255')]
    public ?string $address = null;

    #[Validate('nullable|string|max:20')]
    public ?string $number = null;

    #[Validate('nullable|string|max:255')]
    public ?string $city = null;

    #[Validate(['required', new EnumRule(Provinces::class)])]
    public string $province = 'liege';

    #[Validate('nullable|integer')]
    public ?int $postal_code = null;

    #[Validate(['roles' => 'nullable|array', 'roles.*' => ['nullable', new EnumRule(UserRoles::class)]])]
    public array $roles = [];

    #[Validate(['required', new EnumRule(CampStatus::class)])]
    public string $status = 'pending';

    #[Validate('nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048')]
    public $banner = null;

    #[Validate(['galeries' => 'nullable|array', 'galeries.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'])]
    public array $galeries = [];

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
            'status' => CampStatus::PENDING,
            'user_id' => $user->id,
        ];

        if ($this->banner) {
            $data['banner'] = $this->banner->store('camps', 's3');
        }

        $camp = Camp::create($data);

        if ($this->galeries) {
            foreach ($this->galeries as $galery) {
                $camp->galeries()->create([
                    'path' => $galery->store('camps/galeries', 's3'),
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
                Storage::disk('s3')->delete($camp->banner);
            }
            $data['banner'] = $this->banner->store('camps/banners', 's3');
        }

        if ($this->galeries) {
            foreach ($this->galeries as $galery) {
                $camp->galeries()->create([
                    'path' => $galery->store('camps/galeries', 's3'),
                ]);
            }
        }

        $camp->update($data);

        $this->banner = null;
        $this->galeries = [];
    }
}
