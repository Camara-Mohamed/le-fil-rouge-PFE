<?php

namespace App\Livewire\Forms;

use App\Enums\Provinces;
use App\Enums\TrainingStatus;
use App\Enums\TrainingTypes;
use App\Jobs\ProcessUploadedImage;
use App\Models\Training;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum as EnumRule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class TrainingForm extends Form
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:255')]
    public string $description = '';

    #[Validate('required|date')]
    public string $start_date = '';

    #[Validate('required|date|after:start_date')]
    public string $end_date = '';

    #[Validate(['required', new EnumRule(TrainingTypes::class)])]
    public string $type = 'residential';

    #[Validate('nullable|integer')]
    public ?int $price = null;

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

    #[Validate(['roles' => 'nullable|array', 'roles.*' => 'nullable|string'])]
    public array $roles = [];

    #[Validate(['required', new EnumRule(TrainingStatus::class)])]
    public string $status = 'draft';

    #[Validate('nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048')]
    public $banner = null;

    #[Validate(['galeries' => 'nullable|array', 'galeries.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'])]
    public array $galeries = [];

    public function store(User $user): Training
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'type' => $this->type,
            'price' => $this->price,
            'participants' => $this->participants,
            'details' => $this->details,
            'constraints' => $this->constraints,
            'address' => $this->address,
            'number' => $this->number,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'roles' => $this->roles,
            'status' => TrainingStatus::PENDING,
            'user_id' => $user->id,
        ];

        if ($this->banner) {
            $path = $this->banner->store('trainings/banners', 'public');
            $data['banner'] = $path;
            ProcessUploadedImage::dispatch(
                $path,
                config('banners.paths.trainings.variants'),
                config('banners.sizes.banner')
            );
        }

        $training = Training::create($data);

        if ($this->galeries) {
            foreach ($this->galeries as $galery) {
                $path = $galery->store('trainings/galeries', 'public');
                $training->galeries()->create(['path' => $path]);
                ProcessUploadedImage::dispatch(
                    $path,
                    config('banners.paths.galeries.trainings'),
                    config('banners.sizes.galerie')
                );
            }
        }

        return $training;
    }

    public function update(Training $training): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'type' => $this->type,
            'price' => $this->price,
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
            'user_id' => $training->user_id,
        ];

        if ($this->banner) {
            if ($training->banner) {
                Storage::disk('public')->delete($training->banner);
            }
            $path = $this->banner->store('trainings/banners', 'public');
            $data['banner'] = $path;
            ProcessUploadedImage::dispatch(
                $path,
                config('banners.paths.trainings.variants'),
                config('banners.sizes.banner')
            );
        }

        if ($this->galeries) {
            foreach ($this->galeries as $galery) {
                $path = $galery->store('trainings/galeries', 'public');
                $training->galeries()->create(['path' => $path]);
                ProcessUploadedImage::dispatch(
                    $path,
                    config('banners.paths.galeries.trainings'),
                    config('banners.sizes.galerie')
                );
            }
        }

        $training->update($data);

        $this->banner = null;
        $this->galeries = [];
    }
}
