<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger\tests;

use EXSyst\Component\Swagger\Collections\Definitions;
use EXSyst\Component\Swagger\Collections\Parameters;
use EXSyst\Component\Swagger\Collections\Paths;
use EXSyst\Component\Swagger\Collections\Responses;
use EXSyst\Component\Swagger\Operation;
use EXSyst\Component\Swagger\Parameter;
use EXSyst\Component\Swagger\Path;
use EXSyst\Component\Swagger\Response;
use EXSyst\Component\Swagger\Schema;
use EXSyst\Component\Swagger\Swagger;

class CollectionsTest extends \PHPUnit_Framework_TestCase
{
    public function testDefinitions()
    {
        $swagger = new Swagger();
        $definitions = $swagger->getDefinitions();

        $this->assertTrue($definitions instanceof Definitions);
        $this->assertEquals(0, count($definitions->toArray()));
        $this->assertFalse($definitions->has('User'));

        $user = new Schema();
        $definitions->set('User', $user);
        $this->assertEquals(1, count($definitions->toArray()));
        $this->assertTrue($definitions->has('User'));
        $this->assertTrue($definitions->get('User') instanceof Schema);
        $this->assertSame($user, $definitions->get('User'));

        $this->assertTrue(is_array($definitions->toArray()['User']));

        $definitions->remove('User');
        $this->assertEquals(0, count($definitions->toArray()));
        $this->assertFalse($definitions->has('User'));
    }

    public function testPaths()
    {
        $swagger = new Swagger();
        $paths = $swagger->getPaths();

        $this->assertTrue($paths instanceof Paths);
        $this->assertEquals(0, count($paths->toArray()));
        $this->assertFalse($paths->has('/pets'));

        $pets = new Path();
        $paths->set('/pets', $pets);

        $this->assertEquals(1, count($paths->toArray()));
        $this->assertTrue($paths->has('/pets'));
        $this->assertTrue($paths->get('/pets') instanceof Path);
        $this->assertSame($pets, $paths->get('/pets'));

        $this->assertTrue(is_array($paths->toArray()['/pets']));

        $paths->remove('/pets');
        $this->assertEquals(0, count($paths->toArray()));
        $this->assertFalse($paths->has('/pets'));
    }

    public function testParameters()
    {
        $path = new Path();
        $parameters = $path->getOperation('get')->getParameters();

        $this->assertTrue($parameters instanceof Parameters);
        $this->assertEquals(0, count($parameters->toArray()));

        $id = new Parameter([
            'name' => 'id',
            'in' => 'path',
        ]);
        $parameters->add($id);
        $this->assertEquals(1, count($parameters->toArray()));
        $this->assertTrue($parameters->has('id', 'path'));
        $this->assertTrue($parameters->get('id', 'path') instanceof Parameter);

        $id2 = new Parameter([
            'name' => 'id',
            'in' => 'body',
        ]);
        $parameters->add($id2);
        $this->assertEquals(2, count($parameters->toArray()));
        $this->assertTrue($parameters->has('id', 'body'));
        $this->assertTrue($parameters->get('id', 'body') instanceof Parameter);
        $this->assertSame($id, $parameters->get('id', 'path'));
        $this->assertSame($id2, $parameters->get('id', 'body'));

        $parameter = $parameters->get('bar', 'query');
        $this->assertEquals('bar', $parameter->getName());
        $this->assertEquals('query', $parameter->getIn());

        $this->assertTrue(is_array($parameters->toArray()[0]));
        $this->assertTrue(is_array($parameters->toArray()[1]));

        $parameters->remove($id);
        $parameters->remove($id2);
        $parameters->remove($parameter);
        $this->assertEquals(0, count($parameters->toArray()));

        // test $ref
        $parameters->setRef('#/definitions/id');
        $this->assertEquals(['$ref' => '#/definitions/id'], $parameters->toArray());
    }

    public function testResponses()
    {
        $operation = new Operation();
        $responses = $operation->getResponses();

        $this->assertTrue($responses instanceof Responses);
        $this->assertEquals(0, count($responses->toArray()));
        $this->assertFalse($responses->has('200'));

        $ok = new Response();
        $responses->set('200', $ok);
        $this->assertEquals(1, count($responses->toArray()));
        $this->assertTrue($responses->has('200'));
        $this->assertTrue($responses->get('200') instanceof Response);
        $this->assertSame($ok, $responses->get('200'));

        $this->assertTrue(is_array($responses->toArray()['200']));

        $responses->remove('200');
        $this->assertEquals(0, count($responses->toArray()));
        $this->assertFalse($responses->has('200'));
    }
}
