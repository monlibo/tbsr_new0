<?php

namespace App\Test\Controller;

use App\Entity\CategorieDocument;
use App\Repository\CategorieDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategorieDocumentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CategorieDocumentRepository $repository;
    private string $path = '/categorie/document/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(CategorieDocument::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CategorieDocument index');

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
            'categorie_document[libelle]' => 'Testing',
            'categorie_document[description]' => 'Testing',
            'categorie_document[createdAt]' => 'Testing',
            'categorie_document[createdBy]' => 'Testing',
            'categorie_document[updatedAt]' => 'Testing',
            'categorie_document[updatedBy]' => 'Testing',
            'categorie_document[deletedAt]' => 'Testing',
            'categorie_document[deletedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects('/categorie/document/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new CategorieDocument();
        $fixture->setLibelle('My Title');
        $fixture->setDescription('My Title');
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
        self::assertPageTitleContains('CategorieDocument');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new CategorieDocument();
        $fixture->setLibelle('My Title');
        $fixture->setDescription('My Title');
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
            'categorie_document[libelle]' => 'Something New',
            'categorie_document[description]' => 'Something New',
            'categorie_document[createdAt]' => 'Something New',
            'categorie_document[createdBy]' => 'Something New',
            'categorie_document[updatedAt]' => 'Something New',
            'categorie_document[updatedBy]' => 'Something New',
            'categorie_document[deletedAt]' => 'Something New',
            'categorie_document[deletedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/categorie/document/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLibelle());
        self::assertSame('Something New', $fixture[0]->getDescription());
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

        $fixture = new CategorieDocument();
        $fixture->setLibelle('My Title');
        $fixture->setDescription('My Title');
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
        self::assertResponseRedirects('/categorie/document/');
    }
}
