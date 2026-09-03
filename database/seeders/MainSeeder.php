<?php

namespace Database\Seeders;

use App\Enums\CampStatus;
use App\Enums\CampTypes;
use App\Enums\Diets;
use App\Enums\Provinces;
use App\Enums\RegisterStatus;
use App\Enums\TrainingStatus;
use App\Enums\TrainingTypes;
use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Enums\VolunteerRequestStatus;
use App\Models\Announcement;
use App\Models\Camp;
use App\Models\CampRegister;
use App\Models\ContactMessage;
use App\Models\Galerie;
use App\Models\Training;
use App\Models\TrainingRegister;
use App\Models\User;
use App\Models\VolunteerRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;

class MainSeeder extends Seeder
{
    use WithoutModelEvents;

    private function storeImage(string $publicRelativePath, string $storagePath): string
    {
        $fullPath = public_path($publicRelativePath);

        if (! file_exists($fullPath)) {
            Log::warning("[Seeder] Image source introuvable : {$fullPath}");

            return $storagePath;
        }

        Storage::put($storagePath, file_get_contents($fullPath));

        return $storagePath;
    }

    private function storeBanner(string $publicRelativePath, string $storagePath): string
    {
        $fullPath = public_path($publicRelativePath);

        if (! file_exists($fullPath)) {
            Log::warning("[Seeder] Bannière source introuvable : {$fullPath}");

            return $storagePath;
        }

        $this->storeImage($publicRelativePath, $storagePath);

        $filename = basename($storagePath);
        $variantsBase = dirname($storagePath).'/variants';

        foreach (config('banners.sizes.banner') as $width) {
            $resized = Image::decode($fullPath)->scaleDown(width: $width)->encode(new WebpEncoder(quality: config('banners.quality', 85)));
            Storage::put("{$variantsBase}/{$width}/{$filename}", (string) $resized);
        }

        return $storagePath;
    }

    private function storeAvatar(string $publicRelativePath, string $fileName): string
    {
        $this->storeImage($publicRelativePath, config('avatar.original_path').'/'.$fileName);

        foreach (config('avatar.sizes') as $size) {
            $variantPath = sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']);
            $this->storeImage($publicRelativePath, $variantPath.'/'.$fileName);
        }

        return $fileName;
    }

    public function run(): void
    {
        $users = $this->seedUsers();
        $camps = $this->seedCamps($users);
        $trainings = $this->seedTrainings($users);
        $announcements = $this->seedAnnouncements($users);
        $this->seedCampRegisters($users, $camps);
        $this->seedTrainingRegisters($users, $trainings);
        $this->seedComments($users, $camps, $trainings, $announcements);
        $this->seedContactMessages();
        $this->seedVolunteerRequests();
    }

    private function seedUsers(): array
    {
        $accountsData = [
            'mohamed' => [
                'first_name' => 'Mohamed', 'last_name' => 'Camara', 'role' => UserRoles::ADMIN,
                'birth_date' => '1997-03-15', 'phone' => '0472/51.38.37', 'address' => 'Rue du Vallon', 'number' => '12',
                'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
                'diet' => Diets::NORMAL, 'allergies' => null, 'avatar' => 'images/trainings/fun.webp',
            ],
            'stephanie' => [
                'first_name' => 'Stéphanie', 'last_name' => 'Admin', 'role' => UserRoles::ADMIN,
                'birth_date' => '1990-11-20', 'phone' => '0475/22.11.09', 'address' => 'Rue Sainte-Marguerite', 'number' => '45',
                'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
                'diet' => Diets::VEGETARIAN, 'allergies' => null, 'avatar' => 'images/trainings/fun_1.webp',
            ],
            'hugo' => [
                'first_name' => 'Hugo', 'last_name' => 'Formateur', 'role' => UserRoles::FORMATEUR,
                'birth_date' => '1988-04-02', 'phone' => '0478/63.44.21', 'address' => 'Quai de Rome', 'number' => '8',
                'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
                'diet' => Diets::NORMAL, 'allergies' => null, 'avatar' => 'images/trainings/fun_2.webp',
            ],
            'paul' => [
                'first_name' => 'Paul', 'last_name' => 'Coordinateur', 'role' => UserRoles::COORDINATEUR,
                'birth_date' => '1992-09-14', 'phone' => '0486/77.55.32', 'address' => 'Rue de Fer', 'number' => '21',
                'city' => 'Namur', 'province' => Provinces::NAMUR, 'postal_code' => '5000',
                'diet' => Diets::NORMAL, 'allergies' => null, 'avatar' => 'images/camps/holiday.webp',
            ],
            'tiffany' => [
                'first_name' => 'Tiffany', 'last_name' => 'Brevete', 'role' => UserRoles::BREVETE,
                'birth_date' => '1999-01-27', 'phone' => '0491/38.29.16', 'address' => 'Rue Saint-Gilles', 'number' => '156',
                'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
                'diet' => Diets::NORMAL, 'is_gluten_free' => true, 'allergies' => 'Allergie aux arachides.', 'avatar' => 'images/trainings/fun_3.webp',
            ],
            'luc' => [
                'first_name' => 'Luc', 'last_name' => 'Animateur', 'role' => UserRoles::ANIMATEUR_2, 'email_key' => 'luc.animateur2e',
                'birth_date' => '2001-06-09', 'phone' => '0470/91.84.53', 'address' => 'Rue du Pont', 'number' => '3',
                'city' => 'Huy', 'province' => Provinces::LIEGE, 'postal_code' => '4500',
                'diet' => Diets::NORMAL, 'allergies' => null, 'avatar' => 'images/camps/holiday_1.webp',
            ],
            'lea' => [
                'first_name' => 'Léa', 'last_name' => 'Animateur', 'role' => UserRoles::ANIMATEUR_1, 'email_key' => 'lea.animateur1re',
                'birth_date' => '2003-12-05', 'phone' => '0483/26.17.94', 'address' => 'Rue Neuvice', 'number' => '62',
                'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
                'diet' => Diets::VEGAN, 'is_lactose_free' => true, 'allergies' => null, 'avatar' => 'images/camps/holiday_2.webp',
            ],
            'sam' => [
                'first_name' => 'Sam', 'last_name' => 'Arrivant', 'role' => UserRoles::ARRIVANT, 'status' => UserStatus::INCOMPLETE,
                'birth_date' => '2004-08-30', 'phone' => '0468/17.29.40', 'address' => null, 'number' => null,
                'city' => null, 'province' => Provinces::LIEGE, 'postal_code' => null,
                'diet' => Diets::NORMAL, 'allergies' => null, 'avatar' => 'images/trainings/fun_4.webp',
            ],
        ];

        $users = [];

        foreach ($accountsData as $key => $accountData) {
            $emailKey = $accountData['email_key'] ?? "{$key}.".strtolower($accountData['role']->value);

            $users[$key] = User::factory()->create([
                'first_name' => $accountData['first_name'],
                'last_name' => $accountData['last_name'],
                'email' => "{$emailKey}@".config('app.member_email_domain'),
                'role' => $accountData['role'],
                'status' => $accountData['status'] ?? UserStatus::COMPLETE,
                'password' => Hash::make('change_this'),
                'birth_date' => $accountData['birth_date'],
                'phone' => $accountData['phone'],
                'address' => $accountData['address'],
                'number' => $accountData['number'],
                'city' => $accountData['city'],
                'province' => $accountData['province'],
                'postal_code' => $accountData['postal_code'],
                'diet' => $accountData['diet'],
                'is_gluten_free' => $accountData['is_gluten_free'] ?? false,
                'is_lactose_free' => $accountData['is_lactose_free'] ?? false,
                'allergies' => $accountData['allergies'],
                'avatar_path' => $this->storeAvatar($accountData['avatar'], "avatar_{$key}.jpg"),
            ]);
        }

        return $users;
    }

    private function seedCamps(array $users): array
    {
        $campsData = [
            'stage_1er_niveau' => [
                'title' => 'Stage Animateur 1er niveau – Été',
                'description' => 'Le point de départ de ton brevet d\'animateur (BADJ). Huit jours résidentiels en Ardenne pour apprendre à encadrer des groupes de 6 à 12 ans en toute confiance.',
                'details' => "Dynamique de groupe, construction d'activités ludiques et pédagogiques, gestion des conflits entre jeunes, cadre légal lié à l'encadrement de mineurs, sécurité physique et émotionnelle. Chaque soir une veillée thématique organisée par les participants eux-mêmes.",
                'constraints' => 'Minimum 16 ans révolus au premier jour du stage. Engagement sur les 8 jours complets obligatoire. Une fiche médicale à jour est exigée avant le départ.',
                'start' => 10, 'end' => 17, 'type' => CampTypes::STAGE, 'status' => CampStatus::PUBLISHED,
                'participants' => 20, 'city' => 'Stoumont', 'province' => Provinces::LIEGE, 'postal_code' => 4987,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE],
                'owner' => 'paul', 'image' => 'holiday',
            ],
            'sejour_ardennes' => [
                'title' => 'Séjour Découverte – Pleine Nature Ardennaise',
                'description' => 'Cinq jours en pleine nature ardennaise pour renforcer tes compétences de terrain tout en découvrant une région magnifique. Apprentissage et convivialité, dans une ambiance bienveillante.',
                'details' => 'Randonnées en autonomie avec carte et boussole, veillées à thème animées en rotation, ateliers nature (bivouac, reconnaissance de plantes, faune locale), travail en équipe sur des projets courts. Hébergements en gîte collectif, repas préparés ensemble.',
                'constraints' => null,
                'start' => 30, 'end' => 34, 'type' => CampTypes::SEJOUR, 'status' => CampStatus::PUBLISHED,
                'participants' => 15, 'city' => 'La Roche-en-Ardenne', 'province' => Provinces::LUXEMBOURG, 'postal_code' => 6980,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'paul', 'image' => 'holiday_1',
            ],
            'stage_brevet' => [
                'title' => 'Stage Brevet d\'Animateur – Session Automne',
                'description' => 'L\'étape clé du parcours BADJ, reconnue par la Fédération Wallonie-Bruxelles. Dix jours intensifs pour obtenir le brevet officiel indispensable à l\'encadrement de mineurs en Belgique.',
                'details' => "Pédagogie de projet, animation de grands groupes, gestion des situations d'urgence, cadre déontologique et réglementaire, dossier de stage individuel à remettre. Chaque participant encadre au minimum deux demi-journées d'animation réelle, observées et débriefées.",
                'constraints' => 'Minimum 18 ans au premier jour du stage. Avoir effectué le stage 1er niveau avant de s\'inscrire est obligatoire.',
                'start' => 60, 'end' => 69, 'type' => CampTypes::STAGE, 'status' => CampStatus::PENDING,
                'participants' => 12, 'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4000,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2],
                'owner' => 'paul', 'image' => 'holiday_2',
            ],
            'camp_solidarite' => [
                'title' => 'Camp Solidarité – Projet de Quartier',
                'description' => 'Cinq jours d\'engagement concret dans des quartiers liégeois en partenariat avec des associations locales. On se retrousse les manches pour contribuer à des projets qui ont un impact direct sur la vie des gens.',
                'details' => "Les participants travaillent en petits groupes autonomes avec un référent de terrain. Peinture de locaux associatifs, organisation d'activités pour des enfants, mise en place d'un potager collectif. Logement chez l'habitant ou en hébergement collectif.",
                'constraints' => null,
                'start' => 20, 'end' => 24, 'type' => CampTypes::SEJOUR, 'status' => CampStatus::PENDING,
                'participants' => 25, 'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4000,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'paul', 'image' => 'holiday_3',
            ],
            'stage_coordination' => [
                'title' => 'Stage Coordination d\'Équipe',
                'description' => 'Tu animes depuis un moment et tu veux passer à la coordination ? Ce stage intensif t\'apprend à gérer une équipe, planifier un projet sur plusieurs semaines et communiquer avec les familles et l\'administration.',
                'details' => "Mises en situation de coordination, gestion de crises et imprévus, communication assertive, répartition des rôles dans une équipe, animation de réunions et d'espaces de bilan. Travail sur des cas réels issus de l'association.",
                'constraints' => null,
                'start' => -45, 'end' => -41, 'type' => CampTypes::STAGE, 'status' => CampStatus::REFUSED,
                'participants' => 10, 'city' => 'Namur', 'province' => Provinces::NAMUR, 'postal_code' => 5000,
                'roles' => [UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'paul', 'image' => 'holiday_4',
            ],
            'stage_hivernal' => [
                'title' => 'Stage Animation Hivernal',
                'description' => 'Deux jours pour apprendre à concevoir et animer des activités d\'intérieur lors des stages en période froide. La météo ne dicte pas la qualité de l\'animation.',
                'details' => "Conception d'activités adaptées aux espaces intérieurs, gestion de l'énergie du groupe sur de longues journées confinées, veillées à thème et techniques d'animation sans matériel. Hébergement en dortoir, repas collectifs préparés en équipe.",
                'constraints' => 'Ouvert aux animateurs ayant déjà encadré au moins un stage résidentiel.',
                'start' => 50, 'end' => 51, 'type' => CampTypes::STAGE, 'status' => CampStatus::PUBLISHED,
                'participants' => 16, 'city' => 'Spa', 'province' => Provinces::LIEGE, 'postal_code' => 4900,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE],
                'owner' => 'mohamed', 'image' => 'holiday_5',
            ],
            'weekend_immersion' => [
                'title' => 'Week-end Immersion Pédagogique',
                'description' => 'Un week-end dense pour observer, expérimenter et partager. Conçu pour les membres actifs qui veulent approfondir leur pratique en conditions réelles, tous profils confondus.',
                'details' => "Observation mutuelle d'animations, feedback structuré en binômes, ateliers de co-construction d'outils pédagogiques, soirée de restitution collective. Pas de hiérarchie pendant ce week-end : on apprend ensemble.",
                'constraints' => null,
                'start' => 90, 'end' => 92, 'type' => CampTypes::SEJOUR, 'status' => CampStatus::PUBLISHED,
                'participants' => 12, 'city' => 'Huy', 'province' => Provinces::LIEGE, 'postal_code' => 4500,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::COORDINATEUR, UserRoles::FORMATEUR],
                'owner' => 'stephanie', 'image' => 'holiday_1',
            ],
            'sejour_nature_bienetre' => [
                'title' => 'Séjour Nature et Bien-être',
                'description' => 'Trois jours pour se ressourcer et repartir avec de l\'énergie. Yoga, méditation, randonnée douce et ateliers bien-être dans un cadre naturel exceptionnel.',
                'details' => "Yoga du matin, ateliers pleine conscience, cuisine saine collective, randonnée commentée, soirée astronomie. Hébergement en gîte écologique. Pas d'évaluation, juste du soin.",
                'constraints' => 'Ouvert à tous les membres actifs. Aucun niveau requis.',
                'start' => 25, 'end' => 27, 'type' => CampTypes::SEJOUR, 'status' => CampStatus::PUBLISHED,
                'participants' => 18, 'city' => 'Durbuy', 'province' => Provinces::LUXEMBOURG, 'postal_code' => 6940,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR, UserRoles::FORMATEUR],
                'owner' => 'paul', 'image' => 'holiday_3',
            ],
            'stage_multiactivites' => [
                'title' => 'Stage Multiactivités Été',
                'description' => 'Le stage estival incontournable. Dix jours en plein air pour les animateurs de première année, mixant apprentissage, aventure et convivialité.',
                'details' => 'Escalade, kayak, vélo, orienteering, nuits en bivouac, veillées, animations quotidiennes. Encadrement par deux formateurs permanents. Bilan individuel et collectif en fin de stage.',
                'constraints' => 'Avoir complété le stage 1er niveau. Savoir nager (50m minimum).',
                'start' => 100, 'end' => 109, 'type' => CampTypes::STAGE, 'status' => CampStatus::PENDING,
                'participants' => 24, 'city' => 'Coo', 'province' => Provinces::LIEGE, 'postal_code' => 4970,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2],
                'owner' => 'paul', 'image' => 'holiday_4',
            ],
            'sejour_urbain_bruxelles' => [
                'title' => 'Séjour Urbain – Bruxelles Solidaire',
                'description' => 'Trois jours à Bruxelles pour découvrir les projets associatifs de la capitale et créer des liens avec d\'autres structures de jeunesse.',
                'details' => "Visite de trois associations partenaires, rencontre avec des jeunes engagés, atelier d'échange de pratiques, soirée multiculturelle, visite de quartier guidée par des habitants.",
                'constraints' => null,
                'start' => 48, 'end' => 50, 'type' => CampTypes::SEJOUR, 'status' => CampStatus::PUBLISHED,
                'participants' => 14, 'city' => 'Bruxelles', 'province' => Provinces::BRUXELLES, 'postal_code' => 1000,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'paul', 'image' => 'holiday_5',
            ],
        ];

        $camps = [];

        foreach ($campsData as $key => $campData) {
            $camps[$key] = Camp::create([
                'title' => $campData['title'],
                'description' => $campData['description'],
                'details' => $campData['details'],
                'constraints' => $campData['constraints'],
                'start_date' => now()->addDays($campData['start'])->setTime(9, 0),
                'end_date' => now()->addDays($campData['end'])->setTime(17, 0),
                'type' => $campData['type'],
                'status' => $campData['status'],
                'participants' => $campData['participants'],
                'city' => $campData['city'],
                'province' => $campData['province'],
                'postal_code' => $campData['postal_code'],
                'roles' => array_map(fn ($role) => $role->value, $campData['roles']),
                'user_id' => $users[$campData['owner']]->id,
                'banner' => $this->storeBanner("images/camps/{$campData['image']}.webp", "camps/banners/{$key}.webp"),
            ]);

            foreach (['holiday_2', 'holiday_4'] as $galleryImage) {
                Galerie::create([
                    'camp_id' => $camps[$key]->id,
                    'path' => $this->storeImage("images/camps/{$galleryImage}.webp", "camps/galeries/{$key}_{$galleryImage}.webp"),
                ]);
            }
        }

        return $camps;
    }

    private function seedTrainings(array $users): array
    {
        $trainingsData = [
            'premiers_secours' => [
                'title' => 'Formation Premiers Secours (PSC1)',
                'description' => "Reconnue par la Croix-Rouge de Belgique, cette journée prépare à réagir calmement et efficacement face à une urgence, sur le terrain d'un stage ou en pleine nature.",
                'details' => "Gestes de survie (PLS, Heimlich, compression de plaie), réanimation cardio-pulmonaire avec mannequin, utilisation d'un défibrillateur automatisé, prise en charge des bobos courants. Une attestation de participation est remise en fin de journée.",
                'constraints' => 'Aucun prérequis. Tenue confortable recommandée pour les exercices au sol.',
                'start' => 5, 'end' => 5, 'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
                'price' => 2000, 'participants' => 16, 'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4020,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'hugo', 'image' => 'fun',
            ],
            'pedagogie_active' => [
                'title' => 'Formation Pédagogie Active et Jeu',
                'description' => 'Le jeu, c\'est du sérieux. Deux jours pour rendre tes animations plus dynamiques et engageantes, avec des outils immédiatement réutilisables.',
                'details' => "Ateliers ludiques, jeux coopératifs et de rôle, techniques de débriefing et d'animation de groupe, création d'outils pédagogiques sur mesure. Chaque participant repart avec un carnet d'activités conçu pendant la formation.",
                'constraints' => null,
                'start' => 20, 'end' => 21, 'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
                'price' => null, 'participants' => 20, 'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4020,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'hugo', 'image' => 'fun_1',
            ],
            'gestion_conflits' => [
                'title' => 'Formation Gestion des Conflits',
                'description' => 'Les tensions dans un groupe, ça arrive. Cette formation de deux jours donne les clés pour repérer les conflits naissants, agir avant l\'escalade et trouver des solutions durables.',
                'details' => "Communication non-violente appliquée à l'animation, médiation entre jeunes, gestion des émotions fortes, posture de l'animateur en situation difficile, jeux de rôle sur des cas concrets. Travail en binômes et en petits groupes.",
                'constraints' => 'Avoir au moins 6 mois d\'expérience active en animation est requis.',
                'start' => 45, 'end' => 46, 'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
                'price' => 4000, 'participants' => 14, 'city' => 'Namur', 'province' => Provinces::NAMUR, 'postal_code' => 5000,
                'roles' => [UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'hugo', 'image' => 'fun_2',
            ],
            'leadership' => [
                'title' => 'Week-end Résidentiel Leadership',
                'description' => 'Deux jours dans les Hautes Fagnes pour travailler ton leadership et apprendre à porter un projet collectif de A à Z. Idéal avant une évolution vers la coordination.',
                'details' => 'Diagnostic de son style de leadership, travail sur la communication en situation de stress, animation de réunions et de prises de décision collectives, gestion des désaccords dans une équipe. Logement et repas inclus.',
                'constraints' => 'Réservé aux animateurs ayant au minimum deux saisons d\'expérience. Places limitées à 10 participants.',
                'start' => 75, 'end' => 76, 'type' => TrainingTypes::RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
                'price' => 4000, 'participants' => 10, 'city' => 'Malmedy', 'province' => Provinces::LIEGE, 'postal_code' => 4960,
                'roles' => [UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'hugo', 'image' => 'fun_3',
            ],
            'inclusion_handicap' => [
                'title' => 'Formation Inclusion et Handicap',
                'description' => 'Comment accueillir un jeune en situation de handicap dans ton groupe sans le stigmatiser ni le mettre à l\'écart ? Des clés pratiques pour créer un environnement réellement inclusif.',
                'details' => "Tour d'horizon des différents types de handicap, adaptations concrètes d'activités existantes, communication avec les aidants et les familles, cadre légal de l'inclusion en Belgique. Intervention d'un professionnel du secteur.",
                'constraints' => null,
                'start' => 14, 'end' => 14, 'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PENDING,
                'price' => null, 'participants' => 18, 'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4000,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'hugo', 'image' => 'fun_4',
            ],
            'prevention_incendie' => [
                'title' => 'Journée Prévention Incendie et Sécurité',
                'description' => 'Une journée pratique pour connaître les bons réflexes en cas d\'incendie ou d\'accident lors de tes stages. Une formation que tout encadrant devrait avoir avant sa première prise en charge.',
                'details' => "Exercice d'évacuation chronométré, maniement d'extincteur, simulation de scénarios critiques, protocole d'appel des secours, responsabilités légales de l'encadrant. Attestation de participation remise en fin de journée.",
                'constraints' => 'Aucun prérequis. Recommandé avant toute première prise en charge de groupe résidentiel.',
                'start' => 28, 'end' => 28, 'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
                'price' => null, 'participants' => 20, 'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4000,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR, UserRoles::FORMATEUR],
                'owner' => 'mohamed', 'image' => 'fun_5',
            ],
            'coordination_avancee' => [
                'title' => 'Formation Coordination d\'Équipe Avancée',
                'description' => 'Deux jours résidentiels pour les membres expérimentés qui portent ou vont porter une équipe. On travaille en profondeur la posture du coordinateur.',
                'details' => "Diagnostic systémique d'une équipe, gestion des tensions internes, animation de réunions difficiles, culture du feedback continu, prévention du burn-out en équipe bénévole. Mises en situation filmées et débriefées.",
                'constraints' => 'Réservé aux membres ayant au minimum une saison de coordination ou de formation.',
                'start' => 65, 'end' => 66, 'type' => TrainingTypes::RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
                'price' => 5000, 'participants' => 8, 'city' => 'Spa', 'province' => Provinces::LIEGE, 'postal_code' => 4900,
                'roles' => [UserRoles::BREVETE, UserRoles::COORDINATEUR, UserRoles::FORMATEUR],
                'owner' => 'stephanie', 'image' => 'fun_1',
            ],
            'communication_bienveillante' => [
                'title' => 'Formation Communication Bienveillante',
                'description' => 'Apprends à communiquer avec les jeunes et leurs familles de façon claire, douce et efficace. Un outil indispensable pour créer un lien de confiance durable.',
                'details' => "Bases de la communication non-violente, écoute active, reformulation, gestion des émotions en situation d'animation, communication avec les parents. Ateliers en petits groupes et jeux de rôle débriefés.",
                'constraints' => null,
                'start' => 35, 'end' => 35, 'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
                'price' => null, 'participants' => 16, 'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4020,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'hugo', 'image' => 'fun_2',
            ],
            'activites_creatives' => [
                'title' => 'Formation Activités Créatives et Manuelles',
                'description' => 'Enrichis ta boîte à outils avec des dizaines d\'activités créatives adaptées aux 6-16 ans. On fabrique ensemble des outils prêts à l\'emploi pour tes stages.',
                'details' => 'Fabrication de jeux en carton, ateliers land art, initiation à la sérigraphie, création d\'instruments DIY. Chaque participant repart avec un carnet de dix activités testées et documentées.',
                'constraints' => null,
                'start' => 55, 'end' => 55, 'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
                'price' => 1500, 'participants' => 14, 'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4000,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE],
                'owner' => 'hugo', 'image' => 'fun_3',
            ],
            'soiree_decouverte' => [
                'title' => 'Soirée Découverte – Présentation de l\'Association',
                'description' => 'Tu viens de rejoindre le Fil Rouge ? Cette soirée de trois heures présente l\'association, ses valeurs et les parcours disponibles. Une façon conviviale de commencer l\'aventure.',
                'details' => "Présentation de l'association et de ses projets, témoignages de membres actifs, questions-réponses avec le bureau, moment convivial. Aucune inscription préalable requise.",
                'constraints' => null,
                'start' => 7, 'end' => 7, 'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
                'price' => null, 'participants' => 30, 'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4020,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE],
                'owner' => 'mohamed', 'image' => 'fun_4',
            ],
            'gestion_projet_associatif' => [
                'title' => 'Formation Gestion de Projet Associatif',
                'description' => 'Monter un projet de A à Z dans une association, c\'est un vrai métier. Deux jours pour définir des objectifs, répartir les tâches, gérer un budget simple et communiquer efficacement.',
                'details' => 'Objectifs SMART, planification simplifiée, gestion budgétaire associative, communication interne et externe, rétrospective de projet. Travail sur un projet réel apporté par les participants.',
                'constraints' => 'Réservé aux membres ayant au minimum 1 an d\'expérience dans l\'association.',
                'start' => 80, 'end' => 81, 'type' => TrainingTypes::RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
                'price' => 3000, 'participants' => 12, 'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4020,
                'roles' => [UserRoles::BREVETE, UserRoles::COORDINATEUR, UserRoles::FORMATEUR],
                'owner' => 'mohamed', 'image' => 'fun_5',
            ],
            'numerique_reseaux' => [
                'title' => 'Formation Numérique et Réseaux Sociaux',
                'description' => 'Les jeunes sont sur les réseaux. Cette journée donne les clés pour créer du contenu éducatif, gérer la communication d\'un stage et en parler avec les jeunes en toute lucidité.',
                'details' => "Création de contenu pédagogique, gestion d'un compte de réseau social pour une association, éducation aux médias, cyberharcèlement, droit à l'image pour les mineurs.",
                'constraints' => null,
                'start' => 42, 'end' => 42, 'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PENDING,
                'price' => null, 'participants' => 20, 'city' => 'Bruxelles', 'province' => Provinces::BRUXELLES, 'postal_code' => 1000,
                'roles' => [UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2, UserRoles::BREVETE, UserRoles::COORDINATEUR],
                'owner' => 'hugo', 'image' => 'fun',
            ],
        ];

        $trainings = [];

        foreach ($trainingsData as $key => $trainingData) {
            $trainings[$key] = Training::create([
                'title' => $trainingData['title'],
                'description' => $trainingData['description'],
                'details' => $trainingData['details'],
                'constraints' => $trainingData['constraints'],
                'start_date' => now()->addDays($trainingData['start'])->setTime(9, 0),
                'end_date' => now()->addDays($trainingData['end'])->setTime(17, 0),
                'type' => $trainingData['type'],
                'status' => $trainingData['status'],
                'price' => $trainingData['price'],
                'participants' => $trainingData['participants'],
                'city' => $trainingData['city'],
                'province' => $trainingData['province'],
                'postal_code' => $trainingData['postal_code'],
                'roles' => array_map(fn ($role) => $role->value, $trainingData['roles']),
                'user_id' => $users[$trainingData['owner']]->id,
                'banner' => $this->storeBanner("images/trainings/{$trainingData['image']}.webp", "trainings/banners/{$key}.webp"),
            ]);

            foreach (['fun_4', 'fun_5'] as $galleryImage) {
                Galerie::create([
                    'training_id' => $trainings[$key]->id,
                    'path' => $this->storeImage("images/trainings/{$galleryImage}.webp", "trainings/galeries/{$key}_{$galleryImage}.webp"),
                ]);
            }
        }

        return $trainings;
    }

    private function seedAnnouncements(array $users): array
    {
        $announcementsData = [
            'bilan_ete' => [
                'title' => 'Bilan de la saison estivale',
                'description' => 'Retour sur une saison chargée : plusieurs stages et séjours organisés partout en Wallonie, avec plus de 150 participants.',
                'content' => "Quelle saison ! Merci à tous les animateurs, coordinateurs et formateurs qui l'ont rendue possible. On remet ça encore mieux l'année prochaine.",
                'published' => 4 * 30, 'owner' => 'mohamed', 'image' => 'about',
            ],
            'appel_benevoles' => [
                'title' => 'On cherche des bénévoles pour le printemps !',
                'description' => 'Tu as du temps ce printemps ? On a besoin de toi pour encadrer nos stages. Viens nous rejoindre !',
                'content' => "Si tu es animateur, coordinateur ou formateur et que tu as des disponibilités ce printemps, on a des postes pour toi. Réunion d'info le mois prochain au local.",
                'published' => 60, 'owner' => 'stephanie', 'image' => 'camps',
            ],
            'reglement_interieur' => [
                'title' => 'Mise à jour du règlement intérieur',
                'description' => 'Petit update du règlement suite à l\'assemblée générale de janvier. Prends 5 minutes pour lire les changements.',
                'content' => "Suite à l'assemblée générale de janvier, quelques articles ont été mis à jour : procédures d'inscription aux stages, conditions d'annulation et règles en résidentiel. Le document complet est disponible sur demande.",
                'published' => 21, 'owner' => 'stephanie', 'image' => 'formations',
            ],
            'resultats_stage_brevet' => [
                'title' => 'Résultats du stage brevet – décembre',
                'description' => 'Bravo aux huit nouveaux brevetés ! Ils ont assuré lors de l\'évaluation de décembre.',
                'content' => 'Huit sur dix, c\'est le résultat du stage brevet de décembre. Un grand bravo à tous les participants, vos brevets vous seront remis à la prochaine réunion.',
                'published' => 90, 'owner' => 'mohamed', 'image' => 'hero',
            ],
            'fermeture_estivale' => [
                'title' => 'Fermeture estivale du secrétariat',
                'description' => 'Le secrétariat ferme du 15 juillet au 15 août. Les inscriptions en ligne restent ouvertes.',
                'content' => 'Cet été, le secrétariat est fermé du 15 juillet au 15 août. Pour toute urgence, écris-nous via le formulaire de contact. Les inscriptions aux formations restent ouvertes via la plateforme, on répond dès la rentrée.',
                'published' => 7, 'owner' => 'stephanie', 'image' => 'about',
            ],
            'formation_gestion_conflits' => [
                'title' => 'Nouvelle formation dispo : Gestion des conflits',
                'description' => 'Une nouvelle formation débarque en septembre à Namur. Parfaite si tu galères parfois avec les tensions dans ton groupe.',
                'content' => 'On lance une formation gestion des conflits en septembre à Namur. Deux jours pour apprendre à gérer les tensions dans un groupe de jeunes, sans perdre les pédales. Places limitées, inscris-toi vite !',
                'published' => 4, 'owner' => 'mohamed', 'image' => 'hero',
            ],
            'bienvenue_benevoles' => [
                'title' => 'Bienvenue à nos nouveaux bénévoles !',
                'description' => 'Deux nouvelles têtes rejoignent l\'équipe du Fil Rouge ce mois-ci.',
                'content' => "On est super contents d'accueillir nos deux nouvelles recrues dans l'équipe de bénévoles. Elles arrivent avec de l'expérience en maison de jeunes et une belle motivation. Bienvenue à elles !",
                'published' => 6, 'owner' => 'mohamed', 'image' => 'about',
            ],
            'ag_annuelle' => [
                'title' => 'AG annuelle – Samedi 18 octobre à 14h',
                'description' => 'L\'assemblée générale de l\'association se tient le 18 octobre. Présence fortement recommandée pour tous les membres actifs.',
                'content' => "Au programme : bilan de la saison, présentation du plan d'action, renouvellement partiel du bureau et questions diverses. Les membres actifs sont fortement invités à être présents. Un pot de clôture est prévu à l'issue.",
                'published' => 2, 'owner' => 'stephanie', 'image' => 'formations',
            ],
            'nouvelle_plateforme' => [
                'title' => 'Nouvelle plateforme en ligne !',
                'description' => 'Le Fil Rouge lance son espace numérique pour simplifier vos inscriptions et centraliser toutes les informations.',
                'content' => "Après plusieurs mois de développement, nous sommes heureux de vous présenter la nouvelle plateforme du Fil Rouge. Vous pouvez désormais consulter les formations et stages, vous inscrire en quelques clics, gérer votre profil et suivre l'état de vos inscriptions en temps réel.",
                'published' => 5, 'owner' => 'mohamed', 'image' => 'hero',
            ],
            'appel_formateurs' => [
                'title' => 'Appel à formateurs – Session automne',
                'description' => 'Vous avez de l\'expérience et envie de la transmettre ? Rejoignez notre équipe de formateurs pour la saison automne.',
                'content' => "Le Fil Rouge recherche des formateurs pour compléter son équipe. Minimum 3 ans d'expérience en animation ou coordination, brevet d'animateur ou équivalent, disponibilité sur au moins 2 week-ends. Intéressé·e ? Envoyez votre candidature via le formulaire de contact.",
                'published' => 10, 'owner' => 'mohamed', 'image' => 'camps',
            ],
            'felicitations_brevetes' => [
                'title' => 'Félicitations aux nouveaux brevetés !',
                'description' => 'Douze membres ont obtenu leur brevet d\'animateur lors de la session de juin. Bravo à toutes et tous !',
                'content' => "C'est avec une grande fierté que nous annonçons que 12 membres ont validé leur brevet d'animateur, reconnu par la Fédération Wallonie-Bruxelles. Chaque brevet est le fruit de mois de formation, de stages pratiques et d'évaluations. Félicitations à chacun d'entre eux !",
                'published' => 18, 'owner' => 'mohamed', 'image' => 'camps',
            ],
            'fermeture_fetes' => [
                'title' => 'Fermeture du secrétariat pour les fêtes',
                'description' => 'Le secrétariat sera fermé du 24 décembre au 2 janvier. Les inscriptions en ligne restent accessibles.',
                'content' => "Toute l'équipe du Fil Rouge prend une pause bien méritée pour les fêtes de fin d'année. Le secrétariat est fermé, mais la plateforme reste accessible 24h/24 pour vos inscriptions. Les réponses aux candidatures seront traitées dès la reprise. Joyeuses fêtes à tous !",
                'published' => 3, 'owner' => 'stephanie', 'image' => 'hero',
            ],
        ];

        $announcements = [];

        foreach ($announcementsData as $key => $announcementData) {
            $announcements[$key] = Announcement::create([
                'title' => $announcementData['title'],
                'description' => $announcementData['description'],
                'content' => $announcementData['content'],
                'published_at' => now()->subDays($announcementData['published']),
                'user_id' => $users[$announcementData['owner']]->id,
                'banner' => $this->storeBanner("images/home/{$announcementData['image']}.webp", "announcements/banners/{$key}.webp"),
            ]);
        }

        return $announcements;
    }

    private function seedCampRegisters(array $users, array $camps): void
    {
        $registersData = [
            ['stage_1er_niveau', 'tiffany', RegisterStatus::ACCEPTED, 'Déjà animatrice en maison de jeunes, veut valider ses acquis avec un stage officiel.'],
            ['stage_1er_niveau', 'luc', RegisterStatus::ACCEPTED, null],
            ['stage_1er_niveau', 'lea', RegisterStatus::PENDING, 'En attente de validation, niveau 1re année.'],
            ['sejour_ardennes', 'tiffany', RegisterStatus::ACCEPTED, null],
            ['sejour_ardennes', 'luc', RegisterStatus::ACCEPTED, null],
            ['sejour_ardennes', 'lea', RegisterStatus::ACCEPTED, 'Confirmée après la réunion de coordination.'],
            ['sejour_ardennes', 'paul', RegisterStatus::PENDING, 'Se confirme selon les disponibilités.'],
            ['stage_brevet', 'lea', RegisterStatus::PENDING, null],
            ['stage_brevet', 'luc', RegisterStatus::PENDING, 'Attend confirmation de son employeur pour les congés.'],
            ['stage_hivernal', 'lea', RegisterStatus::ACCEPTED, "Veut expérimenter l'animation en condition hivernale."],
            ['stage_hivernal', 'luc', RegisterStatus::PENDING, 'Attend confirmation de ses disponibilités.'],
            ['stage_hivernal', 'tiffany', RegisterStatus::ACCEPTED, null],
            ['weekend_immersion', 'lea', RegisterStatus::ACCEPTED, null],
            ['weekend_immersion', 'paul', RegisterStatus::ACCEPTED, 'Intéressé par le feedback croisé avec les formateurs.'],
            ['weekend_immersion', 'hugo', RegisterStatus::PENDING, null],
            ['sejour_nature_bienetre', 'lea', RegisterStatus::ACCEPTED, null],
            ['sejour_nature_bienetre', 'tiffany', RegisterStatus::ACCEPTED, null],
            ['sejour_nature_bienetre', 'luc', RegisterStatus::PENDING, 'Attend la réponse de son employeur.'],
            ['sejour_urbain_bruxelles', 'lea', RegisterStatus::PENDING, null],
            ['sejour_urbain_bruxelles', 'luc', RegisterStatus::ACCEPTED, null],
        ];

        foreach ($registersData as [$campKey, $userKey, $status, $notes]) {
            CampRegister::create([
                'camp_id' => $camps[$campKey]->id,
                'user_id' => $users[$userKey]->id,
                'status' => $status,
                'notes' => $notes,
            ]);
        }
    }

    private function seedTrainingRegisters(array $users, array $trainings): void
    {
        $registersData = [
            ['premiers_secours', 'tiffany', RegisterStatus::ACCEPTED, 'Renouvellement PSC1, attestation précédente expirée.'],
            ['premiers_secours', 'luc', RegisterStatus::ACCEPTED, null],
            ['premiers_secours', 'lea', RegisterStatus::ACCEPTED, null],
            ['premiers_secours', 'paul', RegisterStatus::ACCEPTED, null],
            ['pedagogie_active', 'lea', RegisterStatus::ACCEPTED, 'Veut enrichir ses outils pédago avant le stage brevet.'],
            ['pedagogie_active', 'luc', RegisterStatus::PENDING, 'Intéressé, veut tester des nouvelles méthodes avec ses groupes.'],
            ['pedagogie_active', 'tiffany', RegisterStatus::ACCEPTED, null],
            ['pedagogie_active', 'paul', RegisterStatus::ACCEPTED, null],
            ['gestion_conflits', 'tiffany', RegisterStatus::ACCEPTED, null],
            ['gestion_conflits', 'paul', RegisterStatus::PENDING, 'Situation difficile vécue cet été, veut mieux outiller.'],
            ['gestion_conflits', 'luc', RegisterStatus::ACCEPTED, 'Vécu une situation tendue cet été avec un groupe.'],
            ['leadership', 'tiffany', RegisterStatus::ACCEPTED, 'Prépare une transition vers un rôle de coordination.'],
            ['leadership', 'luc', RegisterStatus::ACCEPTED, null],
            ['leadership', 'paul', RegisterStatus::PENDING, 'Doit confirmer selon son planning de stage en parallèle.'],
            ['prevention_incendie', 'lea', RegisterStatus::ACCEPTED, null],
            ['prevention_incendie', 'luc', RegisterStatus::ACCEPTED, "Jamais eu de formation sécurité officielle, c'est important."],
            ['prevention_incendie', 'tiffany', RegisterStatus::ACCEPTED, null],
            ['prevention_incendie', 'hugo', RegisterStatus::PENDING, 'Déjà formé mais veut actualiser ses connaissances.'],
            ['coordination_avancee', 'tiffany', RegisterStatus::ACCEPTED, 'En transition vers la coordination de brevet.'],
            ['coordination_avancee', 'paul', RegisterStatus::ACCEPTED, null],
            ['coordination_avancee', 'hugo', RegisterStatus::ACCEPTED, 'Veut structurer sa pratique de formateur senior.'],
            ['communication_bienveillante', 'lea', RegisterStatus::PENDING, 'Première inscription sur la plateforme.'],
            ['communication_bienveillante', 'luc', RegisterStatus::PENDING, 'Doit confirmer avant jeudi.'],
            ['communication_bienveillante', 'tiffany', RegisterStatus::ACCEPTED, null],
            ['activites_creatives', 'lea', RegisterStatus::ACCEPTED, null],
            ['activites_creatives', 'luc', RegisterStatus::PENDING, null],
            ['soiree_decouverte', 'tiffany', RegisterStatus::ACCEPTED, null],
            ['soiree_decouverte', 'luc', RegisterStatus::REFUSED, 'Absent ce soir-là.'],
            ['gestion_projet_associatif', 'paul', RegisterStatus::PENDING, null],
        ];

        foreach ($registersData as [$trainingKey, $userKey, $status, $notes]) {
            TrainingRegister::create([
                'training_id' => $trainings[$trainingKey]->id,
                'user_id' => $users[$userKey]->id,
                'status' => $status,
                'notes' => $notes,
            ]);
        }
    }

    private function seedComments(array $users, array $camps, array $trainings, array $announcements): void
    {
        $threads = [
            [$camps['stage_1er_niveau'], [
                ['content' => 'Les jeunes sont super engagés cette année, ça fait plaisir !', 'user' => 'mohamed', 'is_admin' => true],
                ['content' => 'On fait une soirée inter-groupes le mercredi ? 👀', 'user' => 'tiffany', 'is_admin' => false],
                ['content' => 'Bonne idée Tiff, je m\'en occupe 👍', 'user' => 'mohamed', 'is_admin' => true],
            ]],
            [$camps['sejour_ardennes'], [
                ['content' => 'Les hébergements sont confirmés pour le séjour ?', 'user' => 'paul', 'is_admin' => false],
                ['content' => 'Oui c\'est bon, check tes mails 😉', 'user' => 'stephanie', 'is_admin' => true],
                ['content' => 'Est-ce qu\'on doit apporter du matériel de rando spécifique ?', 'user' => 'tiffany', 'is_admin' => false],
                ['content' => 'Juste les basiques : bonnes chaussures et cape de pluie 👍', 'user' => 'stephanie', 'is_admin' => true],
            ]],
            [$camps['stage_brevet'], [
                ['content' => 'J\'ai quelques questions sur le programme du brevet.', 'user' => 'lea', 'is_admin' => false],
                ['content' => 'Envoie-nous un mail ou passe au local !', 'user' => 'mohamed', 'is_admin' => true],
                ['content' => 'Je bosse mon dossier de stage en ce moment, vivement l\'évaluation pratique !', 'user' => 'luc', 'is_admin' => false],
            ]],
            [$camps['stage_hivernal'], [
                ['content' => 'L\'animation indoor c\'est souvent sous-estimé, contente que ça existe !', 'user' => 'tiffany', 'is_admin' => false],
                ['content' => 'Exactement ! On va vous montrer que la salle peut être aussi intense que le terrain.', 'user' => 'mohamed', 'is_admin' => true],
                ['content' => 'Des places encore disponibles ? Je n\'ai pas encore vu passer le lien d\'inscription.', 'user' => 'lea', 'is_admin' => false],
            ]],
            [$camps['weekend_immersion'], [
                ['content' => 'Observer des collègues en situation, c\'est tellement formateur. Hâte !', 'user' => 'paul', 'is_admin' => false],
                ['content' => 'On a encore quelques places, inscrivez-vous vite !', 'user' => 'stephanie', 'is_admin' => true],
            ]],
            [$trainings['premiers_secours'], [
                ['content' => 'Super formation, le formateur était vraiment top !', 'user' => 'tiffany', 'is_admin' => false],
                ['content' => 'Merci Tiff 😊 content que ça t\'ait plu.', 'user' => 'hugo', 'is_admin' => false],
                ['content' => 'Ya une autre session prévue en automne ?', 'user' => 'luc', 'is_admin' => false],
                ['content' => 'On est en train de la planifier, stay tuned 🙌', 'user' => 'stephanie', 'is_admin' => true],
            ]],
            [$trainings['pedagogie_active'], [
                ['content' => 'Hâte de tester les outils pédago avec mon groupe !', 'user' => 'lea', 'is_admin' => false],
                ['content' => 'On te réserve des surprises, à très vite 😄', 'user' => 'hugo', 'is_admin' => false],
                ['content' => 'Le carnet d\'activités qu\'on a construit ensemble, je l\'utilise encore aujourd\'hui !', 'user' => 'tiffany', 'is_admin' => false],
            ]],
            [$trainings['gestion_conflits'], [
                ['content' => 'Vraiment nécessaire cette formation, on en a besoin sur le terrain.', 'user' => 'paul', 'is_admin' => false],
                ['content' => 'Contenu d\'accord 💯 À très vite en septembre !', 'user' => 'mohamed', 'is_admin' => true],
                ['content' => 'Les jeux de rôle sur les situations de conflit, c\'était costaud mais très utile.', 'user' => 'luc', 'is_admin' => false],
            ]],
            [$trainings['leadership'], [
                ['content' => 'Week-end en Fagnes et formation leadership, combo parfait 🏔️', 'user' => 'tiffany', 'is_admin' => false],
                ['content' => 'Prépare ton dossier perso d\'avance, ça aide vraiment sur place.', 'user' => 'hugo', 'is_admin' => false],
                ['content' => 'Places encore dispo ! N\'attendez pas la dernière minute 😊', 'user' => 'mohamed', 'is_admin' => true],
            ]],
            [$trainings['prevention_incendie'], [
                ['content' => 'On devrait tous avoir ça, surtout avant un premier stage résidentiel.', 'user' => 'lea', 'is_admin' => false],
                ['content' => '100% d\'accord, c\'est pour ça qu\'on l\'a rendue accessible à tous les niveaux.', 'user' => 'mohamed', 'is_admin' => true],
                ['content' => 'J\'ai déjà eu une formation similaire mais je vais rafraîchir mes acquis.', 'user' => 'hugo', 'is_admin' => false],
            ]],
            [$trainings['coordination_avancee'], [
                ['content' => 'La gestion des désaccords dans une équipe, c\'est là que ça bugge souvent.', 'user' => 'paul', 'is_admin' => false],
                ['content' => 'C\'est exactement l\'un des fils conducteurs de cette formation !', 'user' => 'stephanie', 'is_admin' => true],
            ]],
            [$announcements['formation_gestion_conflits'], [
                ['content' => 'Enfin ! J\'attendais ça depuis un moment.', 'user' => 'luc', 'is_admin' => false],
                ['content' => 'On savait que ça allait vous plaire 😄 Inscris-toi !', 'user' => 'mohamed', 'is_admin' => true],
            ]],
            [$announcements['bienvenue_benevoles'], [
                ['content' => 'Bienvenue à elles ! Hâte de bosser ensemble 🎉', 'user' => 'paul', 'is_admin' => false],
                ['content' => 'Bienvenue les filles 🙌 On va bien s\'amuser !', 'user' => 'tiffany', 'is_admin' => false],
            ]],
            [$announcements['ag_annuelle'], [
                ['content' => 'Je serai là ! C\'est à quelle heure exactement ?', 'user' => 'luc', 'is_admin' => false],
                ['content' => 'À 14h, c\'est précisé dans l\'annonce 😉 À samedi !', 'user' => 'stephanie', 'is_admin' => true],
            ]],
        ];

        foreach ($threads as [$model, $comments]) {
            $model->comments()->createMany(array_map(fn ($comment) => [
                'content' => $comment['content'],
                'user_id' => $users[$comment['user']]->id,
                'is_admin' => $comment['is_admin'],
            ], $comments));
        }
    }

    private function seedContactMessages(): void
    {
        $messagesData = [
            ['Emma Dupont', 'emma.dupont@gmail.com', 'Inscription stage animateur', 'Bonjour, je cherche à m\'inscrire au prochain stage animateur mais je ne trouve pas le formulaire sur le site. Pouvez-vous m\'aider ?', 2],
            ['Thomas Renard', 'thomas.renard@hotmail.be', 'Prérequis stage brevet', 'Salut, j\'ai 17 ans et je voudrais faire le stage brevet. Est-ce que mon âge pose problème ? Quels sont les prérequis exactement ?', null],
            ['Antoine Masson', 'antoine.masson@outlook.com', 'Remboursement annulation', 'Bonjour, j\'ai dû annuler ma place au stage de mars pour raison médicale. Comment ça se passe pour le remboursement ?', null],
            ['Lucie Fontaine', 'lucie.fontaine@gmail.com', 'Don à l\'association', 'Bonjour, je voudrais faire un don à votre association. C\'est possible ? Et est-ce que c\'est déductible fiscalement ?', 1],
            ['Romain Charlier', 'romain.charlier@gmail.com', 'Attestation de participation', 'Bonjour, j\'ai fait le stage animateur en juillet et j\'ai besoin d\'une attestation de participation pour mon dossier.', null],
            ['Jade Mercier', 'jade.mercier@gmail.com', 'Info sur les formations', 'Salut ! Je viens d\'obtenir mon brevet, quel parcours de formation me conseillez-vous pour continuer à progresser ?', null],
            ['Antoine Dubois', 'antoine.dubois@gmail.com', 'Question sur les inscriptions', 'Bonjour, je n\'arrive pas à finaliser mon inscription au stage d\'été. Mon paiement a bien été effectué mais je ne reçois pas de confirmation.', null],
            ['Marie Fontaine', 'marie.fontaine@outlook.be', 'Demande de renseignements', 'Bonsoir, je cherche une formation aux premiers secours pour mes animateurs bénévoles. Proposez-vous des sessions en entreprise ?', null],
            ['Camille Servais', 'camille.servais@hotmail.com', 'Partenariat associatif', 'Bonjour, je représente une association de jeunesse namuroise. Nous serions intéressés par un partenariat pour co-organiser des stages l\'an prochain.', null],
            ['Isabelle Leroy', 'isa.leroy@gmail.com', 'Félicitations pour la plateforme', 'Je voulais juste vous dire que la nouvelle plateforme est vraiment bien faite ! C\'est simple, clair, et j\'ai pu m\'inscrire en 2 minutes.', 3],
        ];

        foreach ($messagesData as [$fullName, $email, $sujet, $message, $readDaysAgo]) {
            ContactMessage::create([
                'full_name' => $fullName,
                'email' => $email,
                'sujet' => $sujet,
                'message' => $message,
                'read_at' => $readDaysAgo === null ? null : now()->subDays($readDaysAgo),
            ]);
        }
    }

    private function seedVolunteerRequests(): void
    {
        $requestsData = [
            ['Camille', 'Peeters', 'camille.peeters@gmail.com', '0487/22.33.44', 'Animatrice depuis 3 ans en maison de jeunes à Seraing, je veux rejoindre l\'association pour continuer à me former et rencontrer d\'autres animateurs.', VolunteerRequestStatus::ACCEPTED, 3],
            ['Nathan', 'Dubois', 'nathan.dubois@student.uliege.be', '0476/55.66.77', 'Étudiant en sciences de l\'éducation à l\'ULiège, j\'ai mon brevet depuis 2023 et j\'ai déjà encadré quelques stages.', VolunteerRequestStatus::PENDING, null],
            ['Sofia', 'Martins', 'sofia.martins@gmail.com', '0465/11.22.33', 'Pas encore de brevet mais plein de motivation ! Je veux vraiment me former correctement, je suis partante pour commencer par le stage 1er niveau.', VolunteerRequestStatus::PENDING, null],
            ['Julien', 'Lambert', 'julien.lambert@hotmail.com', '0499/88.77.66', 'J\'ai fait plusieurs stages avec vous et j\'aimerais maintenant aider en tant que formateur bénévole. Huit ans d\'expérience en animation.', VolunteerRequestStatus::REJECTED, 5],
            ['Inès', 'Nguyen', 'ines.nguyen@gmail.com', '0478/44.55.66', 'Diplômée en animation socioculturelle, disponible tout de suite. Je parle aussi néerlandais et anglais, ce qui peut être utile pour certains groupes.', VolunteerRequestStatus::ACCEPTED, 1],
            ['Kevin', 'Marchal', 'kevin.marchal@gmail.com', '0471/55.66.77', 'Animateur depuis 4 ans dans une maison de jeunes à Seraing, je cherche une structure plus organisée pour évoluer vers la formation.', VolunteerRequestStatus::PENDING, null],
            ['Emma', 'Piron', 'emma.piron@hotmail.be', '0479/33.44.55', 'Étudiante en éducation sociale, je souhaite acquérir une expérience pratique en animation. Disponible les week-ends et pendant les vacances.', VolunteerRequestStatus::PENDING, null],
            ['David', 'Renard', 'david.renard@gmail.com', '0496/12.23.34', 'Moniteur de natation et animateur scout depuis 6 ans, brevet FWB en cours de validation. Je veux m\'investir dans une association qui forme sérieusement.', VolunteerRequestStatus::ACCEPTED, 2],
        ];

        foreach ($requestsData as [$firstName, $lastName, $email, $phone, $message, $status, $readDaysAgo]) {
            VolunteerRequest::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'message' => $message,
                'status' => $status,
                'read_at' => $readDaysAgo === null ? null : now()->subDays($readDaysAgo),
            ]);
        }
    }
}
