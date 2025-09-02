<?php

namespace Tests\Unit;

use App\Services\ResumeService;
use PHPUnit\Framework\TestCase;

class ResumeServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_scrub_id_returns_smaller_or_same_array(): void
    {
        #function removes id column
        $arrayOne = ['id' => '2'];
        $newArray = ResumeService::scrubId($arrayOne,'id');
        $this->assertTrue(count($newArray)===0);

        #column with alternative id column name
        $arrayOne = ['type_id' => 2];
        $newArray = ResumeService::scrubId($arrayOne,'id');
        $this->assertEmpty($newArray);

        #function returns empty on empty empty object
        $arrayOne = [];
        $newArray = ResumeService::scrubId($arrayOne,'id');
        $this->assertIsArray($newArray);
        $this->assertEmpty($newArray);

        #array preserves shape
        $arrayOne= ['type_id' => 2, 'col' => ['id' => '3']];
        $newArray = ResumeService::scrubId($arrayOne,'id');
        $this->assertNotEmpty($newArray);
        $this->assertTrue(count($newArray) === 1);
        $this->assertNotContains(2,$newArray);
        $this->assertTrue(current($newArray) === []);
        $this->assertEquals('col',current(array_keys($newArray)));

        $arrayOne= ['type_id' => 2, 'col' => ['id' => '3', 'zoink' => [2]]];
        $newArray = ResumeService::scrubId($arrayOne,'id');
        $this->assertNotEmpty($newArray);
        $this->assertTrue(count($newArray) === 1);
        $this->assertNotContains(2,$newArray);
        $this->assertNotTrue(current($newArray) === []);
        $this->assertTrue(current($newArray)['zoink'] === [2]);
        
        $newArray = ResumeService::scrubId($arrayOne,'col');
        $this->assertTrue(array_pop($newArray) === 2);

        #function does not remove columns with arbitraty "id"
        $arrayOne= ['zoid' => 2, 'identity' => 'element'];
        $newArray = ResumeService::scrubId($arrayOne,'id');
        $this->assertNotEmpty($newArray);
        $this->assertEquals($arrayOne,$newArray);



    }
}
