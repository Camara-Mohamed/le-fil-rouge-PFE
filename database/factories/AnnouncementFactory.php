<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        $titles = [
            'Nouveau du logo',
            'Journal des anims',
            '100 ans de l’organisation',
            'Nouveaux t-shirts',
            'Designations stages & séjours',
            'Barbecue des animateurs',
        ];

        $descriptions = [
            'Mise à jour de l’identité visuelle de l’organisation.',
            'Création et diffusion du journal interne des animateurs.',
            'Organisation des festivités des 100 ans de l’association.',
            'Conception de nouveaux vêtements pour les équipes d’animation.',
            'Révision du système de désignation des animateurs pour stages et séjours.',
            'Moment convivial entre équipes autour d’un barbecue.',
        ];

        $details = [
            'Projet collaboratif impliquant plusieurs équipes afin de moderniser les outils de communication internes.',
            'Travail graphique et organisationnel autour de l’image de l’association.',
            'Coordination entre animateurs, coordinateurs et équipe communication.',
            'Amélioration de la cohérence visuelle sur les supports de terrain.',
        ];

        return [
            'title' => fake()->randomElement($titles),
            'description' => fake()->randomElement($descriptions),
            'details' => fake()->randomElement($details),
            'content' => fake()->paragraphs(3, true),
            'banner' => null,
            'user_id' => User::factory(),
            'published_at' => fake()->date('now'),
        ];
    }
}
