<?php

declare(strict_types=1);

namespace Doctrine\Tests\ORM\Functional;

use Doctrine\Tests\OrmFunctionalTestCase;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Proxy\InternalProxy;

/**
 * @group pkfk
 */
class GetReferenceOnPkFkTest extends OrmFunctionalTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createSchemaForModels(
            User::class,
            Profile::class,
            Circle::class,
            Membership::class,
        );

        // $u = new User();
        // $u->id = 1;
        // $u->name = 'John';
        
        // $p = new Profile();
        // $p->user = $u;
        // $p->url = 'https://example.com';
        
        $c = new Circle();
        $c->id = 2;
        $c->name = 'a circle';
        
        // $m = new Membership();
        // $m->user = $u;
        // $m->circle = $c;
        // $m->role = 'admin';

        // $this->_em->persist($u);
        // $this->_em->flush();
        // $this->_em->persist($p);
        // $this->_em->flush();
        $this->_em->persist($c);
        // $this->_em->flush();
        // $this->_em->persist($m);
        $this->_em->flush();
        $this->_em->clear();
    }

    public function testTest(): void
    {
        $user = $this->_em->getReference(User::class, 1);
        self::assertInstanceOf(User::class, $user);
        self::assertNotNull($user);
    }

    public function testGetReferenceAbleToGetEntitiesFromId(): void
    {
        $profile = $this->_em->getReference(Profile::class, 1);
        self::assertInstanceOf(InternalProxy::class, $profile->user);
        self::assertEquals('John', $profile->user->name);
    }

    // public function testGetReferenceAbleToGetEntitiesFromReference(): void
    // {
    //     $profile = $this->_em->getReference(Profile::class, 1);
    //     self::assertInstanceOf(InternalProxy::class, $profile->user);
    //     self::assertEquals('John', $profile->user->name);
    // }

    // public function testGetReferenceAbleToGetEntitiesFromId(): void
    // {
    //     $admin1Rome = $this->_em->getReference(Admin1::class, ['country' => 'IT', 'id' => 1]);
    //     self::assertInstanceOf(CountryProxy::class, $admin1Rome->country);
    //     self::assertEquals('Italy', $admin1Rome->country->name);
    // }

    // public function testGetReferenceAbleToGetCompositeEntitiesFromReference(): void
    // {
    //     $countryRef = $this->_em->getReference(Country::class, 'IT');
    //     $admin1Rome = $this->_em->getReference(Admin1::class, ['country' => $countryRef, 'id' => 1]);
    //     echo get_class($admin1Rome);
    //     self::assertInstanceOf(CountryProxy::class, $admin1Rome->country);
    //     self::assertEquals('Italy', $admin1Rome->country->name);
    // }
}

/**
 * @ORM\Entity
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column
     */
    public int $id;

    /**
     * @ORM\Column
     */
    public string $name;
}

/**
 * @ORM\Entity
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne
     */
    public User $user;

    /**
     * @ORM\Column
     */
    public string $url;
}

/**
 * @ORM\Entity
 */
class Circle
{
    /**
     * @ORM\Id
     * @ORM\Column
     */
    public int $id;

    /**
     * @ORM\Column
     */
    public string $name;
}

/**
 * @ORM\Entity
 */
class Membership
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne
     */
    public User $user;

    /**
     * @ORM\Id
     * @ORM\ManyToOne
     */
    public Circle $circle;

    /**
     * @ORM\Column
     */
    public string $role;
}
