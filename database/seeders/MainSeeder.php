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
use Illuminate\Support\Facades\Storage;

class MainSeeder extends Seeder
{
    use WithoutModelEvents;

    // Copie une image de public/ vers le disk par défaut (s3 en prod, local en dev)
    private function storeImage(string $publicRelativePath, string $storagePath): string
    {
        $fullPath = public_path($publicRelativePath);
        if (file_exists($fullPath)) {
            Storage::put($storagePath, file_get_contents($fullPath), 'public');
        }
        return $storagePath;
    }

    //Bannière et ses variants
    private function storeBanner(string $publicRelativePath, string $storagePath): string
    {
        $this->storeImage($publicRelativePath, $storagePath);

        $filename = basename($storagePath);
        $variantsBase = dirname($storagePath) . '/variants';

        foreach (config('banners.sizes.banner') as $size) {
            $this->storeImage($publicRelativePath, "{$variantsBase}/{$size}/{$filename}");
        }

        return $storagePath;
    }

    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────────────────
        $admin = User::factory()->create([
            'first_name' => 'Mohamed', 'last_name' => 'Camara',
            'email' => 'mohamed.camara@lefilrouge.com',
            'role' => UserRoles::ADMIN, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'birth_date' => '1997-03-15', 'phone' => '0472/51.38.37',
            'address' => 'Rue du Vallon', 'number' => '12',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
            'diet' => Diets::NORMAL,
        ]);

        $stephanie = User::factory()->create([
            'first_name' => 'Stéphanie', 'last_name' => 'Admin',
            'email' => 'stephanie.admin@lefilrouge.com',
            'role' => UserRoles::ADMIN, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        $hugo = User::factory()->create([
            'first_name' => 'Hugo', 'last_name' => 'Formateur',
            'email' => 'hugo.formateur@lefilrouge.com',
            'role' => UserRoles::FORMATEUR, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        $paul = User::factory()->create([
            'first_name' => 'Paul', 'last_name' => 'Coordinateur',
            'email' => 'paul.coordinateur@lefilrouge.com',
            'role' => UserRoles::COORDINATEUR, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        $tiffany = User::factory()->create([
            'first_name' => 'Tiffany', 'last_name' => 'Brevete',
            'email' => 'tiffany.brevete@lefilrouge.com',
            'role' => UserRoles::BREVETE, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        $luc = User::factory()->create([
            'first_name' => 'Luc', 'last_name' => 'Animateur_2e',
            'email' => 'paul.animateur2e@lefilrouge.com',
            'role' => UserRoles::ANIMATEUR_2, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        $lea = User::factory()->create([
            'first_name' => 'Léa', 'last_name' => 'Animateur_1re',
            'email' => 'lea.animateur1re@lefilrouge.com',
            'role' => UserRoles::ANIMATEUR_1, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        $sam = User::factory()->create([
            'first_name' => 'Sam', 'last_name' => 'Arrivant',
            'email' => 'sam.arrivant@lefilrouge.com',
            'role' => UserRoles::ARRIVANT, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        // ── Camps ──────────────────────────────────────────────────────────
        $camp1 = Camp::create([
            'title' => 'Stage Animateur 1er niveau – Été 2025',
            'description' => 'Un stage de 8 jours pour apprendre les bases de l\'anim avec des jeunes de 6 à 12 ans. Au programme : techniques d\'animation, gestion de groupe et sécurité.',
            'details' => 'Tu vas bosser sur les fondamentaux : dynamique de groupe, activités créatives, gestion des conflits et cadre légal quand tu travailles avec des mineurs.',
            'constraints' => 'T\'as besoin d\'au moins 16 ans. Engagement sur les 8 jours complets, pas de demi-mesure.',
            'start_date' => '2025-07-07 09:00', 'end_date' => '2025-07-14 17:00',
            'type' => CampTypes::STAGE, 'status' => CampStatus::CONFIRMED,
            'participants' => 20,
            'address' => 'Rue de la Lienne', 'number' => '5',
            'city' => 'Stoumont', 'province' => Provinces::LIEGE, 'postal_code' => '4987',
            'roles' => [UserRoles::ARRIVANT->value, UserRoles::ANIMATEUR_1->value],
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/camps/holiday.webp', 'camps/banners/holiday.webp'),
        ]);

        $camp2 = Camp::create([
            'title' => 'Séjour Découverte Ardennes',
            'description' => '5 jours en pleine nature ardennaise pour développer tes compétences terrain avec une équipe sympa.',
            'details' => 'Randos, veillées, ateliers nature et travail en équipe dans un cadre de ouf. Viens avec l\'envie d\'apprendre et de rigoler.',
            'start_date' => '2025-08-04 10:00', 'end_date' => '2025-08-08 16:00',
            'type' => CampTypes::SEJOUR, 'status' => CampStatus::PUBLISHED,
            'participants' => 15,
            'address' => 'Rue du Moulin', 'number' => '3',
            'city' => 'La Roche-en-Ardenne', 'province' => Provinces::LUXEMBOURG, 'postal_code' => '6980',
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value],
            'user_id' => $stephanie->id,
            'banner' => $this->storeBanner('images/camps/holiday_1.webp', 'camps/banners/holiday_1.webp'),
        ]);

        $camp3 = Camp::create([
            'title' => 'Stage Brevet d\'Animateur – Session automne',
            'description' => 'Le stage brevet reconnu par la FWB. 10 jours intensifs pour décrocher ton brevet et passer au niveau supérieur.',
            'details' => 'Programme officiel FWB. Théorie et pratique en alternance, mises en situation réelles et éval en fin de stage. On ne rigole pas mais on s\'amuse quand même.',
            'constraints' => '18 ans min. T\'as besoin d\'avoir fait le stage 1er niveau avant.',
            'start_date' => '2025-10-27 09:00', 'end_date' => '2025-11-05 17:00',
            'type' => CampTypes::STAGE, 'status' => CampStatus::PUBLISHED,
            'participants' => 12,
            'address' => 'Avenue des Tilleuls', 'number' => '18',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
            'roles' => [UserRoles::ANIMATEUR_1->value],
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/camps/holiday_2.webp', 'camps/banners/holiday_2.webp'),
        ]);

        $camp4 = Camp::create([
            'title' => 'Camp Solidarité – Projet de quartier',
            'description' => '5 jours d\'engagement concret dans des quartiers liégeois. On fait des trucs qui ont du sens, ensemble.',
            'start_date' => '2025-04-14 09:00', 'end_date' => '2025-04-18 17:00',
            'type' => CampTypes::SEJOUR, 'status' => CampStatus::PENDING,
            'participants' => 25,
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
            'user_id' => $paul->id,
        ]);

        $camp5 = Camp::create([
            'title' => 'Stage Coordination d\'équipe',
            'description' => 'T\'anime depuis un moment et t\'as envie de coordonner ? Ce stage est fait pour toi. Gestion d\'équipe, planif et communication au menu.',
            'details' => 'Mises en situation de coord, gestion de galères imprévues, travail sur le leadership sans prendre la tête.',
            'start_date' => '2025-03-10 09:00', 'end_date' => '2025-03-14 17:00',
            'type' => CampTypes::STAGE, 'status' => CampStatus::REFUSED,
            'participants' => 10,
            'city' => 'Namur', 'province' => Provinces::NAMUR, 'postal_code' => '5000',
            'user_id' => $hugo->id,
        ]);

        // ── Galeries camps ─────────────────────────────────────────────────
        foreach (['holiday_3', 'holiday_4', 'holiday_5', 'holiday_1', 'holiday_2'] as $img) {
            Galerie::create([
                'camp_id' => $camp1->id,
                'path' => $this->storeImage("images/camps/{$img}.webp", "camps/galeries/{$img}.webp"),
            ]);
        }
        foreach (['holiday', 'holiday_2', 'holiday_3'] as $img) {
            Galerie::create([
                'camp_id' => $camp2->id,
                'path' => $this->storeImage("images/camps/{$img}.webp", "camps/galeries/{$img}_c2.webp"),
            ]);
        }
        foreach (['holiday_4', 'holiday_5'] as $img) {
            Galerie::create([
                'camp_id' => $camp3->id,
                'path' => $this->storeImage("images/camps/{$img}.webp", "camps/galeries/{$img}_c3.webp"),
            ]);
        }

        // ── Camp registers ─────────────────────────────────────────────────
        CampRegister::create(['camp_id' => $camp1->id, 'user_id' => $tiffany->id, 'status' => RegisterStatus::ACCEPTED, 'notes' => 'Très motivée, a déjà animé dans son école.']);
        CampRegister::create(['camp_id' => $camp1->id, 'user_id' => $luc->id,     'status' => RegisterStatus::ACCEPTED]);
        CampRegister::create(['camp_id' => $camp1->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED, 'notes' => 'Veut consolider ses acquis du stage précédent.']);
        CampRegister::create(['camp_id' => $camp1->id, 'user_id' => $sam->id,     'status' => RegisterStatus::PENDING,  'notes' => '1ère expérience de stage, l\'air motivé.']);
        CampRegister::create(['camp_id' => $camp2->id, 'user_id' => $tiffany->id, 'status' => RegisterStatus::ACCEPTED]);
        CampRegister::create(['camp_id' => $camp2->id, 'user_id' => $paul->id,    'status' => RegisterStatus::PENDING]);
        CampRegister::create(['camp_id' => $camp2->id, 'user_id' => $sam->id,     'status' => RegisterStatus::REFUSED,  'notes' => 'Pas encore les prérequis pour ce séjour.']);
        CampRegister::create(['camp_id' => $camp3->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED]);
        CampRegister::create(['camp_id' => $camp3->id, 'user_id' => $luc->id,     'status' => RegisterStatus::PENDING]);

        // ── Trainings ──────────────────────────────────────────────────────
        $training1 = Training::create([
            'title' => 'Formation Premiers Secours (PSC1)',
            'description' => 'Tu bosses avec des jeunes ? La formation premiers secours c\'est la base. Reconnue par la Croix-Rouge de Belgique, une journée qui peut tout changer.',
            'details' => 'Gestes de survie, RCP, défibrillateur, prise en charge des bobos courants. Tout ce qu\'il faut savoir.',
            'start_date' => '2025-05-10 09:00', 'end_date' => '2025-05-10 17:00',
            'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::CONFIRMED,
            'price' => 3500, 'participants' => 16,
            'address' => 'Rue Douffet', 'number' => '36',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4020',
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $stephanie->id,
            'banner' => $this->storeBanner('images/trainings/fun.webp', 'trainings/banners/fun.webp'),
        ]);

        $training2 = Training::create([
            'title' => 'Formation Pédagogie Active et Jeu',
            'description' => 'Le jeu c\'est sérieux. Cette formation te donne des outils concrets pour rendre tes anims plus dynamiques et faire apprendre sans que ça ressemble à de l\'école.',
            'details' => 'Ateliers ludiques, jeux coopératifs, débriefing pédago et création d\'outils sur mesure. On expérimente ensemble.',
            'start_date' => '2025-06-14 09:00', 'end_date' => '2025-06-15 17:00',
            'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
            'price' => null, 'participants' => 20,
            'address' => 'Rue Douffet', 'number' => '36',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4020',
            'user_id' => $hugo->id,
            'banner' => $this->storeBanner('images/trainings/fun_1.webp', 'trainings/banners/fun_1.webp'),
        ]);

        $training3 = Training::create([
            'title' => 'Formation Gestion des Conflits',
            'description' => 'Les conflits dans un groupe, ça arrive. Cette formation t\'aide à les repérer, les prévenir et les désamorcer sans te prendre la tête.',
            'details' => 'Communication non-violente, médiation entre jeunes, gestion des émotions et posture de l\'anim. Du concret, pas du théorique.',
            'constraints' => 'Faut avoir au moins 6 mois d\'expérience en animation.',
            'start_date' => '2025-09-20 09:00', 'end_date' => '2025-09-21 17:00',
            'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
            'price' => 5000, 'participants' => 14,
            'city' => 'Namur', 'province' => Provinces::NAMUR, 'postal_code' => '5000',
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/trainings/fun_2.webp', 'trainings/banners/fun_2.webp'),
        ]);

        $training4 = Training::create([
            'title' => 'Week-end Résidentiel Leadership',
            'description' => '2 jours en résidentiel pour bosser ton leadership et apprendre à faire avancer une équipe autour d\'un projet commun. Intensif mais utile.',
            'start_date' => '2025-11-15 14:00', 'end_date' => '2025-11-16 17:00',
            'type' => TrainingTypes::RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
            'price' => 7500, 'participants' => 10,
            'address' => 'Chemin des Fagnes', 'number' => '2',
            'city' => 'Malmedy', 'province' => Provinces::LIEGE, 'postal_code' => '4960',
            'user_id' => $stephanie->id,
            'banner' => $this->storeBanner('images/trainings/fun_3.webp', 'trainings/banners/fun_3.webp'),
        ]);

        $training5 = Training::create([
            'title' => 'Formation Inclusion et Handicap',
            'description' => 'Comment accueillir un jeune en situation de handicap dans ton groupe ? Cette formation te donne les clés pour que tout le monde trouve sa place.',
            'start_date' => '2025-04-05 09:00', 'end_date' => '2025-04-05 17:00',
            'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PENDING,
            'price' => null, 'participants' => 18,
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
            'user_id' => $paul->id,
        ]);

        // ── Galeries trainings ─────────────────────────────────────────────
        foreach (['fun_1', 'fun_2', 'fun_3', 'fun_4', 'fun_5'] as $img) {
            Galerie::create([
                'training_id' => $training1->id,
                'path' => $this->storeImage("images/trainings/{$img}.webp", "trainings/galeries/{$img}.webp"),
            ]);
        }
        foreach (['fun', 'fun_3', 'fun_4'] as $img) {
            Galerie::create([
                'training_id' => $training2->id,
                'path' => $this->storeImage("images/trainings/{$img}.webp", "trainings/galeries/{$img}_t2.webp"),
            ]);
        }
        foreach (['fun_5', 'fun_2'] as $img) {
            Galerie::create([
                'training_id' => $training3->id,
                'path' => $this->storeImage("images/trainings/{$img}.webp", "trainings/galeries/{$img}_t3.webp"),
            ]);
        }

        // ── Training registers ─────────────────────────────────────────────
        TrainingRegister::create(['training_id' => $training1->id, 'user_id' => $tiffany->id, 'status' => RegisterStatus::ACCEPTED, 'notes' => 'Renouvellement PSC1.']);
        TrainingRegister::create(['training_id' => $training1->id, 'user_id' => $luc->id,     'status' => RegisterStatus::ACCEPTED]);
        TrainingRegister::create(['training_id' => $training1->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED]);
        TrainingRegister::create(['training_id' => $training1->id, 'user_id' => $paul->id,    'status' => RegisterStatus::ACCEPTED]);
        TrainingRegister::create(['training_id' => $training1->id, 'user_id' => $sam->id,     'status' => RegisterStatus::REFUSED, 'notes' => 'Inscription reçue hors délai.']);
        TrainingRegister::create(['training_id' => $training2->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED]);
        TrainingRegister::create(['training_id' => $training2->id, 'user_id' => $sam->id,     'status' => RegisterStatus::PENDING]);
        TrainingRegister::create(['training_id' => $training2->id, 'user_id' => $luc->id,     'status' => RegisterStatus::PENDING, 'notes' => 'Intéressé, veut tester des nouvelles méthodes.']);
        TrainingRegister::create(['training_id' => $training3->id, 'user_id' => $tiffany->id, 'status' => RegisterStatus::ACCEPTED]);
        TrainingRegister::create(['training_id' => $training3->id, 'user_id' => $paul->id,    'status' => RegisterStatus::PENDING]);

        // ── Announcements ──────────────────────────────────────────────────
        $ann1 = Announcement::create([
            'title' => 'Bilan de l\'été 2024',
            'description' => 'L\'été 2024 c\'était chaud. Retour sur une saison avec plus de 150 participants et 12 stages dans toute la Wallonie.',
            'content' => 'Quelle saison ! On a accueilli 152 jeunes sur 12 stages répartis partout en Wallonie. Merci à tous les anim, coord et formateurs qui ont rendu ça possible. On remet ça encore mieux l\'année prochaine.',
            'published_at' => now()->subMonths(4),
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/home/about.webp', 'announcements/banners/about.webp'),
        ]);

        Announcement::create([
            'title' => 'On cherche des bénévoles pour le printemps !',
            'description' => 'T\'as du temps cet printemps ? On a besoin de toi pour encadrer nos stages. Viens nous rejoindre !',
            'content' => 'Si t\'es anim, coord ou formateur et que t\'as des dispo ce printemps 2025, on a des postes pour toi. Réunion d\'info le 15 février à 18h au local. Viens, y\'aura des croque-monsieurs.',
            'published_at' => now()->subMonths(2),
            'user_id' => $stephanie->id,
            'banner' => $this->storeBanner('images/home/camps.webp', 'announcements/banners/camps.webp'),
        ]);

        Announcement::create([
            'title' => 'Mise à jour du règlement intérieur',
            'description' => 'Petit update du règlement suite à l\'AG de janvier. Prends 5 min pour lire les changements.',
            'content' => 'Suite à l\'AG du 12 janvier 2025, on a mis à jour quelques articles. Les principaux changements : procédures d\'inscription aux stages, conditions d\'annulation et règles en résidentiel. Le doc complet est dispo sur demande.',
            'published_at' => now()->subWeeks(3),
            'user_id' => $stephanie->id,
        ]);

        Announcement::create([
            'title' => 'Résultats du stage brevet – déc. 2024',
            'description' => 'Bravo aux 8 nouveaux brevetés ! Ils ont assuré lors de l\'éval de décembre.',
            'content' => '8 sur 10, c\'est le résultat du stage brevet de décembre 2024. Un grand bravo à Anaïs, Romain, Charlotte, Théo, Jade, Bastien, Inès et Mathieu ! Vos brevets vous seront remis à la prochaine réunion.',
            'published_at' => now()->subMonths(3),
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/home/formations.webp', 'announcements/banners/formations.webp'),
        ]);

        Announcement::create([
            'title' => 'Fermeture estivale du secrétariat',
            'description' => 'Le secrétariat ferme du 15 juillet au 15 août. Les inscriptions en ligne restent ouvertes.',
            'content' => 'Cet été, le secrétariat est fermé du 15 juillet au 15 août. Pour toute urgence, écris-nous à contact@lefilrouge.com. Les inscriptions aux formations restent ouvertes via la plateforme, on répond dès la rentrée.',
            'published_at' => now()->subWeeks(1),
            'user_id' => $stephanie->id,
        ]);

        $ann6 = Announcement::create([
            'title' => 'Nouvelle formation dispo : Gestion des conflits',
            'description' => 'Une nouvelle formation débarque en septembre à Namur. Parfaite si tu galères parfois avec les tensions dans ton groupe.',
            'content' => 'On lance une formation gestion des conflits en septembre à Namur. 2 jours pour apprendre à gérer les tensions dans un groupe de jeunes, sans perdre les pédales. Places limitées, inscris-toi vite !',
            'published_at' => now()->subDays(4),
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/home/hero.webp', 'announcements/banners/hero.webp'),
        ]);

        // ── Galeries announcements ─────────────────────────────────────────
        foreach (['holiday', 'holiday_1', 'holiday_2'] as $img) {
            Galerie::create([
                'announcement_id' => $ann1->id,
                'path' => $this->storeImage("images/camps/{$img}.webp", "announcements/galeries/{$img}.webp"),
            ]);
        }
        foreach (['fun', 'fun_1'] as $img) {
            Galerie::create([
                'announcement_id' => $ann6->id,
                'path' => $this->storeImage("images/trainings/{$img}.webp", "announcements/galeries/{$img}_a6.webp"),
            ]);
        }

        // ── Comments ───────────────────────────────────────────────────────
        $camp1->comments()->createMany([
            ['content' => 'Les jeunes sont super engagés cette année, ça fait plaisir !',      'user_id' => $admin->id,    'is_admin' => true],
            ['content' => 'On fait une soirée inter-groupes le mercredi ? Ce serait sympa 👀', 'user_id' => $tiffany->id,  'is_admin' => false],
            ['content' => 'Bonne idée Tiff, je m\'en occupe 👍',                               'user_id' => $admin->id,    'is_admin' => true],
        ]);
        $camp2->comments()->createMany([
            ['content' => 'Les hébergs sont confirmés pour le séjour ?',   'user_id' => $paul->id,      'is_admin' => false],
            ['content' => 'Oui c\'est bon, check tes mails 😉',            'user_id' => $stephanie->id, 'is_admin' => true],
        ]);
        $camp3->comments()->createMany([
            ['content' => 'J\'ai quelques questions sur le programme du brevet.',  'user_id' => $lea->id,   'is_admin' => false],
            ['content' => 'Envoie-nous un mail ou passe au local !',               'user_id' => $admin->id, 'is_admin' => true],
        ]);
        $training1->comments()->createMany([
            ['content' => 'Super formation, le formateur était vraiment top !',    'user_id' => $tiffany->id,   'is_admin' => false],
            ['content' => 'Merci Tiff 😊 content que ça t\'ait plu.',             'user_id' => $stephanie->id, 'is_admin' => true],
            ['content' => 'Ya une autre session prévue en automne ?',              'user_id' => $luc->id,       'is_admin' => false],
            ['content' => 'On est en train de la planifier, stay tuned 🙌',        'user_id' => $stephanie->id, 'is_admin' => true],
        ]);
        $training2->comments()->createMany([
            ['content' => 'Hâte de tester les outils pédago !',          'user_id' => $sam->id,  'is_admin' => false],
            ['content' => 'On te réserve des surprises, à très vite 😄', 'user_id' => $hugo->id, 'is_admin' => true],
        ]);
        $training3->comments()->createMany([
            ['content' => 'Vraiment nécessaire cette formation, on en a besoin sur le terrain.',    'user_id' => $paul->id,  'is_admin' => false],
            ['content' => 'Contenu d\'accord 💯 À très vite en septembre !',                       'user_id' => $admin->id, 'is_admin' => true],
        ]);
        $ann6->comments()->createMany([
            ['content' => 'Enfin ! J\'attendais ça depuis un moment.',             'user_id' => $luc->id,   'is_admin' => false],
            ['content' => 'On savait que ça allait vous plaire 😄 Inscris-toi !', 'user_id' => $admin->id, 'is_admin' => true],
        ]);

        // ── Contact messages ───────────────────────────────────────────────
        ContactMessage::create(['full_name' => 'Emma Dupont',    'email' => 'emma.dupont@gmail.com',       'sujet' => 'Inscription stage animateur', 'message' => 'Bonjour, je cherche à m\'inscrire au stage animateur de cet été mais je trouve pas le formulaire sur le site. Tu peux m\'aider ? Merci !', 'read_at' => now()->subDays(2)]);
        ContactMessage::create(['full_name' => 'Thomas Renard',  'email' => 'thomas.renard@hotmail.be',    'sujet' => 'Prérequis stage brevet',      'message' => 'Salut, j\'ai 17 ans et je voudrais faire le stage brevet. Est-ce que mon âge pose problème ? Quels sont les prérequis exactement ?', 'read_at' => null]);
        ContactMessage::create(['full_name' => 'Antoine Masson', 'email' => 'antoine.masson@outlook.com',  'sujet' => 'Remboursement annulation',    'message' => 'Bonjour, j\'ai dû annuler ma place au stage de mars pour raison médicale. J\'avais payé 75€. Comment ça se passe pour le remboursement ? J\'ai un certif médical.', 'read_at' => null]);
        ContactMessage::create(['full_name' => 'Lucie Fontaine', 'email' => 'lucie.fontaine@gmail.com',    'sujet' => 'Don à l\'asso',               'message' => 'Bonjour, je voudrais faire un don à votre asso. C\'est possible ? Et est-ce que c\'est déductible fiscalement ?', 'read_at' => now()->subDays(1)]);
        ContactMessage::create(['full_name' => 'Romain Charlier', 'email' => 'romain.charlier@gmail.com', 'sujet' => 'Attestation de participation', 'message' => 'Bonjour, j\'ai fait le stage animateur en juillet 2024 et j\'ai besoin d\'une attestation de participation pour mon dossier. Comment je peux l\'avoir ?', 'read_at' => null]);
        ContactMessage::create(['full_name' => 'Jade Mercier',   'email' => 'jade.mercier@gmail.com',      'sujet' => 'Info sur les formations',     'message' => 'Salut ! Je viens d\'obtenir mon brevet et je cherche ce que je peux faire comme formation maintenant pour continuer à progresser. Vous avez un parcours conseillé ?', 'read_at' => now()->subHours(3)]);

        // ── Volunteer requests ─────────────────────────────────────────────
        VolunteerRequest::create(['first_name' => 'Camille', 'last_name' => 'Peeters', 'email' => 'camille.peeters@gmail.com',         'phone' => '0487/22.33.44', 'message' => 'Animatrice depuis 3 ans dans une maison de jeunes à Seraing, je veux rejoindre Le Fil Rouge pour continuer à me former et rencontrer d\'autres anim. Dispo les week-ends et pendant les congés scolaires.', 'status' => VolunteerRequestStatus::ACCEPTED]);
        VolunteerRequest::create(['first_name' => 'Nathan',  'last_name' => 'Dubois',  'email' => 'nathan.dubois@student.uliege.be',  'phone' => '0476/55.66.77', 'message' => 'Étudiant en sciences de l\'éduc à l\'ULiège, je cherche une asso sérieuse pour compléter ma formation pratique. J\'ai mon brevet depuis 2023 et j\'ai déjà encadré quelques stages.', 'status' => VolunteerRequestStatus::PENDING]);
        VolunteerRequest::create(['first_name' => 'Sofia',   'last_name' => 'Martins', 'email' => 'sofia.martins@gmail.com',           'phone' => '0465/11.22.33', 'message' => 'Pas encore de brevet mais plein de motivation ! J\'ai déjà bossé dans plusieurs projets jeunesse et je veux vraiment me former correctement. Je suis partante pour commencer par le stage 1er niveau.', 'status' => VolunteerRequestStatus::PENDING]);
        VolunteerRequest::create(['first_name' => 'Julien',  'last_name' => 'Lambert', 'email' => 'julien.lambert@hotmail.com',        'phone' => '0499/88.77.66', 'message' => 'J\'ai fait plusieurs stages avec Le Fil Rouge et j\'aimerais maintenant aider en tant que bénévole formateur. 8 ans d\'expérience en anim, je pense pouvoir apporter quelque chose.', 'status' => VolunteerRequestStatus::REJECTED]);
        VolunteerRequest::create(['first_name' => 'Inès',    'last_name' => 'Nguyen',  'email' => 'ines.nguyen@gmail.com',             'phone' => '0478/44.55.66', 'message' => 'Diplômée en anim socioculturelle, dispo tout de suite. Je parle aussi néerlandais et anglais ce qui peut être utile pour certains groupes. J\'attends votre retour avec impatience !', 'status' => VolunteerRequestStatus::ACCEPTED]);
    }
}
