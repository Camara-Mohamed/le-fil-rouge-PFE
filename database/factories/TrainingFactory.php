<?php

namespace Database\Factories;

use App\Enums\Provinces;
use App\Enums\TrainingStatus;
use App\Enums\TrainingTypes;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingFactory extends Factory
{
    protected $model = Training::class;

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
            TrainingTypes::RESIDENTIAL,
            TrainingTypes::NON_RESIDENTIAL,
        ];

        $statuses = [
            TrainingStatus::DRAFT,
            TrainingStatus::PENDING,
            TrainingStatus::PUBLISHED,
            TrainingStatus::REFUSED,
            TrainingStatus::CONFIRMED,
        ];

        $trainings = [
            [
                'title' => 'Formation de base animateur',
                'description' => 'Acquérir les compétences fondamentales pour encadrer des enfants et adolescents en milieu associatif.',
            ],
            [
                'title' => 'Formation continue animateur',
                'description' => 'Perfectionnement des pratiques d’animation et analyse de situations vécues sur le terrain.',
            ],
            [
                'title' => 'Animation et handicap',
                'description' => 'Adapter ses activités et sa posture d’animateur auprès de publics en situation de handicap.',
            ],
            [
                'title' => 'Animation des adolescents',
                'description' => 'Comprendre les besoins des adolescents et adapter les activités d’animation.',
            ],
            [
                'title' => 'Premiers secours',
                'description' => 'Apprendre les gestes de premiers secours adaptés aux enfants et adolescents.',
            ],
            [
                'title' => 'Petite enfance : bases de l’animation',
                'description' => 'Découverte du développement de l’enfant et adaptation des activités pour les 0-6 ans.',
            ],
            [
                'title' => 'Grands jeux et animations collectives',
                'description' => 'Conception et encadrement de grands jeux en extérieur et en groupe.',
            ],
            [
                'title' => 'Communication non violente',
                'description' => 'Améliorer la gestion des conflits et la communication avec les jeunes.',
            ],
        ];

        $training = fake()->randomElement($trainings);

        return [
            'title' => $training['title'],
            'description' => $training['description'],
            'banner' => null,
            'start_date' => fake()->dateTimeBetween('+2 days', '+4 days'),
            'end_date' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
            'type' => fake()->randomElement($types),
            'price' => fake()->numberBetween(0, 180),
            'participants' => fake()->numberBetween(8, 60),
            'details' => fake()->paragraphs(3, true),
            'constraints' => fake()->paragraph(),
            'address' => fake()->streetAddress(),
            'number' => fake()->buildingNumber(),
            'city' => fake()->city(),
            'province' => fake()->randomElement($provinces),
            'postal_code' => fake()->postcode(),
            'user_id' => User::factory(),
            'roles' => json_encode([
                'animateur_1',
                'animateur_2',
                'brevete',
                'coordinateur',
                'formateur',
                'admin',
            ]),
            'status' => fake()->randomElement($statuses),
        ];
    }
}
