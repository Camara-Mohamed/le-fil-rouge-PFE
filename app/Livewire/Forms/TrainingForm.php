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
use Livewire\Form;
use Livewire\WithFileUploads;

class TrainingForm extends Form
{
    use WithFileUploads;

    public string $title = '';

    public string $description = '';

    public string $start_date = '';

    public string $end_date = '';

    public string $type = 'residential';

    public ?int $price = null;

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
            'type' => ['required', Rule::enum(TrainingTypes::class)],
            'price' => ['nullable', 'integer'],
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
            'status' => ['required', Rule::enum(TrainingStatus::class)],
            'banner' => ['nullable', 'image', 'max:2048'],
            'galeries' => ['nullable', 'array'],
            'galeries.*' => ['nullable', 'image', 'max:2048'],
        ];
    }

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
