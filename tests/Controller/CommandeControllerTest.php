<?php

namespace App\Test\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CommandeRepository $repository;
    private string $path = '/commande/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Commande::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Commande index');

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
            'commande[nombre]' => 'Testing',
            'commande[addresse_commande]' => 'Testing',
            'commande[nom_prenom_commande]' => 'Testing',
            'commande[tel_commande]' => 'Testing',
        ]);

        self::assertResponseRedirects('/commande/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commande();
        $fixture->setNombre('My Title');
        $fixture->setAddresse_commande('My Title');
        $fixture->setNom_prenom_commande('My Title');
        $fixture->setTel_commande('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Commande');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commande();
        $fixture->setNombre('My Title');
        $fixture->setAddresse_commande('My Title');
        $fixture->setNom_prenom_commande('My Title');
        $fixture->setTel_commande('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'commande[nombre]' => 'Something New',
            'commande[addresse_commande]' => 'Something New',
            'commande[nom_prenom_commande]' => 'Something New',
            'commande[tel_commande]' => 'Something New',
        ]);

        self::assertResponseRedirects('/commande/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre());
        self::assertSame('Something New', $fixture[0]->getAddresse_commande());
        self::assertSame('Something New', $fixture[0]->getNom_prenom_commande());
        self::assertSame('Something New', $fixture[0]->getTel_commande());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Commande();
        $fixture->setNombre('My Title');
        $fixture->setAddresse_commande('My Title');
        $fixture->setNom_prenom_commande('My Title');
        $fixture->setTel_commande('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/commande/');
    }
}
