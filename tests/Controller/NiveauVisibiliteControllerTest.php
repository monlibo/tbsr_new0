<?php

namespace App\Test\Controller;

use App\Entity\NiveauVisibilite;
use App\Repository\NiveauVisibiliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NiveauVisibiliteControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private NiveauVisibiliteRepository $repository;
    private string $path = '/niveauvisibilite/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(NiveauVisibilite::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('NiveauVisibilite index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'niveau_visibilite[code]' => 'Testing',
            'niveau_visibilite[libelle]' => 'Testing',
            'niveau_visibilite[createdAt]' => 'Testing',
            'niveau_visibilite[createdBy]' => 'Testing',
            'niveau_visibilite[updatedAt]' => 'Testing',
            'niveau_visibilite[updatedBY]' => 'Testing',
            'niveau_visibilite[deletedAt]' => 'Testing',
            'niveau_visibilite[deletedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects('/niveauvisibilite/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new NiveauVisibilite();
        $fixture->setCode('My Title');
        $fixture->setLibelle('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setUpdatedBY('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setDeletedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('NiveauVisibilite');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new NiveauVisibilite();
        $fixture->setCode('My Title');
        $fixture->setLibelle('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setUpdatedBY('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setDeletedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'niveau_visibilite[code]' => 'Something New',
            'niveau_visibilite[libelle]' => 'Something New',
            'niveau_visibilite[createdAt]' => 'Something New',
            'niveau_visibilite[createdBy]' => 'Something New',
            'niveau_visibilite[updatedAt]' => 'Something New',
            'niveau_visibilite[updatedBY]' => 'Something New',
            'niveau_visibilite[deletedAt]' => 'Something New',
            'niveau_visibilite[deletedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/niveauvisibilite/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCode());
        self::assertSame('Something New', $fixture[0]->getLibelle());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedBY());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
        self::assertSame('Something New', $fixture[0]->getDeletedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new NiveauVisibilite();
        $fixture->setCode('My Title');
        $fixture->setLibelle('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setUpdatedBY('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setDeletedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/niveauvisibilite/');
    }
}
