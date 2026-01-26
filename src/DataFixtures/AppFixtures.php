<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $imagesPath = __DIR__ . '/../../public/uploads/images';
        $files = [];
        if (is_dir($imagesPath)) {
            $files = array_values(array_filter(scandir($imagesPath), function ($f) {
                return !in_array($f, ['.', '..']);
            }));
        }

        // fallback: if no files found, create nothing
        if (count($files) === 0) {
            $manager->flush();
            return;
        }

        // create admin and owner users if they don't exist
        $userRepo = $manager->getRepository(\App\Entity\User::class);
        $existingAdmin = $userRepo->findOneBy(['email' => 'admin@example.com']);
        if (!$existingAdmin) {
            $admin = new \App\Entity\User();
            $admin->setEmail('admin@example.com');
            $admin->setPassword(password_hash('adminpass', PASSWORD_BCRYPT));
            $admin->setFirstName('Admin');
            $admin->setLastName('User');
            $admin->setRoles(['ROLE_ADMIN']);
            // role_user field used elsewhere; set to 'admin' for clarity
            if (method_exists($admin, 'setRoleUser')) {
                $admin->setRoleUser('admin');
            }
            $admin->setPhone(11111111);
            $admin->setAddresse('Admin address');
            $manager->persist($admin);
        }

        $existingOwner = $userRepo->findOneBy(['email' => 'owner@example.com']);
        if (!$existingOwner) {
            $user = new \App\Entity\User();
            $user->setEmail('owner@example.com');
            // store a bcrypt-hashed password so security accepts it
            $user->setPassword(password_hash('password123', PASSWORD_BCRYPT));
            $user->setFirstName('Owner');
            $user->setLastName('Example');
            if (method_exists($user, 'setRoleUser')) {
                $user->setRoleUser('owner');
            }
            $user->setPhone(12345678);
            $user->setAddresse('Default address');
            $manager->persist($user);
        }

        // lazy-create Category, Terrain and Image entities
        for ($ci = 1; $ci <= 3; $ci++) {
            $category = new \App\Entity\Category();
            $category->setName('Category ' . $ci);
            $category->setDescription('Auto-generated category ' . $ci);
            // pick a random image as category image if setter exists
            if (method_exists($category, 'setImage')) {
                $category->setImage($files[array_rand($files)]);
            }
            $manager->persist($category);

            for ($ti = 1; $ti <= 2; $ti++) {
                $terrain = new \App\Entity\Terrain();
                $terrain->setName('Terrain ' . $ci . '-' . $ti);
                $terrain->setPrice(50 + $ti * 10);
                $terrain->setadresse('Address ' . $ci . '-' . $ti);
                $terrain->setCategory($category);
                $terrain->setUser($user);
                $terrain->setHours(new \DateTime('08:00'));
                $terrain->setPause(new \DateTime('12:00'));
                $manager->persist($terrain);

                $image = new \App\Entity\Image();
                $image->setName($files[array_rand($files)]);
                $image->setTerrain($terrain);
                $manager->persist($image);
            }
        }

        $manager->flush();
    }
}
