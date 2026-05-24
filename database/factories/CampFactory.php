<?php

namespace Database\Factories;

use App\Enums\CampStatus;
use App\Enums\CampTypes;
use App\Enums\Provinces;
use App\Models\Camp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampFactory extends Factory
{
    protected $model = Camp::class;

    public function definition(): array
    {
        $provinces = [
            Provinces::ANVERS,
            Provinces::BRABANT_WALLON,
            Provinces::BRUXELLES,
            Provinces::FLANDRE_OCCIDENTALE,
            Provinces::FLANDRE_ORIENTALE,
            Provinces::HAINAUT,
            Provinces::LIEGE,
            Provinces::LIMBOURG,
            Provinces::LUXEMBOURG,
            Provinces::NAMUR,
            Provinces::BRABANT_FLAMAND,
        ];

        $types = [
            CampTypes::STAGE,
            CampTypes::SEJOUR,
        ];

        $statuses = [
            CampStatus::DRAFT,
            CampStatus::PENDING,
            CampStatus::PUBLISHED,
            CampStatus::REFUSED,
            CampStatus::CONFIRMED,
        ];

        $camps = [
            [
                'title' => 'Stage à la mer du Nord',
                'description' => 'Activités sportives, jeux de plage et découverte du littoral belge.',
            ],
            [
                'title' => 'Séjour en Ardenne',
                'description' => 'Immersion en pleine nature : randonnée, orientation et vie en groupe.',
            ],
            [
                'title' => 'École des devoirs',
                'description' => 'Encadrement scolaire et soutien pédagogique pour enfants et adolescents.',
            ],
            [
                'title' => 'Accueil de vacances – Chênée',
                'description' => 'Activités ludiques et créatives pour enfants durant les congés scolaires à Chênée.',
            ],
            [
                'title' => 'Ski en montagne',
                'description' => 'Séjour sportif à la montagne : ski, snowboard et vie en chalet.',
            ],
            [
                'title' => 'La Boverie – camp artistique',
                'description' => 'Activités culturelles et artistiques autour du musée et de la création.',
            ],
            [
                'title' => 'Mini-camp nature en Ardenne',
                'description' => 'Découverte de la faune et flore avec jeux extérieurs et bivouac.',
            ],
            [
                'title' => 'Stage multi-activités à la mer',
                'description' => 'Sports nautiques, jeux collectifs et animations en bord de mer.',
            ],
        ];

        $camp = fake()->randomElement($camps);

        return [
            'title' => $camp['title'],
            'description' => $camp['description'],
            'banner' => null,
            'start_date' => fake()->dateTimeBetween('+2 days', '+4 days'),
            'end_date' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
            'type' => fake()->randomElement($types),
            'participants' => fake()->numberBetween(6, 12),
            'details' => fake()->paragraphs(3, true),
            'constraints' => fake()->paragraph(),
            'address' => fake()->streetAddress(),
            'number' => fake()->buildingNumber(),
            'city' => fake()->city(),
            'province' => fake()->randomElement($provinces),
            'postal_code' => fake()->postcode(),
            'user_id' => User::factory(),
            'roles' => [
                'animateur_1',
                'animateur_2',
                'brevete',
                'coordinateur',
                'formateur',
                'admin',
            ],
            'status' => fake()->randomElement($statuses),
        ];
    }
}
