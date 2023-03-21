<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageFixtures extends Fixture implements FixtureGroupInterface
{
    const TMP_DIR    = '/var/tmp/photos';
    const PHOTOS_DIR = '/src/DataFixtures/images';
    const UPLOAD_DIR = '/public/uploaded/mealsimg';
    private ParameterBagInterface $params;
    private string                $rootPath;

    public static function getGroups(): array
    {
        return ['img'];
    }

    public function __construct(ParameterBagInterface $params)
    {
        $this->params   = $params;
        $this->rootPath = $this->params->get('kernel.project_dir');
    }

    public function load(ObjectManager $manager): void
    {
        $filesystem = new Filesystem();
        $finder     = new Finder();
        $faker      = Factory::create('fr_FR');

        $tmpDir        = $this->rootPath . self::TMP_DIR;
        $uploadDir     = $this->rootPath . self::UPLOAD_DIR;
        $fixturePhotos = $this->rootPath . self::PHOTOS_DIR;

        $finder->files()->in($tmpDir);

        if (!$filesystem->exists($tmpDir)) {
            $filesystem->mkdir($tmpDir, 0770);
        }

        $filesystem->remove($finder->files()->in($uploadDir));
        $filesystem->mirror($fixturePhotos, $tmpDir);

        foreach ($finder as $fileTmp) {
            $file  = new File($fileTmp->getRealPath());
            $image = new Image();

            $newImageName = Urlizer::urlize(pathinfo($fileTmp->getFilename(), PATHINFO_FILENAME)) . '-' . uniqid() . '.' . $file->guessExtension();

            $image->setImageFile($file);
            $image->setImageSize($file->getSize());
            $image->setImageName($newImageName);
            $image->setTitle($faker->sentence(3));
            $image->setDescription($faker->sentence(10));

            $filesystem->rename($tmpDir . '/' . $fileTmp->getFilename(), $tmpDir . '/' . $newImageName, true);

            $manager->persist($image);
        }

        $filesystem->mirror($tmpDir, $uploadDir);
        $manager->flush();
    }
}
