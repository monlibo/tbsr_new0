<?php

namespace App\Test\Controller;

use App\Entity\Periodicite;
use App\Repository\PeriodiciteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PeriodiciteControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PeriodiciteRepository $repository;
    private string $path = '/edit/periodicite/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Periodicite::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Periodicite index');

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
            'periodicite[libelle]' => 'Testing',
            'periodicite[dateDebut]' => 'Testing',
            'periodicite[dateFin]' => 'Testing',
            'periodicite[createdAt]' => 'Testing',
            'periodicite[createdBy]' => 'Testing',
            'periodicite[updatedAt]' => 'Testing',
            'periodicite[updatedBy]' => 'Testing',
            'periodicite[deletedAt]' => 'Testing',
            'periodicite[deletedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects('/edit/periodicite/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Periodicite();
        $fixture->setLibelle('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setUpdatedBy('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setDeletedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Periodicite');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Periodicite();
        $fixture->setLibelle('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setUpdatedBy('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setDeletedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'periodicite[libelle]' => 'Something New',
            'periodicite[dateDebut]' => 'Something New',
            'periodicite[dateFin]' => 'Something New',
            'periodicite[createdAt]' => 'Something New',
            'periodicite[createdBy]' => 'Something New',
            'periodicite[updatedAt]' => 'Something New',
            'periodicite[updatedBy]' => 'Something New',
            'periodicite[deletedAt]' => 'Something New',
            'periodicite[deletedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/edit/periodicite/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLibelle());
        self::assertSame('Something New', $fixture[0]->getDateDebut());
        self::assertSame('Something New', $fixture[0]->getDateFin());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
        self::assertSame('Something New', $fixture[0]->getDeletedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Periodicite();
        $fixture->setLibelle('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setUpdatedBy('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setDeletedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/edit/periodicite/');
    }
}
